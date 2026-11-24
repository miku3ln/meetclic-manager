<style>
    /* =========================================================
YAPITA BUSINESS MAP MARKER
Configuración dinámica mediante variables CSS
========================================================= */


    /* =========================================================
       1. CONTENEDOR PRINCIPAL LEAFLET
       ========================================================= */

    .business-map-marker-container {

        background: transparent !important;

        border: none !important;

        padding: 0;

        overflow: visible !important;

        box-sizing: border-box;

        cursor: pointer;

    }

    /*
     * IMPORTANTE:
     *
     * No aplicar transform, translate ni animaciones
     * directamente sobre este contenedor.
     *
     * Leaflet administra su posicionamiento.
     */


    /* =========================================================
       2. CONTENEDOR DE ESCALA DINÁMICA
       ========================================================= */

    .business-map-marker-container__scale {

        position: relative;

        width: var(--business-marker-base-size, 56px);

        height: var(--business-marker-base-size, 56px);

        transform: scale(
            var(--business-marker-scale, 1)
        );

        transform-origin: top left;

        overflow: visible;

        box-sizing: border-box;

    }


    /* =========================================================
       3. MARCADOR PRINCIPAL
       ========================================================= */

    .business-map-marker {

        position: relative;

        display: block;

        width: 100%;

        height: 100%;

        padding: 0;

        margin: 0;

        background: transparent;

        overflow: visible;

        box-sizing: border-box;

    }

    .business-map-marker [hidden] {

        display: none !important;

    }


    /* =========================================================
       4. CONTENEDOR DE REBOTE
       ========================================================= */

    .business-map-marker__bounce-content {

        position: relative;

        width: 100%;

        height: 100%;

        overflow: visible;

        box-sizing: border-box;

        transform-origin: center bottom;

    }


    /* =========================================================
       5. APARIENCIA DE IMAGEN Y FALLBACK
       ========================================================= */

    .business-map-marker__image,
    .business-map-marker__fallback {

        position: relative;

        z-index: 2;

        width: 100%;

        height: 100%;

        margin: 0;

        padding: 0;

        box-sizing: border-box;

        background:
            var(--business-marker-background, #ffffff);

        color:
            var(--business-marker-color, #4354eb);

        border-style: solid;

        border-width:
            var(--business-marker-border-width, 3px);

        border-color:
            var(--business-marker-border-color, #ffffff);

        border-radius:
            var(--business-marker-border-radius, 50%);

        box-shadow:
            var(--business-marker-shadow, none);

        overflow: hidden;

        user-select: none;

        -webkit-user-select: none;

        pointer-events: none;

    }


    /* =========================================================
       6. IMAGEN DE LA EMPRESA
       ========================================================= */

    .business-map-marker__image {

        display: block;

        object-fit:
            var(--business-marker-object-fit, cover);

        object-position: center;

        -webkit-user-drag: none;

    }


    /* =========================================================
       7. ICONO CUANDO NO EXISTE IMAGEN
       ========================================================= */

    .business-map-marker__fallback {

        display: flex;

        align-items: center;

        justify-content: center;

        font-size:
            var(--business-marker-fallback-font-size, 26px);

        line-height: 1;

    }


    /* =========================================================
       8. ANIMACIÓN DINÁMICA DE REBOTE
       ========================================================= */

    .business-map-marker--bounce
    .business-map-marker__bounce-content {

        animation-name:
            yapita-business-marker-bounce;

        animation-duration:
            var(--business-bounce-duration, 1200ms);

        animation-timing-function:
            var(--business-bounce-timing, ease-in-out);

        animation-iteration-count: infinite;

    }

    @keyframes yapita-business-marker-bounce {

        0%,
        100% {

            transform: translateY(0);

        }

        50% {

            transform: translateY(
                calc(
                    -1 * var(--business-bounce-height, 10px)
                )
            );

        }

    }


    /* =========================================================
       9. ONDAS DE PULSO
       ========================================================= */

    .business-map-marker__pulse-wave {

        position: absolute;

        inset: 0;

        z-index: 1;

        display: block;

        box-sizing: border-box;

        background: transparent;

        border-style: solid;

        border-width:
            var(--business-pulse-border-width, 2px);

        border-color:
            var(--business-pulse-color, #8b24dc);

        border-radius:
            var(--business-marker-border-radius, 50%);

        opacity: 0;

        pointer-events: none;

        transform-origin: center;

    }


    /* Activar únicamente cuando corresponde */

    .business-map-marker--pulse
    .business-map-marker__pulse-wave {

        animation-name:
            yapita-business-marker-pulse;

        animation-duration:
            var(--business-pulse-duration, 1800ms);

        animation-timing-function:
            var(--business-pulse-timing, ease-out);

        animation-delay:
            var(--business-pulse-wave-delay, 0ms);

        animation-iteration-count: infinite;

    }


    @keyframes yapita-business-marker-pulse {

        0% {

            transform: scale(1);

            opacity:
                var(--business-pulse-opacity, 0.65);

        }

        100% {

            transform: scale(
                var(--business-pulse-scale, 1.6)
            );

            opacity: 0;

        }

    }


    /* =========================================================
       10. DISTINTIVO DE NOVEDADES
       Promociones, eventos, publicidad y rutas
       ========================================================= */

    .business-map-marker__news {

        position: absolute;

        z-index: 4;

        top:
            var(--business-badge-top, -9px);

        right:
            var(--business-badge-right, -9px);

        width:
            var(--business-badge-size, 28px);

        height:
            var(--business-badge-size, 28px);

        display: flex;

        align-items: center;

        justify-content: center;

        box-sizing: border-box;

        background:
            var(--business-badge-color, #4354eb);

        color:
            var(--business-badge-text-color, #ffffff);

        border-style: solid;

        border-width:
            var(--business-badge-border-width, 3px);

        border-color:
            var(--business-badge-border-color, #ffffff);

        border-radius: 50%;

        font-size:
            var(--business-badge-font-size, 13px);

        line-height: 1;

        pointer-events: none;

        user-select: none;

    }


    /* Compatibilidad con Bootstrap Icons */

    .business-map-marker__news i,
    .business-map-marker__news .bi {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        color: inherit;

        font-size: inherit;

        line-height: 1;

    }

    .business-map-marker__news .bi::before {

        line-height: 1;

    }


    /* =========================================================
       11. CONTADOR DE EMPRESAS AGRUPADAS
       ========================================================= */

    .business-map-marker__count {

        position: absolute;

        z-index: 5;

        bottom:
            var(--business-counter-bottom, -5px);

        right:
            var(--business-counter-right, -5px);

        min-width:
            var(--business-counter-size, 24px);

        height:
            var(--business-counter-size, 24px);

        padding: 0 4px;

        display: flex;

        align-items: center;

        justify-content: center;

        box-sizing: border-box;

        background:
            var(--business-counter-background, #4354eb);

        color:
            var(--business-counter-color, #ffffff);

        border-style: solid;

        border-width:
            var(--business-counter-border-width, 2px);

        border-color:
            var(--business-counter-border-color, #ffffff);

        border-radius: 999px;

        font-size:
            var(--business-counter-font-size, 12px);

        font-weight: 700;

        line-height: 1;

        white-space: nowrap;

        pointer-events: none;

        user-select: none;

    }


    /* =========================================================
       12. MARCADORES AGRUPADOS
       ========================================================= */

    .business-map-marker--grouped {

        overflow: visible;

    }

    /*
     * No desactivar aquí el rebote, pulso o distintivo.
     *
     * JavaScript controla estas condiciones mediante:
     *
     * bounce.allowGrouped
     * pulse.allowGrouped
     * badge.allowGrouped
     */


    /* =========================================================
       13. ACCESIBILIDAD
       ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .business-map-marker__bounce-content,
        .business-map-marker__pulse-wave {

            animation: none !important;

        }

        .business-map-marker__pulse-wave {

            opacity: 0;

        }

    }
    /* =========================================================
YAPITA - USER LOCATION MARKER
Compatible con Maskana
========================================================= */


    /* =========================================================
       1. CONTENEDOR LEAFLET
       ========================================================= */

    .maskana-user-location-marker {

        background: transparent !important;

        border: none !important;

        padding: 0;

        overflow: visible !important;

        box-sizing: border-box;

    }


    /* =========================================================
       2. MARCADOR DEL USUARIO
       ========================================================= */

    .maskana-user-pumpkin {

        position: relative;

        display: flex;

        align-items: center;

        justify-content: center;

        width:
            var(--user-marker-size, 64px);

        height:
            var(--user-marker-size, 64px);

        overflow: visible;

        box-sizing: border-box;

        color:
            var(--user-marker-color, #f97316);

    }


    /* =========================================================
       3. ICONO DEL USUARIO
       ========================================================= */

    .maskana-user-pumpkin__emoji {

        position: relative;

        z-index: 2;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size:
            var(--user-marker-icon-size, 32px);

        color:
            var(--user-marker-color, #f97316);

        line-height: 1;

        user-select: none;

    }

    .maskana-user-pumpkin__emoji .bi {

        font-size: inherit;

        color: inherit;

        line-height: 1;

    }


    /* =========================================================
       4. REBOTE DEL USUARIO
       ========================================================= */

    .maskana-user-pumpkin--bounce
    .maskana-user-pumpkin__emoji {

        animation-name:
            yapita-user-location-bounce;

        animation-duration:
            var(--user-marker-bounce-duration, 1200ms);

        animation-timing-function:
            var(--user-marker-bounce-timing, ease-in-out);

        animation-iteration-count: infinite;

    }

    @keyframes yapita-user-location-bounce {

        0%,
        100% {

            transform: translateY(0);

        }

        50% {

            transform: translateY(
                calc(
                    -1 * var(--user-marker-bounce-height, 8px)
                )
            );

        }

    }


    /* =========================================================
       5. PULSO DEL USUARIO
       ========================================================= */

    .maskana-user-pumpkin__pulse {

        position: absolute;

        inset: 0;

        z-index: 1;

        box-sizing: border-box;

        border-radius: 50%;

        border-style: solid;

        border-width:
            var(--user-marker-pulse-border-width, 2px);

        border-color:
            var(--user-marker-pulse-color, #f97316);

        background: transparent;

        opacity: 0;

        pointer-events: none;

    }

    .maskana-user-pumpkin--pulse
    .maskana-user-pumpkin__pulse {

        animation-name:
            yapita-user-location-pulse;

        animation-duration:
            var(--user-marker-pulse-duration, 1800ms);

        animation-timing-function:
            var(--user-marker-pulse-timing, ease-out);

        animation-delay:
            var(--user-marker-pulse-wave-delay, 0ms);

        animation-iteration-count: infinite;

    }

    @keyframes yapita-user-location-pulse {

        0% {

            transform: scale(1);

            opacity:
                var(--user-marker-pulse-opacity, 0.65);

        }

        100% {

            transform: scale(
                var(--user-marker-pulse-scale, 1.8)
            );

            opacity: 0;

        }

    }


    /* =========================================================
       6. ETIQUETA ESTÁS AQUÍ
       ========================================================= */

    .maskana-user-pumpkin__label {

        position: absolute;

        z-index: 3;

        top: 100%;

        left: 50%;

        transform: translateX(-50%);

        padding:
            var(--user-marker-label-padding, 4px 10px);

        background:
            var(--user-marker-label-background, #ffffff);

        color:
            var(--user-marker-label-color, #172033);

        font-size:
            var(--user-marker-label-font-size, 11px);

        font-weight:
            var(--user-marker-label-font-weight, 600);

        border-radius:
            var(--user-marker-label-border-radius, 20px);

        box-shadow:
            var(--user-marker-label-shadow, 0 2px 8px rgba(0,0,0,.15));

        line-height: 1.4;

        white-space: nowrap;

        pointer-events: none;

    }


    /* =========================================================
       7. ACCESIBILIDAD
       ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .maskana-user-pumpkin__emoji,
        .maskana-user-pumpkin__pulse {

            animation: none !important;

        }

        .maskana-user-pumpkin__pulse {

            opacity: 0;

        }

    }
</style>
