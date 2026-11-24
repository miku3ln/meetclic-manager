<div class="yapita-business-filter-anchor"
     id="yapita-business-filter-anchor">

    <section
        id="yapita-business-filter"
        class="yapita-business-filter"
    >

        <!-- =====================================
             TOOLBAR PRINCIPAL
        ====================================== -->

        <div class="yapita-business-filter__toolbar">

            <!-- BUSCADOR -->

            <div class="yapita-business-filter__search"
                 data-role="search-container">

                <i class="bi bi-search
                          yapita-business-filter__search-icon"
                   aria-hidden="true"></i>

                <input
                    type="search"
                    class="yapita-business-filter__search-input"
                    data-role="search"
                    placeholder=""
                    aria-label="Buscar negocios"
                    autocomplete="off"
                >

                <button
                    type="button"
                    class="yapita-business-filter__search-clear"
                    data-role="clear-search"
                    aria-label="Limpiar búsqueda"
                    hidden
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>

            <!-- BOTÓN DE FILTROS -->

            <button
                type="button"
                class="yapita-business-filter__filter-button"
                data-role="open-more"
                aria-controls="yapita-business-filter-aside"
                aria-expanded="false"
            >

                <i class="bi bi-sliders
                          yapita-business-filter__filter-icon"
                   aria-hidden="true"></i>

                <span
                    class="yapita-business-filter__filter-label"
                    data-role="filter-label"
                >
                    Filtros
                </span>

                <span
                    class="yapita-business-filter__filter-count"
                    data-role="filter-count"
                    hidden
                >
                    0
                </span>

            </button>

        </div>

        <!-- =====================================
             RESULTADOS Y FILTROS APLICADOS
        ====================================== -->

        <div class="yapita-business-filter__summary">

            <!-- TOTAL DE NEGOCIOS -->

            <div class="yapita-business-filter__results"
                 data-role="results"
                 aria-live="polite">

                <i class="bi bi-shop
                          yapita-business-filter__results-icon"
                   aria-hidden="true"></i>

                <span
                    class="yapita-business-filter__results-label"
                    data-role="results-label"
                >
                    Negocios:
                </span>

                <strong
                    class="yapita-business-filter__results-count"
                    data-role="results-count"
                >
                    0
                </strong>

            </div>

            <!-- FILTROS APLICADOS DINÁMICAMENTE -->

            <div
                class="yapita-business-filter__active-filters"
                data-role="active-filters"
                aria-label="Filtros aplicados"
                hidden
            ></div>

            <!-- ELIMINAR TODOS LOS FILTROS -->

            <button
                type="button"
                class="yapita-business-filter__clear-all"
                data-role="clear-all"
                aria-label="Eliminar todos los filtros"
                title="Eliminar todos los filtros"
                hidden
            >
                <i class="bi bi-trash3"></i>
            </button>

        </div>

    </section>

</div>
