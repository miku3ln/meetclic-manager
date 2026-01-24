<script type="text/x-template" id="filters-categories-template">
    <div class="filters-sheet">
        <!-- HEADER -->
        <div class="filters-sheet__container py-3">
            <div class="d-flex align-items-center justify-content-between">
                <button type="button" class="btn p-0" aria-label="Cerrar"
                        @click="sendDataParent({action:'close', child:nameComponent})">
                    <i class="bi bi-x" style="font-size:2.2rem; line-height:1;"></i>
                </button>

                <div class="filters-sheet__title">Filtros</div>

                <a href="javascript:void(0)" class="filters-sheet__reset" @click="resetAll()">Restablecer</a>
            </div>
        </div>

        <div class="filters-sheet__container pb-4">

            <!-- LOCATION CARD (por ahora estático, luego lo conectamos a params) -->
            <div class="card filters-sheet__card">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="filters-sheet__icon-wrap me-3">

                            <i class="bi bi-geo-alt" style="font-size:1.2rem;"></i>
                        </div>

                        <div class="flex-grow-1">
                            <div class="fw-bold mb-1" style="color:#4C4CFF; font-size:1.25rem;">
                                Ubicación de búsqueda
                            </div>
                            <div class="mb-1" style="font-size:1.1rem;">
                                <span class="view-label">Calle:</span> <span
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
                </div>
            </div>

            <!-- DISTANCIA -->
            <div class="filters-sheet__section-title">Distancia</div>
            <p class="filters-sheet__help">Muestra negocios dentro de un radio seleccionado.</p>

            <div class="text-center my-3">
                <span class="filters-sheet__badge-km"><?php echo '{{distanceKm}}' ?> km</span>
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

            <!-- CATEGORÍAS -->
            <div class="filters-sheet__section-title mt-4">Categorías</div>
            <p class="filters-sheet__help">Selecciona categorías y subcategorías para filtrar los negocios.</p>

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
