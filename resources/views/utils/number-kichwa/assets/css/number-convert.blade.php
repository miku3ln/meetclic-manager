<style id="number-convert">
    .container--manager-number-convert {
        margin-left: 9%;
        margin-top: 5%;
        margin-right: 9%;
    }

    .mc-dict {
        font-family: Arial, sans-serif;
        max-width: 520px;
        margin: 0 auto;
    }

    .mc-dict__bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .mc-dict__bar-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .mc-dict__badge-icon {
        font-size: 22px;
    }

    .mc-dict__title {
        font-weight: 700;
        font-size: 16px;
        color: #1f2937;
    }

    .mc-dict__subtitle {
        font-size: 12px;
        color: #6b7280;
        margin-top: 2px;
    }

    .mc-dict__toggle {
        display: flex;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }

    .mc-dict__toggle-btn {
        padding: 8px 10px;
        border: 0;
        background: transparent;
        cursor: pointer;
        font-size: 12px;
        color: #374151;
    }

    .mc-dict__toggle-btn--active {
        background: #111827;
        color: #fff;
    }

    .mc-dict__row {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 12px;
    }

    .mc-dict__inputwrap {
        flex: 1;
    }

    .mc-dict__input {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 12px;
        outline: none;
        font-size: 14px;
    }

    .mc-dict__btn {
        border: 0;
        border-radius: 12px;
        padding: 12px 14px;
        cursor: pointer;
        background: #ff7a00;
        color: #fff;
        font-weight: 700;
        font-size: 13px;
    }

    .mc-dict__btn:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .mc-dict__alert {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        padding: 10px 12px;
        border-radius: 12px;
        margin: 10px 0 14px 0;
    }

    .mc-dict__alert--error {
        border: 1px solid #fecaca;
        background: #fff1f2;
        color: #7f1d1d;
    }

    .mc-dict__alert-ico {
        font-size: 16px;
    }

    .mc-dict__alert-text {
        font-size: 13px;
    }

    .mc-dict__card {
        border: 2px solid #ff7a00;
        border-radius: 14px;
        padding: 14px;
        background: #fff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, .06);
    }

    .mc-dict__card-head {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .mc-dict__card-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #e0f2fe;
        font-size: 18px;
    }

    .mc-dict__card-titlebox {
        flex: 1;
    }

    .mc-dict__word {
        font-size: 26px;
        font-weight: 800;
        color: #111827;
        line-height: 1.1;
    }

    .mc-dict__word-sub {
        margin-top: 6px;
    }

    .mc-dict__chip {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 999px;
        background: #f3f4f6;
        color: #374151;
        font-size: 12px;
    }

    .mc-dict__card-input {
        min-width: 160px;
    }

    .mc-dict__miniinput {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px 10px;
        font-size: 13px;
        color: #111827;
        background: #fff;
    }

    .mc-dict__divider {
        height: 1px;
        background: #e5e7eb;
        margin: 12px 0;
    }

    .mc-dict__section {
        padding: 8px 0;
    }

    .mc-dict__section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 8px;
    }

    .mc-dict__section-ico {
        font-size: 16px;
    }

    .mc-dict__list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .mc-dict__list-item {
        font-size: 13px;
        color: #111827;
    }

    .mc-dict__linklike {
        color: #2563eb;
        font-weight: 700;
    }

    .mc-dict__muted {
        color: #6b7280;
        margin-left: 6px;
        font-size: 12px;
    }

    .mc-dict__muted--block {
        display: block;
        margin-left: 0;
        margin-top: 2px;
    }

    .mc-dict__text {
        font-size: 13px;
        color: #111827;
    }

    .mc-dict__kv {
        margin-bottom: 6px;
    }

    .mc-dict__kv-k {
        color: #6b7280;
        font-weight: 700;
        margin-right: 6px;
    }

    .mc-dict__kv-v {
        color: #111827;
    }

</style>
