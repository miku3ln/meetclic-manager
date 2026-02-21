<style id="gamification-test">
    :root{
        --bg: #0e1a1f;
        --text: #eaf2f7;
        --muted: #a9b8c2;
        --yellow: #f6c700;
        --btn: #56c7ff;
        --btnText: #0b1418;
        --cardPurple: #b58cff;
        --cardGreen: #6be27d;
        --cardBlue: #62d6ff;

        --radius-lg: 22px;
        --radius-md: 18px;
        --shadow: 0 10px 30px rgba(0,0,0,.25);
    }

    *{ box-sizing:border-box; }

    /* Block */
    .lesson{
        width:min(420px, 100%);
        min-height: auto;
        display:flex;
        flex-direction:column;
        padding: 28px 0px 0px;
        gap: 18px;
    }

    /* Top mascot */
    .lesson__hero{
        display:flex;
        align-items:center;
        justify-content:center;
        padding-top: 6px;
    }
    .lesson__hero-img{
        width: 160px;
        height: 160px;
        object-fit: contain;
        filter: drop-shadow(0 18px 30px rgba(0,0,0,.35));
        user-select:none;
    }

    /* Title */
    .lesson__title{
        text-align:center;
        font-weight: 900;
        font-size: 34px;
        letter-spacing: .2px;
        margin: 0;
        color: var(--yellow);
    }

    /* Cards row */
    .lesson__stats{
        display:grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 6px;
    }

    /* Card (element) */
    .stat-card{
        border-radius: var(--radius-md);
        padding: 12px 10px 10px;
        box-shadow: var(--shadow);
        border: 2px solid rgba(255,255,255,.18);
        background: rgba(255,255,255,.06);
        backdrop-filter: blur(6px);
        min-height: 94px;
        display:flex;
        flex-direction:column;
        justify-content:space-between;
        gap: 10px;
    }
    .stat-card__title{
        font-weight: 900;
        letter-spacing: .8px;
        font-size: 12px;
        opacity: .95;
        text-transform: uppercase;
        text-align: center;
    }
    .stat-card__content{
        display:flex;
        align-items:center;
        justify-content:center;
        gap: 8px;
        padding-bottom: 2px;
    }
    .stat-card__icon{
        width: 22px;
        height: 22px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
    }
    .stat-card__value{
        font-weight: 900;
        font-size: 22px;
        line-height: 1;
        letter-spacing: .3px;
    }

    /* Card modifiers */
    .stat-card--purple{ border-color: rgba(181,140,255,.65); }
    .stat-card--green{  border-color: rgba(107,226,125,.65); }
    .stat-card--blue{   border-color: rgba(98,214,255,.65); }

    /* CTA */
    .lesson__spacer{ flex: 1; }

    .lesson__cta{
        width: 100%;
        border: 0;
        border-radius: 18px;
        padding: 16px 18px;
        font-weight: 900;
        letter-spacing: 1px;
        background: var(--btn);
        color: var(--btnText);
        box-shadow: var(--shadow);
        cursor:pointer;
        text-transform: uppercase;
    }
    .lesson__cta:active{ transform: translateY(1px); }

    /* Bottom actions */
    .lesson__actions{
        display:flex;
        justify-content:space-between;
        gap: 12px;
        padding-top: 2px;
    }
    .icon-btn{
        width: 90px;
        height: 54px;
        border-radius: 16px;
        border: 2px solid rgba(255,255,255,.14);
        background: rgba(255,255,255,.06);
        box-shadow: var(--shadow);
        display:inline-flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
    }
    .icon-btn:active{ transform: translateY(1px); }
    .icon-btn__svg{ width: 26px; height: 26px; opacity: .95; }

    /* Small helper */
    .sr-only{
        position:absolute; width:1px; height:1px; padding:0; margin:-1px;
        overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0;
    }

    .lesson-intro{
        --pad-x: 16px;
        --pad-top: 14px;
        --footer-h: 92px;

        min-height: 79dvh;
        width: 100%;
        position: relative;

        background-image: var(--lesson-banner);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

        display: flex;
        flex-direction: column;
    }

    /* TOP BAR */
    .lesson-intro__topbar{
        display: grid;
        grid-template-columns: 44px 1fr;
        align-items: center;
        gap: 12px;
        padding: var(--pad-top) var(--pad-x) 8px;
    }

    .lesson-intro__icon-btn{
        width: 44px;
        height: 44px;
        border: 0;
        background: transparent;
        color: rgba(255,255,255,.75);
        display: grid;
        place-items: center;
        font-size: 22px;
    }

    .lesson-intro__progress{
        height: 14px;
        border-radius: 999px;
        background: rgba(255,255,255,.15);
        overflow: hidden;
        position: relative;
    }

    .lesson-intro__progress-bar{
        position: absolute;
        inset: 0 auto 0 0;
        width: 10%;
        border-radius: 999px;
        background: #4C4CFF; /* azulClic */
    }

    /* STAGE */
    .lesson-intro__stage{
        flex: 1;
        display: grid;
        align-items: center;
        padding: 0 var(--pad-x) calc(var(--footer-h) + 16px);
        grid-template-columns: 140px 1fr;
        gap: 14px;
    }

    .lesson-intro__mascot{
        width: 140px;
        max-width: 42vw;
        height: auto;
        align-self: end;
        justify-self: start;
        filter: drop-shadow(0 12px 24px rgba(0,0,0,.25));
    }

    /* Bubble */
    .lesson-intro__bubble{
        position: absolute;
        max-width: 520px;
        border-radius: 16px;
        padding: 14px 16px;
        background: rgba(0,0,0,.45);
        color: #fff;
        border: 1px solid rgba(255,255,255,.10);
        backdrop-filter: blur(6px);
        right: 0px;
        top: 1%;
    }

    .lesson-intro__bubble::before{
        display: none;
        content:"";
        position:absolute;
        left:-10px;
        top: 28px;
        width: 0; height: 0;
        border-top: 10px solid transparent;
        border-bottom: 10px solid transparent;
        border-right: 10px solid rgba(0,0,0,.45);
    }

    .lesson-intro__bubble-title{
        font-weight: 700;
        font-size: 18px;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .lesson-intro__bubble-text{
        font-size: 16px;
        line-height: 1.35;
        opacity: .95;
    }

    .lesson-intro__bubble-number{
        color: #FFCC00; /* amarilloVital */
        font-weight: 800;
    }

    /* FOOTER CTA */
    .lesson-intro__footer{
        position: sticky;
        bottom: 0;
        padding: 12px var(--pad-x) 18px;
        background: linear-gradient(to top, rgba(0,0,0,.55), rgba(0,0,0,0));
        display: grid;
        gap: 10px;
    }

    .lesson-intro__btn{
        width: 100%;
        border-radius: 14px;
        padding: 14px 16px;
        border: 0;
        font-weight: 800;
        letter-spacing: .8px;
    }

    .lesson-intro__btn--primary{
        background: #4C4CFF;
        color: #101010;
    }

    .lesson-intro__btn--ghost{
        background: rgba(255,255,255,.08);
        color: #fff;
        border: 1px solid rgba(255,255,255,.12);
    }

    /* Responsive: en pantallas muy angostas apila */
    @media (max-width: 420px){
        .lesson-intro__stage{
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .lesson-intro__mascot{
            justify-self: start;
        }
        .lesson-intro__bubble::before{
            left: 22px;
            top: -10px;
            border-right: 10px solid transparent;
            border-left: 10px solid transparent;
            border-bottom: 10px solid rgba(0,0,0,.45);
            border-top: 0;
        }
    }
</style>

    <style id="test-management-css">
        /* Block */
        .mc-toast {
            border: 0;
            overflow: hidden;
            min-width: 320px;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            border-radius: 14px;
        }

        /* Elements */
        .mc-toast__row {
            align-items: stretch;
        }

        .mc-toast__body {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
        }

        .mc-toast__icon {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            flex: 0 0 auto;
        }

        .mc-toast__content {
            line-height: 1.2;
        }

        .mc-toast__title {
            font-weight: 700;
        }

        .mc-toast__message {
            font-size: 0.875rem;
            opacity: .95;
        }

        /* MODIFIERS (Bootstrap palette) */
        .mc-toast--success {
            background: var(--bs-success-bg-subtle);
            color: var(--bs-success-text-emphasis);
        }

        .mc-toast--success .mc-toast__icon {
            background: var(--bs-success);
            color: #fff;
        }

        .mc-toast--warning {
            background: var(--bs-warning-bg-subtle);
            color: var(--bs-warning-text-emphasis);
        }

        .mc-toast--warning .mc-toast__icon {
            background: var(--bs-warning);
            color: #000;
        }

        .mc-toast--danger {
            background: var(--bs-danger-bg-subtle);
            color: var(--bs-danger-text-emphasis);
        }

        .mc-toast--danger .mc-toast__icon {
            background: var(--bs-danger);
            color: #fff;
        }

        :root {
            --mc-blue: #4C4CFF;
            --mc-yellow: #FFCC00;
            --mc-purple: #5C5CFF;
            --mc-dark: #2C2C2C;
            --mc-bg: #F6F7FB;
            --mc-card: #FFFFFF;
            --mc-border: #E6E8F2;
            --mc-muted: #6B7280;
            --mc-ok: #14A44D;
            --mc-bad: #D32F2F;
            --mc-shadow: 0 10px 30px rgba(20, 22, 60, .08);
            --mc-radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, "Noto Sans", "Helvetica Neue";
            background: var(--mc-bg);
            color: var(--mc-dark);
        }

        .mc-app {
            max-width: 1180px;
            margin: 0 auto;
            padding: 18px;
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 14px;
        }

        .mc-header {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, rgba(76, 76, 255, .12), rgba(255, 204, 0, .10));
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            padding: 16px;
            box-shadow: var(--mc-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .mc-header__title {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .mc-header__title h1 {
            margin: 0;
            font-size: 18px;
            letter-spacing: .2px;
        }

        .mc-header__subtitle {
            font-size: 12px;
            color: var(--mc-muted);
            line-height: 1.35;
            max-width: 760px;
        }

        .mc-header__actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            justify-content: flex-end;
        }

        .mc-btn {
            border: 1px solid var(--mc-border);
            background: var(--mc-card);
            color: var(--mc-dark);
            padding: 10px 12px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 700;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform .06s ease, border-color .12s ease, background .12s ease;
            user-select: none;
        }

        .mc-btn:active {
            transform: translateY(1px);
        }

        .mc-btn--primary {
            border-color: rgba(76, 76, 255, .35);
            background: rgba(76, 76, 255, .08);
            color: var(--mc-blue);
        }

        .mc-btn--danger {
            border-color: rgba(211, 47, 47, .35);
            background: rgba(211, 47, 47, .06);
            color: var(--mc-bad);
        }

        .mc-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
            transform: none;
        }

        .mc-panel {
            background: var(--mc-card);
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            box-shadow: var(--mc-shadow);
            overflow: hidden;
            min-height: 520px;
        }

        .mc-panel__head {
            display: none !important;
            padding: 45px 14px 10px;
            border-bottom: 1px solid var(--mc-border);

            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .mc-panel__head h2 {
            margin: 0;
            font-size: 14px;
        }

        .mc-panel__hint {
            font-size: 12px;
            color: var(--mc-muted);
            margin-top: 4px;
            line-height: 1.35;
        }

        .mc-panel__body {
            padding: 14px;
        }

        /* Left: JSON loader + steps */
        .mc-loader__textarea {
            width: 100%;
            min-height: 170px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            padding: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 12px;
            line-height: 1.4;
            outline: none;
            background: #fff;
        }

        .mc-loader__row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
            align-items: center;
            justify-content: space-between;
        }

        .mc-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid var(--mc-border);
            background: #fff;
            color: var(--mc-muted);
            user-select: none;
            white-space: nowrap;
        }

        .mc-chip--ok {
            color: var(--mc-ok);
            border-color: rgba(20, 164, 77, .25);
            background: rgba(20, 164, 77, .06);
        }

        .mc-chip--bad {
            color: var(--mc-bad);
            border-color: rgba(211, 47, 47, .25);
            background: rgba(211, 47, 47, .06);
        }

        .mc-chip--info {
            display: none;
            color: var(--mc-blue);
            border-color: rgba(76, 76, 255, .25);
            background: rgba(76, 76, 255, .06);
        }
        button#mcBtnVerify {
            width: 100%;
            height: 54px;
            font-size: 21px;
            text-align: center !important;
            padding-left: 7%;
        }
        .mc-steps {
            width: 91%;
            position: fixed;
            margin-top: 25px !important;

            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .mc-panel__hint{
            display: none;
        }
        span.mc-dropzone__label--answer{
            display: none;
        }
        .mc-step {
            border: 1px solid var(--mc-border);
            background: #fff;
            border-radius: 14px;
            padding: 10px 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            cursor: pointer;
            transition: border-color .12s ease, background .12s ease;
        }

        .mc-step:hover {
            border-color: rgba(76, 76, 255, .25);
        }

        .mc-step.is-active {
            border-color: rgba(76, 76, 255, .55);
            background: rgba(76, 76, 255, .06);
        }

        .mc-step.is-locked {
            opacity: .55;
            cursor: not-allowed;
        }

        .mc-step__left {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .mc-step__kicker {
            font-size: 11px;
            color: var(--mc-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mc-step__title {
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mc-step__right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .mc-step__badge {
            width: 26px;
            height: 26px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            border: 1px solid var(--mc-border);
            font-weight: 900;
            font-size: 12px;
            color: var(--mc-muted);
            background: #fff;
        }

        .mc-step__state {
            font-size: 12px;
            font-weight: 800;
            color: var(--mc-muted);
        }

        .mc-step__state.is-ok {
            color: var(--mc-ok);
        }

        .mc-step__state.is-bad {
            color: var(--mc-bad);
        }

        .mc-step__state.is-next {
            color: var(--mc-blue);
        }

        /* Right: exercise */
        .mc-ex {
            margin-top: 10%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .mc-ex__top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .mc-ex__meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 240px;
            flex: 1;
        }

        .mc-ex__metaTitle {
            font-size: 16px;
            font-weight: 900;
            margin: 0;
        }

        .mc-ex__metaSub {
            color: var(--mc-muted);
            font-size: 12px;
            line-height: 1.35;
        }

        .mc-ex__controls {
            width: 87%;
            display: block;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
            position: fixed;
            bottom: 4%;
            z-index: 1500;
        }

        .mc-ex__stage {
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            padding: 12px;
            background: #fff;
        }

        .mc-ex__prompt {
            font-weight: 800;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .mc-ex__result {
            margin-top: 10px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid var(--mc-border);
            background: #fff;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.25;
        }

        .mc-ex__result.is-ok {
            border-color: rgba(20, 164, 77, .25);
            background: rgba(20, 164, 77, .06);
            color: var(--mc-ok);
        }

        .mc-ex__result.is-bad {
            border-color: rgba(211, 47, 47, .25);
            background: rgba(211, 47, 47, .06);
            color: var(--mc-bad);
        }

        /* Audio preview */
        .mc-audio {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .mc-audio__player {
            width: 100%;
            max-width: 520px;
        }

        .mc-audio__src {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 11px;
            color: var(--mc-muted);
            border: 1px dashed rgba(107, 114, 128, .45);
            background: rgba(246, 247, 251, .7);
            padding: 6px 8px;
            border-radius: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 520px;
        }

        /* Exercise primitives (BEM) */
        .mc-tokenList {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .mc-tokenList__item {
            padding: 10px 12px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            background: #fff;
            cursor: grab;
            font-weight: 800;
            font-size: 13px;
            user-select: none;
        }

        .mc-dropzone {
            border: 1px dashed rgba(107, 114, 128, .55);
            border-radius: 14px;
            padding: 10px;
            background: rgba(246, 247, 251, .6);
            min-height: 56px;
        }

        .mc-dropzone__label {
            font-size: 11px;
            color: var(--mc-muted);
            margin-bottom: 6px;
            font-weight: 800;
        }

        .mc-grid2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .mc-input {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            outline: none;
            font-size: 14px;
            font-weight: 700;
        }

        .mc-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .mc-option {
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
        }

        .mc-option__text {
            font-weight: 800;
            font-size: 13px;
        }

        .mc-hay {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .mc-hay__btn {
            padding: 10px 12px;
            border: 1px solid var(--mc-border);
            border-radius: 14px;
            background: #fff;
            cursor: pointer;
            font-weight: 900;
            font-size: 13px;
            transition: opacity .12s ease, border-color .12s ease, background .12s ease;
        }

        .mc-hay__btn.is-picked {
            opacity: .6;
            border-color: rgba(76, 76, 255, .35);
            background: rgba(76, 76, 255, .06);
        }

        /* ===== NEW: MULTI_SELECT_IMAGE ===== */
        .mc-msi {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .mc-msi__imgBox {
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            overflow: hidden;
            background: #fff;
        }

        .mc-msi__img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* ===== NEW: IMAGE_HOTSPOT_PICK ===== */
        .mc-hot {
            border: 1px solid var(--mc-border);
            border-radius: var(--mc-radius);
            overflow: hidden;
            background: #fff;
        }

        .mc-hot__frame {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        .mc-hot__img {
            width: 100%;
            height: auto;
            display: block;
        }

        .mc-hot__spot {
            position: absolute;
            transform: translate(-50%, -50%);
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, .9);
            background: rgba(76, 76, 255, .85);
            box-shadow: 0 10px 20px rgba(20, 22, 60, .18);
            cursor: pointer;
            display: grid;
            place-items: center;
            user-select: none;
            transition: transform .08s ease, opacity .12s ease, background .12s ease;
        }

        .mc-hot__spot:active {
            transform: translate(-50%, -50%) scale(.98);
        }

        .mc-hot__spot.is-picked {
            background: rgba(20, 164, 77, .92);
        }

        .mc-hot__spot.is-wrong {
            background: rgba(211, 47, 47, .90);
        }

        .mc-hot__check {
            width: 20px;
            height: 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .92);
            display: grid;
            place-items: center;
            font-weight: 900;
            color: var(--mc-dark);
            font-size: 13px;
        }

        .mc-hot__label {
            position: absolute;
            transform: translate(-50%, calc(-50% - 26px));
            background: #fff;
            border: 1px solid var(--mc-border);
            border-radius: 12px;
            padding: 6px 8px;
            font-weight: 900;
            font-size: 12px;
            color: var(--mc-dark);
            white-space: nowrap;
            box-shadow: var(--mc-shadow);
            pointer-events: none;
        }

        .mc-hot__legend {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .mc-hot__legendItem {
            border: 1px solid var(--mc-border);
            background: #fff;
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 900;
            color: var(--mc-muted);
        }

        .mc-hot__legendItem strong {
            color: var(--mc-dark);
        }

        @media (max-width: 980px) {
            .mc-app {
                grid-template-columns: 1fr;
            }
        }

        /* ==========================================================
           UI FIX: Layout tipo "app" con scroll interno (no gestión)
           ========================================================== */

        /* 1) Viewport-height layout */
        html, body {
            height: 100%;
        }

        body {
            overflow: hidden;
        }

        /* evita scroll global feo */

        .mc-app {
            height: 100vh;
            align-content: start;
        }

        /* 2) Header sticky */
        .mc-header {
            position: sticky;
            top: 12px;
            z-index: 20;
        }

        /* 3) Panels: ocupar altura disponible y permitir scroll interno */
        .mc-panel {
            min-height: 0; /* clave para grids + overflow */
            height: calc(100vh - 18px - 18px - 86px);
            /* 18+18 padding top/bottom de .mc-app, 86 aprox header */
            display: flex;
            flex-direction: column;

            width: 582px;
            margin-left: 32%;
        }

        .mc-panel__body {
            flex: 1;
            min-height: 0;
            overflow: auto;
        }

        /* 4) Steps list: que no empuje el layout */
        .mc-steps {
            max-height: none;
        }

        /* 5) Ejercicio: evitar saltos visuales */
        .mc-ex__stage {
            position: relative;
        }

        .mc-ex__result {
            margin-top: 12px;
        }

        /* 6) Tokens/haystack: más “táctil” */
        .mc-tokenList__item,
        .mc-hay__btn,
        .mc-step,
        .mc-btn {
            -webkit-tap-highlight-color: transparent;
        }

        .mc-tokenList__item:active,
        .mc-hay__btn:active {
            transform: translateY(1px);
        }

        /* 7) Hotspots: labels menos invasivos */
        .mc-hot__label {
            max-width: 220px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* 8) Responsive: en móvil permitir scroll global (porque sticky + 100vh en iOS a veces) */
        @media (max-width: 980px) {
            body {
                overflow: auto;
            }

            .mc-app {
                height: auto;
                padding: 12px;
            }

            .mc-header {
                position: relative;
                top: auto;
            }

            .mc-panel {
                height: auto;
            }

            /* Hotspot labels se esconden en móvil para no tapar imagen */
            .mc-hot__label {
                display: none;
            }

            .mc-header__subtitle {
                max-width: 100%;
            }
        }

        body.mc-is-scrolling .mc-header {
            padding: 12px;
            backdrop-filter: blur(8px);
        }

        body.mc-is-scrolling .mc-header__subtitle {
            display: none;
        }



        /* === COMPACT STEPS BAR === */
        .mc-stepsbar{
            display:flex;
            align-items:center;
            gap:12px;
            padding:10px 12px;
            border:1px solid var(--mc-border);
            background: var(--mc-card);
            border-radius: 14px;
            box-shadow: var(--mc-shadow);
        }

        .mc-stepsbar__icon{
            width:34px;
            height:34px;
            border-radius: 10px;
            display:flex;
            align-items:center;
            justify-content:center;
            background: rgba(76,76,255,.10);
            flex:0 0 auto;
        }
        .mc-stepsbar__icon img{ width:20px; height:20px; display:block; }

        .mc-stepsbar__track{
            position:relative;
            flex:1 1 auto;
            height:14px;
            border-radius: 999px;
            background: rgba(44,44,44,.10);
            overflow:hidden;
        }
        .mc-stepsbar__fill{
            position:absolute;
            left:0; top:0; bottom:0;
            background: var(--mc-blue);
            border-radius: 999px;
        }

        .mc-stepsbar__dots{
            position:absolute;
            inset:0;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 6px;
            pointer-events:auto;
        }

        .mc-stepsbar__dot{
            width:10px;
            height:10px;
            border-radius:999px;
            border:0;
            background: rgba(255,255,255,.85);
            cursor:pointer;
            transform: scale(1);
            transition: transform .12s ease, opacity .12s ease;
        }
        .mc-stepsbar__dot:hover{ transform: scale(1.2); }

        .mc-stepsbar__dot.is-ok{ background: var(--mc-ok); }
        .mc-stepsbar__dot.is-bad{ background: var(--mc-bad); }
        .mc-stepsbar__dot.is-next{ background: var(--mc-yellow); }
        .mc-stepsbar__dot.is-active{
            outline: 2px solid rgba(76,76,255,.45);
            outline-offset: 2px;
        }
        .mc-stepsbar__dot.is-locked{
            opacity:.35;
            cursor:not-allowed;
        }

        .mc-stepsbar__meta{
            flex:0 0 auto;
            font-weight:700;
            color: var(--mc-dark);
        }
        .mc-stepsbar__pct{
            display:inline-block;
            min-width:44px;
            text-align:right;
        }
        button#mcBtnShowAnswer {
            display: none;
        }
        button#mcBtnShowHistory {
            display: none;
        }
    </style>
<style>
#toast-main-content{
   bottom: 15% !important;
}
</style>
