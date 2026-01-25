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
            this.locationCheck = locationCheck;
            if (locationCheck) {
                await this.getAddressInformation(latLngCurrent);
            }

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

                }
            };
            return dataManager;
        },
        methods: {
            onChangeLocation: async function () {
                if (this.locationCheck) {
                    // Se activó: aquí puedes pedir ubicación o cargar datos
                    // this.getCurrentLocation();
                } else {
                    await this.getInitLocation();
                    var latLngCurrent = {lat: this.addressInformation.lat, lng: this.addressInformation.lng};

                    await this.getAddressInformation(latLngCurrent);
                }

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
            getAddressInformation: async function (params) {

                const result = await reverseGeocodeNominatim(params);
                this.addressInformation.country = result.data.country;
                this.addressInformation.state = result.data.state;
                this.addressInformation.city = result.data.city;
                this.addressInformation.district = result.data.district;
                this.addressInformation.street = result.data.street;
                this.addressInformation.houseNumber = result.data.houseNumber;
                this.addressInformation.formattedAddress = result.data.formattedAddress;
                this.addressInformation.formattedAddressView = result.data.street + "," + result.data.city + "," + result.data.state + "," + result.data.country;
                this.addressInformation.streetView = result.data.street;


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
                this.distanceKm = 1;
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
