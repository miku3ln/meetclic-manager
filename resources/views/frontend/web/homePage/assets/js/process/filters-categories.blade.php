<script id="filters-categories-script">
    Vue.component('filters-categories-component', {
        template: '#filters-categories-template',
        directives: {
            resetModel: {
                inserted: function (el, binding, vnode, vm, arg) {
                    var paramsInput = binding.value;
                    paramsInput._resetModel(paramsInput.model);


                },
            },
            initMapManager: {
                inserted: function (el, binding, vnode) {
                    var paramsInput = binding.value || {};
                    var ctx = vnode.context;

                    // espera a que el DOM esté estable
                    ctx.$nextTick(function () {
                        console.log("element estable");

                        if (typeof paramsInput.functionInit === "function") {
                            paramsInput.functionInit({
                                objSelector: el,

                            });
                        } else {
                            console.warn("initS2Manager: functionInit no es función", paramsInput);
                        }
                    });
                },

                unbind: function (el) {
                    console.log("unbind");
                }
            }

        },
        props: {
            params: {
                type: Object,
            }
        },
        created: async function () {
            console.log(this.params.data);
            var vmCurrent = this;
            this.$root.$on(this.nameComponent, function (emitValue) {
                console.log("emitValue", emitValue);
            });
            this.initDataByParent();
            this.sendDataParent({action: 'created', child: this.nameComponent});
            var dataParent = this.params.data;
            var latLng = dataParent.latLng;
            var locationCheck = dataParent.locationCheck;
            var latLngData = {
                lat: latLng[0],
                lng: latLng[1],
            }

            this.addressInformation.lat = latLngData.lat;
            this.addressInformation.lng = latLngData.lng;
            this.distanceKm = dataParent.distanceKm;
            console.log("created", this.distanceKm);
            this.locationCheck = locationCheck;
            if (locationCheck) {
                await this.getAddressInformation(latLngCurrent);
            }

            this.filtersInit.distanceKm = dataParent.distanceKm;
            this.filtersInit.locationCheck = locationCheck;
            this.filtersInit.locationCheck.lat = latLng[0];
            this.filtersInit.location.lng = latLng[1];


        },
        beforeMount: function () {

        },
        mounted: function () {

        },
        data: function () {
            var dataManager = {
                nameComponent: "filters-categories",
                categoriesData: [],
                selectedCategoryIds: [],     // [1,2,3]
                selectedSubcategoryIds: [],  // [10,11]
                openCategoryIds: [],         // categorías expandidas
                distanceKm: -1,
                locationCheck: false,
                filtersInit: {
                    locationCheck: false,
                    distanceKm: -1,
                    location: {
                        lat: -1,
                        lng: -1
                    },

                },
                addressInformation: {
                    country: "S/N",
                    state: "S/N",
                    city: "S/N",
                    district: "S/N",
                    street: "S/N",
                    houseNumber: "S/N",
                    formattedAddress: "S/N",
                    formattedAddressView: "S/N",
                    streetView: "S/N",
                    lat: 0,
                    lng: 0,

                },
                locationManagement: {
                    view: false,
                    element: "#map-main-view",
                    leafletMap: null,
                    locateControl: null,
                    myLocationMarker: null,
                    markerInformation: null
                },
                labelsProcessConfig: {
                    filters: {
                        titleEarnYapitas: '{{__("filters.titleEarnYapitas")}}',
                        btnSearchTasks: '{{__("filters.btnSearchTasks")}}',
                        btnReset: '{{__("filters.btnReset")}}',

                        toggleNearMe: '{{__("filters.toggleNearMe")}}',

                        location: {
                            title: '{{__("filters.location.title")}}',
                            streetLabel: '{{__("filters.location.streetLabel")}}',
                            cityLine: '{{__("filters.location.cityLine")}}',
                            latLabel: '{{__("filters.location.latLabel")}}',
                            lngLabel: '{{__("filters.location.lngLabel")}}',
                        },

                        distance: {
                            title: '{{__("filters.distance.title")}}',
                            helper: '{{__("filters.distance.helper")}}',
                            km: '{{__("filters.distance.km")}}',
                            from: '{{__("filters.distance.from")}}',
                            to: '{{__("filters.distance.to")}}',
                        },

                        categories: {
                            title: '{{__("filters.categories.title")}}',
                            helper: '{{__("filters.categories.helper")}}',
                            empty: '{{__("filters.categories.empty")}}',
                        },

                        subcategories: {
                            empty: '{{__("filters.subcategories.empty")}}',
                        },

                        actions: {
                            apply: '{{__("filters.actions.apply")}}',
                            close: '{{__("filters.actions.close")}}',
                        }
                    }
                }
            };
            return dataManager;
        },
        methods: {
            viewMap: function (params) {
                var latLng = [
                    this.addressInformation.lat,
                    this.addressInformation.lng,
                ];

                this.initLeafletMap({latLng: latLng});
            },
            destroyLeafletMap: function () {
                // ✅ si existe, lo destruyes
                if (this.locationManagement.leafletMap) {
                    // quitar eventos (opcional pero recomendado)
                    if (this.locationManagement.leafletMapClickHandler) {
                        this.locationManagement.leafletMap.off('click', this.locationManagement.leafletMapClickHandler);
                        this.locationManagement.leafletMapClickHandler = null;
                    }
                    this.locationManagement.leafletMap.off();   // quita todos los listeners
                    this.locationManagement.leafletMap.remove(); // ✅ destruye el mapa y libera el contenedor
                    this.locationManagement.leafletMap = null;
                }

                // ✅ extra: limpia el contenedor por si Leaflet dejó nodos
                const el = $(this.locationManagement.element)[0];
                if (el) el.innerHTML = "";
            },
            initLeafletMap: function (params) {
                $this = this;
                const mapCurrentSelect = $(this.locationManagement.element)[0];
                // ✅ importante: destruir antes de crear uno nuevo
                this.destroyLeafletMap();
                var latLng = params["latLng"];
                if (mapCurrentSelect) {
                    const map = L.map(mapCurrentSelect).setView(latLng, 13); // Establece la vista inicial
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    }).addTo(map);
                    let $sope = this;
                    map.on('click', function (event) {
                        console.log("click map")
                        //$sope.generateViewDataPosition({event:event,customIcon:customIcon,map:map});
                    });
                    map.whenReady(function () {
                        console.log('✅ whenReady: mapa listo')

                    });
                    this.locationManagement.leafletMap = map;
                    var markerInformation = this.addMarker({
                        markerInformation: {latLng: latLng},
                        map: map
                    });
                    this.locationManagement.markerInformation = markerInformation;
                    this.addCurrentLocationButton(map);
                }

            },
            addMarker: function (params) {
                var marker = params["markerInformation"];
                var map = params["map"];
                var $scopeCurrent = this;
                const customIcon = L.icon({
                    iconUrl: $publicAsset + '/templates/cityBookHtml/images/marker.png', // URL de la imagen del ícono
                    iconSize: [32, 32],  // Tamaño del ícono
                    iconAnchor: [16, 32], // Punto de anclaje del ícono (donde se coloca en el mapa)
                    popupAnchor: [0, -32], // Ajusta la posición del popup respecto al ícono
                    draggable: true, // ✅ habilita drag
                });

                var latLang = marker.latLng;
                console.log(params);
                const markerCurrent = L.marker(latLang, {icon: customIcon, bouncing: true}).addTo(map);
                markerCurrent.on('mouseover', function (e) {
                    console.log("mouseover", e);
                });

                // Capturar el evento de salir el mouse del marcador
                markerCurrent.on('mouseout', function (e) {
                    console.log("mouseout", e);

                });

                // ✅ eventos de drag
                markerCurrent.on("dragstart", function (e) {
                    console.log("dragstart", e);
                });

                markerCurrent.on("drag", function (e) {
                    const pos = e.target.getLatLng();

                });

                markerCurrent.on("dragend", async function (e) {
                    const pos = e.target.getLatLng();
                    await $scopeCurrent.getAddressInformation({
                        lat: pos.lat,
                        lng: pos.lng,

                    });
                });
                markerCurrent.dragging.enable();
                return markerCurrent; // opcional: para guardarlo afuera

            },
            returnViewLocation: function () {
                this.destroyLeafletMap();
                this.locationManagement.view = false;
            },
            managementViewLocation: function () {
                this.locationManagement.view = true;
                this.viewMap();
            },
            getDistance: function () {
                var result = this.distanceKm;
                console.log("distanceKm", result)
                return result;
            },
            onChangeLocation: async function () {
                if (this.locationCheck) {
                    await this.getInitLocation();
                    var latLngCurrent = {lat: this.addressInformation.lat, lng: this.addressInformation.lng};
                    await this.getAddressInformation(latLngCurrent);
                } else {

                }

                this.emitFilters({action: "change", "data": {element: "locationCheck"}});


            },
            getInitLocation: async function () {
                const once = await GeoManager.getBrowserCoordinatesAsync({
                    enableHighAccuracy: true,
                    timeout: 15000,
                    fallbackLat: this.addressInformation.lat,
                    fallbackLng: this.addressInformation.lng
                });

                this.addressInformation.lat = once.lat;
                this.addressInformation.lng = once.lng;

            },
            addCurrentLocationButton: function (map) {
                const $this = this;
                // ✅ Control Leaflet (botón)
                const LocateControl = L.Control.extend({
                    options: {position: "topleft"}, // topright / bottomright / bottomleft
                    onAdd: function () {
                        const container = L.DomUtil.create("div", "leaflet-bar leaflet-control");
                        const btn = L.DomUtil.create("a", "", container);

                        btn.href = "#";
                        btn.title = "Mi ubicación";
                        btn.style.width = "34px";
                        btn.style.height = "34px";
                        btn.style.display = "flex";
                        btn.style.alignItems = "center";
                        btn.style.justifyContent = "center";
                        btn.style.background = "#fff";

                        // ✅ Bootstrap Icon (geolocalización)
                        btn.innerHTML = `<i class="bi bi-crosshair" style="font-size:18px;"></i>`;

                        // Evita que el click haga pan/zoom en el mapa
                        L.DomEvent.disableClickPropagation(container);
                        L.DomEvent.on(btn, "click", function (e) {
                            L.DomEvent.preventDefault(e);
                            $this.goToCurrentLocation(map);
                        });

                        return container;
                    },
                });

                // ✅ agrega al mapa y guarda referencia si quieres removerlo luego
                this.locationManagement.locateControl = new LocateControl();
                map.addControl(this.locationManagement.locateControl);
            },
            goToCurrentLocation: function (map) {
                const $this = this;
                if (!navigator.geolocation) {
                    console.log("Geolocalización no soportada");
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    function (pos) {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        const latLng = [lat, lng];

                        // ✅ centra el mapa
                        map.setView(latLng, 16, {animate: true});
                        const mk = $this.locationManagement.markerInformation;
                        if (mk) {
                            mk.setLatLng(latLng);          // ✅ solo cambia ubicación
                        } else {
                            // fallback si aún no existe
                            $this.locationManagement.markerInformation = L.marker(latLng).addTo(map);
                        }

                    },
                    function (err) {
                        console.log("Error geolocalización:", err);
                        // err.code: 1 permiso denegado, 2 no disponible, 3 timeout
                    },
                    {enableHighAccuracy: true, timeout: 10000, maximumAge: 0}
                );
            },

            getAddressInformation: async function (params) {

                const result = await reverseGeocodeNominatim(params);
                if (result.success) {
                    this.addressInformation.country = result.data.country;
                    this.addressInformation.state = result.data.state;
                    this.addressInformation.city = result.data.city;
                    this.addressInformation.district = result.data.district;
                    this.addressInformation.street = result.data.street;
                    this.addressInformation.houseNumber = result.data.houseNumber;
                    this.addressInformation.formattedAddress = result.data.formattedAddress;
                    this.addressInformation.formattedAddressView = result.data.street + "," + result.data.city + "," + result.data.state + "," + result.data.country;
                    this.addressInformation.streetView = result.data.street;

                    this.addressInformation.lat = params.lat;
                    this.addressInformation.lng = params.lng;

                }


            },
            ...$methodsFormValid,
            sendDataParent: function (params) {
                this.$emit('_actions-emit', params);
            },
            initDataByParent: function () {
                this.categoriesData = this.params.data.categories;
                console.log("initDataByParent", this.categoriesData);
            },
            // UI
            isOpenCategory: function (categoryId) {
                return this.openCategoryIds.indexOf(categoryId) !== -1;
            },
// Helpers
            isCategorySelected: function (categoryId) {
                return this.selectedCategoryIds.indexOf(categoryId) !== -1;
            },

            addUnique: function (arr, value) {
                if (arr.indexOf(value) === -1) arr.push(value);
            },

            removeValue: function (arr, value) {
                const i = arr.indexOf(value);
                if (i !== -1) arr.splice(i, 1);
            },

            selectAllChildren: function (category) {
                const children = (category.children || []);
                children.forEach((c) => this.addUnique(this.selectedSubcategoryIds, c.id));
            },

            unselectAllChildren: function (category) {
                const children = (category.children || []);
                children.forEach((c) => this.removeValue(this.selectedSubcategoryIds, c.id));
            },

            syncCategoryByChildren: function (category) {
                const children = (category.children || []);
                const hasAnyChildSelected = children.some((c) => this.selectedSubcategoryIds.indexOf(c.id) !== -1);

                if (hasAnyChildSelected) this.addUnique(this.selectedCategoryIds, category.id);
                else this.removeValue(this.selectedCategoryIds, category.id);
            },

// Toggle open (igual que tu código)
            toggleOpenCategory: function (categoryId) {
                const i = this.openCategoryIds.indexOf(categoryId);
                if (i === -1) this.openCategoryIds.push(categoryId);
                else this.openCategoryIds.splice(i, 1);
            },

// ✅ Checkbox category: si selecciono categoría => selecciono todas las subcategorías
            toggleCategory: function (category) {
                const categoryId = category.id;

                if (!this.isCategorySelected(categoryId)) {
                    // select category
                    this.selectedCategoryIds.push(categoryId);

                    // select all children
                    this.selectAllChildren(category);

                    // optional: open
                    if (!this.isOpenCategory(categoryId)) this.openCategoryIds.push(categoryId);
                } else {
                    // unselect category
                    this.removeValue(this.selectedCategoryIds, categoryId);

                    // unselect all children
                    this.unselectAllChildren(category);
                }


                this.emitFilters({action: "change", "data": {element: "category"}});

            },

// ✅ Checkbox subcategory: si marco 1 => categoría se marca; si no queda ninguna => categoría se desmarca
            toggleSubcategory: function (category, sub) {
                const subId = sub.id;
                if (this.selectedSubcategoryIds.indexOf(subId) === -1) {
                    this.selectedSubcategoryIds.push(subId);
                } else {
                    this.removeValue(this.selectedSubcategoryIds, subId);
                }

                // sync parent category checkbox based on at least one selected child
                this.syncCategoryByChildren(category);

                // optional: open category when selecting a subcategory
                if (this.isCategorySelected(category.id) && !this.isOpenCategory(category.id)) {
                    this.openCategoryIds.push(category.id);
                }

                this.emitFilters({action: "change", "data": {element: "subcategory"}});

            },

            setDistance: function (km) {
                this.distanceKm = parseInt(km, 10) || 1;
                this.emitFilters({action: "change", "data": {element: "distance"}});
            },

            resetAll: function () {
                this.selectedCategoryIds = [];
                this.selectedSubcategoryIds = [];
                this.openCategoryIds = [];
                this.distanceKm = this.filtersInit.distanceKm;
                this.locationCheck = this.filtersInit.locationCheck;
                this.emitFilters({action: "resetAll", "data": {element: "all"}});

            },

            applyFilters: function () {
                this.emitFilters({action: "applyFilters", "data": {}});

            },
            emitFilters: function (params) {
                var actionName = params.action;
                var dataCurrent = params.data;
                const subCategoryIdsString = this.selectedSubcategoryIds.join(',');
                const categoryIdsString = this.selectedCategoryIds.join(',');
                var dataSend = {
                    distance: this.distanceKm,
                    locationCheck: this.locationCheck,
                    lat: this.addressInformation.lat,
                    lng: this.addressInformation.lng,
                    categories: categoryIdsString,
                    subCategoryIdsString: subCategoryIdsString
                };
                const mergedData = {
                    ...dataCurrent,
                    ...dataSend
                };
                this.sendDataParent({
                    action: actionName,
                    child: this.nameComponent,
                    data: mergedData
                });
            }
        }
    });
</script>
