<style>
    #wrapper{
        padding-top: 57px !important;
    }
        /* ====== BEM: mc-fixedCard ====== */
    .mc-fixedCard{
        position: fixed;
        top: 10px;
        left: 0;
        right: 0;
        z-index: 9999;
        pointer-events: none; /* importante: solo los botones reciben click */
        padding: 0 0px;
    }

    .mc-fixedCard__inner{
        pointer-events: auto;
        margin: 0 auto;
        max-width: 980px;

        display: grid;
        grid-template-columns: 1fr 58px;
        min-height: 64px;

        border-radius: 14px;
        overflow: hidden;

        background: var(--mc-fixedCard-bg, #33b300);
        color: var(--mc-fixedCard-text, #ffffff);

        box-shadow: 0 12px 30px rgba(0,0,0,.22);
    }

    .mc-fixedCard__col{
        border: 0;
        background: transparent;
        color: inherit;
        cursor: pointer;
        padding: 0;
    }

    .mc-fixedCard__col--left{
        text-align: left;
        padding: 10px 14px;
        min-width: 0;
    }

    .mc-fixedCard__meta{
        font-weight: 900;
        font-size: 12px;
        letter-spacing: .6px;
        text-transform: uppercase;
        opacity: .95;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mc-fixedCard__title{
        margin-top: 3px;
        font-weight: 800;
        font-size: 16px;
        line-height: 1.1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mc-fixedCard__col--right{
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--mc-fixedCard-rightBg, rgba(255,255,255,.18));
    }

    .mc-fixedCard__iconBox{
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,.08);
    }

    .mc-fixedCard__icon{
        width: 24px;
        height: 24px;
        display: block;
        filter: var(--mc-fixedCard-iconFilter, none);
    }

    .mc-fixedCard__col:active{
        transform: scale(.99);
    }

    /* ✅ Para que tu contenido no quede tapado por el fixed card */
    .content{
        padding-top: 92px; /* ajusta si cambias el top */
    }


        header.main-header {
            display: none !important;

        }

</style>
