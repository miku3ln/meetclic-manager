<style>
    .yapita-business-filter-aside {
        --ybfa-primary: #4354eb;
        --ybfa-primary-light: #eef2ff;
        --ybfa-border: #dce1ea;
        --ybfa-muted: #7b8495;
        --ybfa-text: #172033;
        --ybfa-background: #fff;

        --bs-offcanvas-width: min(410px, 95vw);
        --bs-offcanvas-zindex: 1045;
        --bs-offcanvas-bg: var(--ybfa-background);

        color: var(--ybfa-text);
        overscroll-behavior: contain;
    }

    .yapita-business-filter-aside__body {
        flex: 1;
        min-height: 0;

        overflow-y: auto;
        overscroll-behavior: contain;

        padding: 16px;
    }

    .yapita-business-filter-aside__header, .yapita-business-filter-aside__footer {
        padding: 16px;
        flex-shrink: 0;
        background: #fff
    }

    .yapita-business-filter-aside__header {
        border-bottom: 1px solid var(--ybfa-border)
    }

    .yapita-business-filter-aside__heading {
        display: flex;
        align-items: center;
        gap: 10px
    }

    .yapita-business-filter-aside__heading-icon {
        color: var(--ybfa-primary);
        font-size: 24px
    }

    .yapita-business-filter-aside__title {
        font-size: 20px;
        margin: 0;
        flex: 1
    }

    .yapita-business-filter-aside__close {
        border: 0;
        background: transparent;
        padding: 8px
    }

    .yapita-business-filter-aside__description, .yapita-business-filter-aside__range-description, .yapita-business-filter-aside__field-help {
        font-size: 12px;
        color: var(--ybfa-muted);
        margin: 8px 0 0
    }

    .yapita-business-filter-aside__body {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 16px
    }

    .yapita-business-filter-aside__section {
        padding: 0 0 18px;
        margin-bottom: 18px;
        border-bottom: 1px solid var(--ybfa-border)
    }

    .yapita-business-filter-aside__section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 10px
    }

    .yapita-business-filter-aside__section-title i {
        color: var(--ybfa-primary)
    }

    .yapita-business-filter-aside__types {
        display: grid;
        grid-template-columns:repeat(3, minmax(0, 1fr));
        gap: 8px
    }

    .yapita-business-filter-aside__type {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 90px;
        padding: 8px;
        border: 1px solid var(--ybfa-border);
        border-radius: 10px;
        background: white;
        font-size: 12px
    }

    .yapita-business-filter-aside__type--active {
        background: var(--ybfa-primary-light);
        border-color: var(--ybfa-primary);
        color: var(--ybfa-primary)
    }

    .yapita-business-filter-aside__type-icon {
        font-size: 22px
    }

    .yapita-business-filter-aside__type-check {
        display: none;
        position: absolute;
        top: 5px;
        right: 5px
    }

    .yapita-business-filter-aside__type--active .yapita-business-filter-aside__type-check {
        display: block
    }

    .yapita-business-filter-aside__subcategory {
        margin-top: 16px
    }

    .yapita-business-filter-aside__field-header, .yapita-business-filter-aside__range-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px
    }

    .yapita-business-filter-aside__field-header .yapita-business-filter-aside__section-title {
        margin: 0 0 8px
    }

    .yapita-business-filter-aside__selection-count, .yapita-business-filter-aside__range-value {
        background: var(--ybfa-primary-light);
        color: var(--ybfa-primary);
        border-radius: 20px;
        padding: 5px 9px;
        font-size: 12px;
        font-weight: 600
    }

    .yapita-business-filter-aside__field-help {
        display: block
    }

    .yapita-business-filter-aside__select {
        min-height: 44px
    }

    .yapita-business-filter-aside .select2-container {
        width: 100% !important
    }

    .yapita-business-filter-aside .select2-selection--single, .yapita-business-filter-aside .select2-selection--multiple {
        min-height: 44px;
        border: 1px solid var(--ybfa-border);
        border-radius: 9px
    }

    .yapita-business-filter-aside .select2-selection--single .select2-selection__rendered {
        line-height: 42px
    }

    .yapita-business-filter-aside .select2-selection--single .select2-selection__arrow {
        height: 42px
    }

    .yapita-business-filter-aside .select2-selection--multiple .select2-selection__choice {
        background: var(--ybfa-primary-light);
        color: var(--ybfa-primary);
        border-color: #dce3ff;
        white-space: normal
    }

    .yapita-business-filter-aside .select2-dropdown {
        border-color: var(--ybfa-border);
        z-index: 1060
    }

    .yapita-business-filter-aside__switch {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer
    }

    .yapita-business-filter-aside__switch-icon {
        font-size: 24px;
        color: var(--ybfa-primary)
    }

    .yapita-business-filter-aside__switch-content {
        flex: 1;
        display: flex;
        flex-direction: column
    }

    .yapita-business-filter-aside__switch-label {
        font-weight: 600
    }

    .yapita-business-filter-aside__switch-description {
        font-size: 12px;
        color: var(--ybfa-muted)
    }

    .yapita-business-filter-aside__switch .form-check-input {
        float: none;
        margin: 0;
        cursor: pointer
    }

    .yapita-business-filter-aside__switch .form-check-input:checked {
        background-color: var(--ybfa-primary);
        border-color: var(--ybfa-primary)
    }

    .yapita-business-filter-aside__range {
        width: 100%;
        height: 28px;
        margin: 12px 0 0;
        appearance: none;
        background: transparent;
        cursor: pointer
    }

    .yapita-business-filter-aside__range::-webkit-slider-runnable-track {
        height: 7px;
        border-radius: 20px;
        background: linear-gradient(to right, var(--ybfa-primary) var(--ybfa-range-progress, 0%), #e2e8f0 var(--ybfa-range-progress, 0%))
    }

    .yapita-business-filter-aside__range::-webkit-slider-thumb {
        appearance: none;
        width: 20px;
        height: 20px;
        margin-top: -6.5px;
        border: 3px solid white;
        border-radius: 50%;
        background: var(--ybfa-primary);
        box-shadow: 0 0 0 1px var(--ybfa-primary)
    }

    .yapita-business-filter-aside__range::-moz-range-track {
        height: 7px;
        background: #e2e8f0;
        border-radius: 20px
    }

    .yapita-business-filter-aside__range::-moz-range-progress {
        height: 7px;
        background: var(--ybfa-primary);
        border-radius: 20px
    }

    .yapita-business-filter-aside__range::-moz-range-thumb {
        width: 16px;
        height: 16px;
        border: 3px solid white;
        border-radius: 50%;
        background: var(--ybfa-primary)
    }

    .yapita-business-filter-aside__range-marks {
        position: relative;
        height: 20px;
        margin: 0 10px
    }

    .yapita-business-filter-aside__range-mark {
        position: absolute;
        transform: translateX(-50%);
        font-size: 10px;
        white-space: nowrap;
        color: var(--ybfa-muted)
    }

    .yapita-business-filter-aside__range-mark:first-child {
        transform: none
    }

    .yapita-business-filter-aside__range-mark:last-child {
        transform: translateX(-100%)
    }

    .yapita-business-filter-aside__diameter {
        font-size: 12px;
        color: var(--ybfa-muted);
        margin: 8px 0 0
    }

    .yapita-business-filter-aside__footer {
        display: none !important;
        display: flex;
        gap: 10px;
        border-top: 1px solid var(--ybfa-border);
        padding-bottom: max(16px, env(safe-area-inset-bottom))
    }
    .yapita-business-filter-aside__footer[hidden] {
        display: none !important;
    }
    .yapita-business-filter-aside__button {
        border-radius: 9px;
        padding: 12px;
        font-weight: 600;
        border: 1px solid transparent
    }

    .yapita-business-filter-aside__button--clear {
        color: #dc3545;
        background: #fff1f2;
        border-color: #f5c2c7
    }

    .yapita-business-filter-aside__button--apply {
        flex: 1;
        background: #ffcc00;
        color: #172033
    }

    .yapita-business-filter-aside__button:disabled {
        opacity: .5;
        cursor: not-allowed
    }

    @media (max-width: 575.98px) {
        .yapita-business-filter-aside .select2-search__field {
            font-size: 16px !important
        }
    }

</style>
