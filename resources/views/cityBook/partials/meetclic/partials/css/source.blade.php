<style>
    /* =========================
      MeetClic Palette
      azulClic:      #4C4CFF
      amarilloVital: #FFCC00
      blanco:        #FFFFFF
      grisOscuro:    #2C2C2C
      moradoSuave:   #5C5CFF
      ========================= */

    .mc-soon {
        padding-top: 9%;
        background: #FFFFFF; /* azulClic */
        color: #4C4CFF;
    }

    .mc-soon__container {
    //  max-width: 980px;
    }

    .mc-soon__card {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        padding: 26px 22px;
        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 14px 40px rgba(0, 0, 0, 0.18);
        backdrop-filter: blur(10px);
    }

    /* Decorative floating blobs */
    .mc-soon__card::before,
    .mc-soon__card::after {
        content: "";
        position: absolute;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        filter: blur(0px);
        opacity: 0.45;
        pointer-events: none;
    }

    .mc-soon__card::before {
        top: -160px;
        left: -120px;
        background: #FFCC00; /* amarilloVital */
    }

    .mc-soon__card::after {
        bottom: -170px;
        right: -140px;
        background: #5C5CFF; /* moradoSuave */
    }

    .mc-soon__brand {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }

    .mc-soon__brand-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-weight: 800;
        letter-spacing: 0.4px;
        background: #FFCC00; /* amarilloVital */
        color: #2C2C2C;      /* grisOscuro */
        text-transform: uppercase;
        font-size: 12px;
    }

    .mc-soon__brand-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #FFFFFF;
        opacity: 0.85;
    }

    .mc-soon__brand-text {
        font-size: 13px;
        opacity: 0.92;
    }

    .mc-soon__title {
        margin: 0 0 6px;
        font-size: 44px;
        font-weight: 900;
        line-height: 1.05;
        letter-spacing: -0.6px;
    }

    .mc-soon__subtitle {
        margin: 0 0 12px;
        font-size: 18px;
        font-weight: 700;
        opacity: 0.98;
    }

    .mc-soon__subtitle-highlight {
        display: inline-block;
        margin-left: 6px;
        padding: 2px 10px;
        border-radius: 999px;
        background: rgba(255, 204, 0, 0.18);
        border: 1px solid rgba(255, 204, 0, 0.40);
        color: #FFCC00;
        font-weight: 900;
    }

    .mc-soon__desc {
        margin: 0 0 16px;
        font-size: 15px;
        line-height: 1.55;
        color: rgb(79 92 249);

    }

    .mc-soon__values {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin: 16px 0 18px;
    }


    .mc-soon__value {
        display: flex;
        gap: 12px;
        align-items: center;
        padding: 12px 12px;
        border-radius: 14px;
        background: rgb(79 92 249 / 10%);
        border: 1px solid rgba(255, 255, 255, 0.16);
        height: 102px;
    }

    .mc-soon__value-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 204, 0, 0.20);
        border: 1px solid rgba(255, 204, 0, 0.45);
        font-size: 18px;
    }

    .mc-soon__value-title {
        font-weight: 900;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .mc-soon__value-sub {
        font-size: 12.5px;
        opacity: 0.92;
    }

    .mc-soon__cta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .mc-soon__btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        padding: 11px 14px;
        text-decoration: none !important;
        font-weight: 800;
        font-size: 14px;
        transition: transform 0.12s ease, opacity 0.12s ease;
        user-select: none;
    }

    .mc-soon__btn:active {
        transform: scale(0.98);
    }

    .mc-soon__btn--primary {
        background: #FFCC00; /* amarilloVital */
        color: #2C2C2C;      /* grisOscuro */
        border: 1px solid rgba(0, 0, 0, 0.10);
    }

    .mc-soon__btn--ghost {
        background: rgb(79 92 249);
        color: #FFFFFF;
        border: 1px solid rgba(255, 255, 255, 0.22);
    }
    a:hover {
        color: #FFFFFF !important;
    }
    .mc-soon__btn:hover {
        opacity: 0.95;
    }

    .mc-soon__note {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px dashed rgba(255, 255, 255, 0.28);
    }

    .mc-soon__note-badge {
        font-size: 12px;
        font-weight: 900;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(255, 204, 0, 0.18);
        border: 1px solid rgba(255, 204, 0, 0.40);
        color: #FFCC00;
    }

    .mc-soon__note-text {
        font-size: 12.8px;
        opacity: 0.92;
    }
    .mc-soon {
        height: 100%;
    }
    .py-4 {
         padding-top: 0rem !important;
        padding-bottom: 0rem !important;
    }
    main#render-main {
        width: 100%;
        height: 100%;
    }
    div#app {
        width: 100%;
        height: 100%;
    }

    /* SM */
    @media (max-width: 575.98px){
        .mc-soon{
            padding: 27% 0 28px 0;
        }
    }
    @media (min-width: 576px){
        .mc-soon{
            padding: 12% 0 28px 0; /* top right bottom left */
        }
    }

    /* MD */
    @media (min-width: 768px){
        .mc-soon{
            padding: 10% 0 28px 0;
        }
    }

    /* LG */
    @media (min-width: 992px){
        .mc-soon{
            padding: 8% 0 28px 0;
        }
    }

    /* XL */
    @media (min-width: 1200px){
        .mc-soon{
            padding: 6% 0 28px 0;
        }
    }

</style>
