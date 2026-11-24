<aside id="yapita-business-filter-aside" class="offcanvas offcanvas-end yapita-business-filter-aside" tabindex="-1" aria-labelledby="yapita-business-filter-aside-title">
    <header class="yapita-business-filter-aside__header">
        <div class="yapita-business-filter-aside__heading">
            <div class="yapita-business-filter-aside__heading-icon"><i class="bi bi-sliders"></i></div>
            <h2 id="yapita-business-filter-aside-title" class="yapita-business-filter-aside__title" data-role="aside-title"></h2>
            <button type="button" class="yapita-business-filter-aside__close" data-role="close-more" aria-label="Cerrar filtros"><i class="bi bi-x-lg"></i></button>
        </div>
        <p class="yapita-business-filter-aside__description" data-role="aside-description"></p>
    </header>
    <div class="offcanvas-body yapita-business-filter-aside__body">
        <section class="yapita-business-filter-aside__section" data-role="business-types-section">
            <h3 class="yapita-business-filter-aside__section-title"><i class="bi bi-shop"></i> <span data-role="type-label"></span></h3>
            <div class="yapita-business-filter-aside__types" data-role="business-types"></div>
        </section>
        <section class="yapita-business-filter-aside__section" data-role="category-section">
            <label for="ybf-category" class="yapita-business-filter-aside__section-title"><i class="bi bi-grid"></i> <span data-role="category-label"></span></label>
            <div class="yapita-business-filter-aside__select-container"><select id="ybf-category" class="form-select yapita-business-filter-aside__select" data-role="category"></select></div>
            <div class="yapita-business-filter-aside__subcategory" data-role="subcategory-section">
                <div class="yapita-business-filter-aside__field-header">
                    <label for="ybf-subcategory" class="yapita-business-filter-aside__section-title"><i class="bi bi-tags"></i> <span data-role="subcategory-label"></span></label>
                    <span class="yapita-business-filter-aside__selection-count" data-role="subcategory-count" hidden></span>
                </div>
                <div class="yapita-business-filter-aside__select-container"><select id="ybf-subcategory" class="form-select yapita-business-filter-aside__select yapita-business-filter-aside__select--multiple" data-role="subcategory" multiple disabled></select></div>
                <small class="yapita-business-filter-aside__field-help" data-role="subcategory-help"></small>
            </div>
        </section>
        <div class="yapita-business-filter-aside__extra-filters" data-role="extra-filters"></div>
    </div>
    <footer class="yapita-business-filter-aside__footer">
        <button type="button" class="yapita-business-filter-aside__button yapita-business-filter-aside__button--clear" data-role="clear-draft"><i class="bi bi-trash3"></i> <span data-role="clear-label"></span></button>
        <button type="button" class="yapita-business-filter-aside__button yapita-business-filter-aside__button--apply" data-role="apply"><i class="bi bi-search"></i> <span data-role="apply-label"></span></button>
    </footer>
</aside>
