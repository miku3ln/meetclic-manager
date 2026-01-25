<script type="text/x-template" id="filters-categories-template">
    <div class="filters-sheet">
        <!-- HEADER -->
        <div class="filters-sheet__container py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="filters-sheet__actions">
                    <a @click="applyFilters()"  class="filters-sheet__action filters-sheet__action--search"><?php echo "{{labelsProcessConfig.filters.btnSearchTasks}}"?></a>
                    <a @click="resetAll()"   class="filters-sheet__action filters-sheet__action--reset"><?php echo "{{labelsProcessConfig.filters.btnReset}}"?></a>
                </div>
            </div>
        </div>

        <div class="filters-sheet__container pb-4">
            <div class="form-check form-switch mb-3">
                <input
                    class="form-check-input"
                    type="checkbox"
                    id="locationCheck"
                    v-model="locationCheck"
                    @change="onChangeLocation"
                >
                <label class="form-check-label fw-bold" for="locationCheck" style="color:#4C4CFF;">
                    <?php echo "{{labelsProcessConfig.filters.toggleNearMe}}"?>
                </label>
            </div>
            <!-- LOCATION CARD (por ahora estático, luego lo conectamos a params) -->
            <div class="location" v-if="locationCheck">
                <div class="card filters-sheet__card">
                    <div class="card-body">
                        <div class="d-flex align-items-start" v-if="!locationManagement.view">
                            <div class="filters-sheet__icon-wrap me-3" @click="managementViewLocation()">

                                <i class="bi bi-geo-fill" style="font-size:1.2rem;"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="fw-bold mb-1" style="color:#4C4CFF; font-size:1.25rem;">
                                    <?php echo "{{labelsProcessConfig.filters.location.title}}"?>
                                </div>
                                <div class="mb-1" style="font-size:1.1rem;">
                                    <span class="view-label">  <?php echo "{{labelsProcessConfig.filters.location.streetLabel}}"?>:</span> <span
                                        class="fw-bold text-uppercase view-value"><?php echo "{{addressInformation.streetView}}" ?></span>
                                </div>
                                <div
                                    class="text-muted view-value"><?php echo "{{addressInformation.formattedAddressView}}" ?></div>
                                <div class="text-muted mt-2" style="font-size:.9rem;">
                                    <span class="view-label">Lat: </span><span
                                        class="view-value"> <?php echo "{{addressInformation.lat}}" ?>  </span>&nbsp; ·
                                    &nbsp; <span class="view-label">Lng: </span> <span
                                        class="view-value">  <?php echo "{{addressInformation.lng}}" ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start" v-if="locationManagement.view">
                            <div class="filters-sheet__icon-wrap me-3" @click="returnViewLocation()">

                                <i class="bi bi-arrow-return-left" style="font-size:1.2rem;"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div v-init-map-manager="{  functionInit:viewMap }"  ref="map" class="map-container-view" id="map-main-view">


                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- DISTANCIA -->
                <div class="filters-sheet__section-title"> <?php echo "{{labelsProcessConfig.filters.distance.title}}"?></div>
                <p class="filters-sheet__help"> <?php echo "{{labelsProcessConfig.filters.distance.helper}}"?></p>

                <div class="text-center my-3">
                    <span class="filters-sheet__badge-km"><?php echo '{{getDistance()}}' ?> km</span>
                </div>

                <div class="d-flex justify-content-between text-muted mb-2" style="font-size:1.1rem;">
                    <span>1 km</span>
                    <span>30 km</span>
                </div>

                <input
                    type="range"
                    class="form-range filters-sheet__range"
                    min="1" max="30" step="1"
                    v-model.number="distanceKm"
                    @input="setDistance(distanceKm)"
                >
            </div>


            <!-- CATEGORÍAS -->
            <div class="filters-sheet__section-title mt-4"> <?php echo "{{labelsProcessConfig.filters.categories.title}}"?></div>
            <p class="filters-sheet__help"> <?php echo "{{labelsProcessConfig.filters.categories.helper}}"?></p>

            <div class="list-group">
                <div
                    v-for="cat in categoriesData"
                    :key="'cat-'+cat.id"
                    class="list-group-item filters-sheet__item"
                >
                    <!-- ROW CATEGORY -->
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="filters-sheet__icon-wrap me-3">
                                <i :class="cat.icon" style="font-size:1.2rem;"></i>
                            </div>
                            <button
                                type="button"
                                class="btn p-0 text-start button__category"
                                @click="toggleOpenCategory(cat.id)"
                                style="font-size:1.25rem;"
                            >
                                <?php echo '{{ cat.text }}' ?>
                                <i
                                    class="bi ms-2"
                                    :class="isOpenCategory(cat.id) ? 'bi-chevron-up' : 'bi-chevron-down'"
                                    style="font-size:1rem; color:#8a8aa0;"
                                ></i>
                            </button>
                        </div>

                        <span class="form-check m-0">
              <input
                  class="form-check-input m-0 filters-sheet__check"
                  type="checkbox"
                  :checked="selectedCategoryIds.includes(cat.id)"
                  @change="toggleCategory(cat)"
              >
            </span>
                    </div>

                    <!-- SUBCATEGORIES -->
                    <div v-if="isOpenCategory(cat.id) && cat.children && cat.children.length"
                         class="filters-sheet__sublist mt-3">
                        <div
                            v-for="sub in cat.children"
                            :key="'sub-'+sub.id"
                            class="d-flex align-items-center justify-content-between filters__item-subcategory "
                        >
                            <div class="d-flex align-items-center">
                                <div class="filters-sheet__icon-wrap me-3" style="width:36px;height:36px;">
                                    <i :class="sub.icon" style="font-size:1.05rem;"></i>
                                </div>
                                <div style="font-size:1.1rem;"><?php echo '{{sub.text }}' ?></div>
                            </div>

                            <span class="form-check m-0">
                <input
                    class="form-check-input m-0 filters-sheet__check"
                    type="checkbox"
                    :checked="selectedSubcategoryIds.includes(sub.id)"
                    @change="toggleSubcategory(cat, sub)"
                >
              </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</script>
