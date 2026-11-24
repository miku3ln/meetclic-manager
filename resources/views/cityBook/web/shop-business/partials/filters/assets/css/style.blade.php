<style>
    /* =========================================
    YAPITA BUSINESS FILTER
 ========================================= */

    .yapita-business-filter {

        --ybf-primary: #4354eb;
        --ybf-primary-dark: #3042cc;
        --ybf-secondary: #ffcc00;

        --ybf-background: #ffffff;
        --ybf-surface: #eef2ff;
        --ybf-border: #dce1ea;

        --ybf-text: #172033;
        --ybf-muted: #7b8495;

        --ybf-danger: #dc3545;
        --ybf-danger-light: #fff1f2;

        --ybf-radius: 12px;

        --ybf-top: 0px;
        --ybf-left: 0px;
        --ybf-width: 100%;
        --ybf-z-index: 1020;

        position: relative;

        width: 100%;
        min-width: 0;

        padding: 10px 12px;

        display: flex;
        flex-direction: column;
        gap: 10px;

        background: var(--ybf-background);

        border-bottom: 1px solid var(--ybf-border);

        box-shadow: 0 3px 12px rgba(0, 0, 0, .08);

        z-index: var(--ybf-z-index);

        box-sizing: border-box;
    }

    .yapita-business-filter-anchor {
        position: relative;
        width: 100%;
        min-width: 0;
    }

    .yapita-business-filter *,
    .yapita-business-filter *::before,
    .yapita-business-filter *::after {
        box-sizing: border-box;
    }

    .yapita-business-filter [hidden] {
        display: none !important;
    }
    /* =========================================
   STICKY / FIXED
========================================= */

    .yapita-business-filter--sticky {
        z-index: var(--ybf-z-index);
    }

    .yapita-business-filter--sticky.yapita-business-filter--stuck {

        position: fixed !important;

        top: var(--ybf-top);
        left: var(--ybf-left);

        width: var(--ybf-width);

        margin: 0;

        z-index: var(--ybf-z-index);

        background: var(--ybf-background);

        box-shadow: 0 5px 16px rgba(0, 0, 0, .12);
    }
    /* =========================================
   TOOLBAR
========================================= */

    .yapita-business-filter__toolbar {

        display: flex;
        align-items: center;

        width: 100%;
        min-width: 0;

        gap: 8px;
    }
    /* =========================================
   SEARCH
========================================= */

    .yapita-business-filter__search {

        display: flex;
        align-items: center;

        flex: 1 1 auto;

        min-width: 0;
        height: 44px;

        gap: 8px;
        padding: 0 12px;

        background: var(--ybf-background);

        border: 1px solid var(--ybf-border);
        border-radius: var(--ybf-radius);

        transition:
            border-color .2s ease,
            box-shadow .2s ease;
    }

    .yapita-business-filter__search:focus-within {

        border-color: var(--ybf-primary);

        box-shadow: 0 0 0 3px rgba(67, 84, 235, .10);
    }

    .yapita-business-filter__search-icon {

        flex-shrink: 0;

        color: var(--ybf-muted);

        font-size: 17px;
        line-height: 1;
    }

    .yapita-business-filter__search-input {

        flex: 1 1 auto;

        width: 100%;
        min-width: 0;
        height: 100%;

        padding: 0;
        margin: 0;

        border: 0 !important;
        outline: none !important;
        box-shadow: none !important;

        background: transparent;

        color: var(--ybf-text);

        font-size: 14px;
        font-weight: 400;

        text-overflow: ellipsis;
    }

    .yapita-business-filter__search-input::placeholder {
        color: var(--ybf-muted);
        opacity: 1;
    }

    /* Eliminar botón nativo del input search */

    .yapita-business-filter__search-input::-webkit-search-cancel-button,
    .yapita-business-filter__search-input::-webkit-search-decoration {
        -webkit-appearance: none;
        appearance: none;
    }

    /* Limpiar búsqueda */

    .yapita-business-filter__search-clear {

        display: inline-flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        width: 24px;
        height: 24px;

        padding: 0;

        border: 0;
        border-radius: 50%;

        background: #e5e7eb;
        color: #6b7280;

        font-size: 10px;

        cursor: pointer;

        transition: background .2s ease;
    }

    .yapita-business-filter__search-clear:hover {
        background: #d1d5db;
    }
    /* =========================================
   FILTER BUTTON
========================================= */

    .yapita-business-filter__filter-button {

        position: relative;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        height: 44px;

        gap: 7px;
        padding: 0 12px;

        border: 1px solid var(--ybf-border);
        border-radius: var(--ybf-radius);

        background: var(--ybf-background);
        color: var(--ybf-primary);

        font-size: 14px;
        font-weight: 600;

        white-space: nowrap;
        cursor: pointer;

        transition:
            background .2s ease,
            color .2s ease,
            border-color .2s ease;
    }

    .yapita-business-filter__filter-button:hover {

        background: var(--ybf-surface);
        border-color: var(--ybf-primary);
    }

    .yapita-business-filter__filter-icon {

        font-size: 18px;
        line-height: 1;
    }

    .yapita-business-filter__filter-label {

        font-size: 13px;
        font-weight: 600;
    }

    /* FILTROS APLICADOS */

    .yapita-business-filter__filter-button--active {

        background: var(--ybf-primary);
        border-color: var(--ybf-primary);

        color: #ffffff;
    }

    .yapita-business-filter__filter-button--active:hover {

        background: var(--ybf-primary-dark);
        border-color: var(--ybf-primary-dark);

        color: #ffffff;
    }

    /* BADGE CONTADOR */

    .yapita-business-filter__filter-count {

        display: inline-flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        min-width: 22px;
        height: 22px;

        padding: 0 5px;

        border-radius: 50px;

        background: var(--ybf-secondary);
        color: var(--ybf-primary-dark);

        font-size: 12px;
        font-weight: 800;
        line-height: 1;
    }
    /* =========================================
   SUMMARY
========================================= */

    .yapita-business-filter__summary {

        display: flex;
        align-items: center;

        width: 100%;
        min-width: 0;

        gap: 7px;
    }

    /* =========================================
       RESULTS
    ========================================= */

    .yapita-business-filter__results {

        display: inline-flex;
        align-items: center;

        flex-shrink: 0;

        min-height: 30px;

        gap: 5px;
        padding: 5px 9px;

        background: var(--ybf-surface);

        border-radius: 50px;

        white-space: nowrap;
    }

    .yapita-business-filter__results-icon {

        color: var(--ybf-primary-dark);

        font-size: 13px;
        line-height: 1;
    }

    .yapita-business-filter__results-label {

        color: var(--ybf-text);

        font-size: 11px;
        font-weight: 500;
    }

    .yapita-business-filter__results-count {

        color: var(--ybf-primary);

        font-size: 13px;
        font-weight: 800;
    }
    /* =========================================
   ACTIVE FILTERS
========================================= */

    .yapita-business-filter__active-filters {

        display: flex;
        align-items: center;

        flex: 1 1 auto;

        min-width: 0;

        gap: 5px;

        overflow-x: auto;
        overflow-y: hidden;

        white-space: nowrap;

        scrollbar-width: none;

        -webkit-overflow-scrolling: touch;
    }

    .yapita-business-filter__active-filters::-webkit-scrollbar {
        display: none;
    }

    /* CHIP INDIVIDUAL */

    .yapita-business-filter__chip {

        display: inline-flex;
        align-items: center;

        flex-shrink: 0;

        min-height: 30px;

        gap: 6px;
        padding: 4px 8px 4px 10px;

        background: var(--ybf-surface);

        border: 1px solid #e0e5ff;
        border-radius: 50px;

        color: var(--ybf-primary-dark);
    }

    .yapita-business-filter__chip-label {

        font-size: 11px;
        font-weight: 500;

        white-space: nowrap;
    }

    /* ELIMINAR FILTRO INDIVIDUAL */

    .yapita-business-filter__chip-remove {

        display: inline-flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        width: 22px;
        height: 22px;

        padding: 0;

        border: 0;
        border-radius: 50%;

        background: transparent;

        color: var(--ybf-primary-dark);

        font-size: 10px;

        cursor: pointer;

        transition: background .2s ease;
    }

    .yapita-business-filter__chip-remove:hover {

        background: #dbe2ff;
    }
    /* =========================================
   CLEAR ALL FILTERS
========================================= */

    .yapita-business-filter__clear-all {

        display: inline-flex;
        align-items: center;
        justify-content: center;

        flex-shrink: 0;

        width: 32px;
        height: 32px;

        margin-left: auto;
        padding: 0;

        border: 1px solid var(--ybf-danger);
        border-radius: 9px;

        background: var(--ybf-background);

        color: var(--ybf-danger);

        font-size: 15px;

        cursor: pointer;

        transition:
            background .2s ease,
            color .2s ease;
    }

    .yapita-business-filter__clear-all:hover {

        background: var(--ybf-danger);
        color: #ffffff;
    }

    .yapita-business-filter__clear-all:active {

        background: var(--ybf-danger-light);
        color: var(--ybf-danger);
    }

    .yapita-business-filter button:focus-visible {

        outline: 2px solid var(--ybf-primary);
        outline-offset: 2px;
    }
    /* =========================================
   MOBILE
========================================= */

    @media (max-width: 767.98px) {

        .yapita-business-filter {

            padding: 8px;

            gap: 8px;
        }

        .yapita-business-filter__toolbar {
            gap: 6px;
        }

        .yapita-business-filter__search {

            height: 42px;

            padding: 0 9px;
            gap: 6px;
        }

        .yapita-business-filter__search-input {
            font-size: 16px;
        }

        .yapita-business-filter__search-icon {
            font-size: 16px;
        }

        .yapita-business-filter__filter-button {

            height: 42px;

            gap: 5px;
            padding: 0 9px;
        }

        .yapita-business-filter__filter-label {
            font-size: 12px;
        }

        .yapita-business-filter__filter-icon {
            font-size: 16px;
        }

        .yapita-business-filter__filter-count {

            min-width: 20px;
            height: 20px;

            font-size: 11px;
        }

        .yapita-business-filter__summary {
            gap: 5px;
        }

        .yapita-business-filter__results {
            padding: 4px 7px;
        }

        .yapita-business-filter__results-label {
            font-size: 10px;
        }

        .yapita-business-filter__chip-label {
            font-size: 10px;
        }

        .yapita-business-filter__clear-all {

            width: 32px;
            height: 32px;

            font-size: 14px;
        }
    }

    /* DISPOSITIVOS MUY PEQUEÑOS */

    @media (max-width: 360px) {

        .yapita-business-filter__filter-button {
            padding: 0 7px;
        }

        .yapita-business-filter__results-label {
            font-size: 9px;
        }

        .yapita-business-filter__search {
            padding: 0 7px;
        }
    }
    aside#yapita-business-filter-aside {
        margin-top: 96px;
    }
</style>
