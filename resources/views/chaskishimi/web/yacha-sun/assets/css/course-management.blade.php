<style>


    /* ====== Layout general ====== */
    .mc-elements {
        width: 100vw;
        margin: 0px auto;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0px;
    }

    /* Tablet */
    @media (max-width: 992px) {
        .mc-elements {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .mc-element__stack {

            gap: 0px !important;
        }

        .mc-element__head {

        }
    }


    /* Mobile: cada sección hacia abajo */
    @media (max-width: 560px) {
        .content {
            padding-top: 4% !important;

        }

        .mc-elements {
            width: 100%;
            margin-right: 0px;
            margin-left: 0px !important;
            grid-template-columns: 1fr;
        }

        .mc-element__stack {

            gap: 0px !important;
        }

        .mc-element__head {
            margin-top: 2% !important;
            text-align: left !important;
            margin-left: 7% !important;
            margin-bottom: -39px !important;
        }
    }

    /* ====== Section (Elemento) ====== */
    .mc-element {
        width: 100%;
        height: calc((95dvh - var(--mc-nav-h)) * 1);

        display: flex;
        flex-direction: column;

        background-image: var(--mc-banner);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    /* ✅ el banner es un pseudo-element */

    .mc-element__photo {
        width: 100%;
        height: 22%; /* ✅ parte del 80vh (ajusta: 20%–30%) */
        min-height: 140px; /* para que no se haga muy pequeño */
        object-fit: cover;
        object-position: center;
        display: block;
    }

    .mc-element__head {
        margin-bottom: 12px;

    }

    .mc-element__title {
        font-weight: 900;
        font-size: clamp(22px, 2.6vw, 40px);
        margin: 0;
        color: #f1872e;
    }

    .mc-element__subtitle {
        margin-top: 4px;
        font-size: 14px;
        opacity: .75;
        color: #ffffff;
        font-weight: bold;
    }

    /* stack de wheels */
    .mc-element__stack {
        display: grid;
        gap: 18px;
        justify-items: center;
        align-items: center;
        overflow: inherit;
        overflow: inherit;
    }

    /* ====== Wheel ====== */
    .mc-wheel {
        position: relative;
        width: var(--mc-wheel-size, 120px);
        height: var(--mc-wheel-size, 120px);
        padding: 0px; /* espacio para sombra/glow */
        overflow: visible;
    }

    .mc-wheel__svg {
        display: block;
        width: 100%;
        height: 100%;
        overflow: visible;
    }

    .mc-wheel__hit-gap {
        stroke: #fff;
        stroke-width: 2;
    }

    .mc-wheel__sector {
        cursor: pointer;
        transition: filter .18s ease, opacity .18s ease, transform .18s ease;
        transform-origin: 0 0;
    }

    .mc-wheel__sector:hover {
        filter: brightness(1.08);
    }

    .mc-wheel__sector.is-active {
        filter: brightness(1.14);
    }

    .mc-wheel.is-disabled {
        opacity: .45;
        filter: grayscale(.25);
    }

    .mc-wheel__sector.is-disabled {
        cursor: not-allowed;
        opacity: .45;
        filter: none;
    }

    .mc-wheel__sector.is-disabled:hover {
        filter: none;
    }

    /* ====== Center ====== */
    .mc-wheel__center {
        position: absolute;
        /*    left: 50%;*/
        top: 50%;
        transform: translate(-50%, -50%);
        width: var(--mc-center-size, 48px);
        height: var(--mc-center-size, 48px);
        border-radius: 999px;
        background: #fff;
        box-shadow: 0 10px 22px rgba(0, 0, 0, .08);
        display: grid;
        place-items: center;
    }

    .mc-wheel__center-img {
        width: var(--mc-center-img-size, 34px);
        height: var(--mc-center-img-size, 34px);
        border-radius: 999px;
        object-fit: contain;
        display: block;
        max-width: none;
        transition: opacity .18s ease, filter .18s ease;
    }

    .mc-wheel__center-img.is-disabled {
        opacity: .35;
        filter: grayscale(1);
        pointer-events: none;
    }

    /* ====== Pulse seguro (NO scale) ====== */
    .mc-wheel__svg.is-pulsing {
        animation: mcWheelGlow var(--mc-pulse-ms, 1200ms) ease-in-out infinite;
        transform: none !important; /* blindaje */
    }

    @keyframes mcWheelGlow {
        0% {
            filter: drop-shadow(0 0 0 rgba(0, 0, 0, 0));
        }
        50% {
            filter: drop-shadow(0 10px 18px rgba(0, 0, 0, .12));
        }
        100% {
            filter: drop-shadow(0 0 0 rgba(0, 0, 0, 0));
        }
    }

    section.mc-element {
        display: block;
        unicode-bidi: isolate;
    }


</style>
