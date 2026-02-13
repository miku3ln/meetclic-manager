<style id="menu-top-gamification">
    .mc-icbar{
        background:#f2f5f5;
        z-index:18;
        width:100%;
        border-radius:14px;
        top:0.10%;
        position:fixed;

        display:flex;
        align-items:center;

        /* ✅ equitativo */
        justify-content:space-between;   /* o space-evenly */
        flex-wrap:nowrap;               /* ✅ sin wrap para que sea equitativo */
        gap:0;                          /* gap rompe el “equity” */
        padding:6px 10px;               /* un poquito de aire */
    }

    .mc-icbar__item{
        position:relative;
        border:0;
        background:transparent;
        cursor:pointer;

        /* ✅ cada item ocupa lo mismo */
        flex:1 1 0;
        display:flex;
        align-items:center;
        justify-content:center;

        padding:6px 0;
        border-radius:12px;

        /* opcional: evita que se encoja demasiado */
        min-width:52px;
    }

    .mc-icbar__img{
        width:42px;
        height:42px;
        object-fit:contain;
        display:block;
    }

    /* badge igual */
    .mc-icbar__badge{
        position:absolute;
        top:-4px;
        right:calc(50% - 26px); /* ✅ lo “ancla” al icono centrado */
        min-width:18px;
        height:18px;
        padding:0 6px;
        border-radius:999px;
        font-size:12px;
        line-height:18px;
        background:#FFCC00;
        color:#2C2C2C;
        font-weight:700;
    }

    @media (max-width: 560px) {
        .mc-icbar__img {
            width: 28px !important;
            height: 28px!important;

        }
        .mc-fixedCard {
            top: 56px !important;
        }
    }


</style>

