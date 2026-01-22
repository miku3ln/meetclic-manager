
<style>
    /* ✅ Paleta MeetClic */
    :root{
        --mc-azulClic:#4C4CFF;
        --mc-amarilloVital:#FFCC00;
        --mc-blanco:#FFFFFF;
        --mc-grisOscuro:#2C2C2C;
        --mc-moradoSuave:#5C5CFF;

        --mc-border: rgba(76,76,255,.18);
        --mc-shadow: 0 20px 50px rgba(44,44,44,.12);
        --mc-font: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }

    /* Page background */
    .mc-page{
        min-height: 100vh;
        font-family: var(--mc-font);
        background: radial-gradient(circle at 20% 10%,
        rgba(92,92,255,.25) 0%,
        rgba(76,76,255,.12) 35%,
        rgba(255,255,255,1) 75%
        );
    }

    .mc-401__wrap{
        min-height: 100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:24px;
    }

    /* Card */
    .mc-card{
        width:100%;
        max-width:820px;
        background:var(--mc-blanco);
        border-radius:18px;
        border:1px solid var(--mc-border);
        box-shadow: var(--mc-shadow);
        overflow:hidden;
    }

    .mc-card__header{
        padding:18px 22px;
        background: linear-gradient(90deg, var(--mc-azulClic) 0%, var(--mc-moradoSuave) 100%);
        color:var(--mc-blanco);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
    }

    .mc-card__content{
        padding:26px 24px 22px 24px;
        text-align:center;
    }

    .mc-card__footer{
        padding:14px 18px;
        background: rgba(76,76,255,.05);
        border-top:1px solid rgba(76,76,255,.12);
        text-align:center;
        color: rgba(44,44,44,.65);
        font-size:12px;
    }

    /* Brand */
    .mc-brand{
        display:flex;
        align-items:center;
        gap:10px;
    }

    .mc-brand__logo{
        width:38px;
        height:38px;
        border-radius:12px;
        background: var(--mc-amarilloVital);
        display:flex;
        align-items:center;
        justify-content:center;
        color: var(--mc-grisOscuro);
        font-weight: 900;
    }

    .mc-brand__text{
        line-height: 1;
    }

    .mc-brand__name{
        font-weight: 900;
        letter-spacing: .3px;
        font-size: 16px;
    }

    .mc-brand__tag{
        font-size: 12px;
        opacity: .9;
    }

    /* Badge */
    .mc-badge{
        padding:6px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,.18);
        border:1px solid rgba(255,255,255,.22);
        font-size:12px;
    }

    /* 401 content */
    .mc-401__code{
        font-size:86px;
        font-weight:900;
        line-height:1;
        letter-spacing:-2px;
        color: var(--mc-azulClic);
        margin-top:4px;
    }

    .mc-401__title{
        margin:10px 0 6px 0;
        color: var(--mc-grisOscuro);
        font-weight:900;
        font-size:22px;
    }

    .mc-401__message{
        margin:0 auto 16px auto;
        max-width:520px;
        color: rgba(44,44,44,.75);
        font-size:14px;
        line-height:1.55;
    }

    /* Actions */
    .mc-actions{
        display:flex;
        flex-wrap:wrap;
        gap:12px;
        justify-content:center;
        margin-top:14px;
    }

    .mc-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:8px;
        padding:11px 16px;
        border-radius:12px;
        font-weight:900;
        text-decoration:none;
        border:1px solid transparent;
        user-select:none;
    }

    .mc-btn__icon{
        display:inline-flex;
        width:18px;
        height:18px;
        border-radius:6px;
        align-items:center;
        justify-content:center;
        font-weight:900;
    }

    .mc-btn--outline{
        background: var(--mc-blanco);
        border-color: rgba(76,76,255,.28);
        color: var(--mc-azulClic);
    }

    .mc-btn--outline .mc-btn__icon{
        background: rgba(76,76,255,.12);
    }

    .mc-btn--primary{
        background: var(--mc-amarilloVital);
        border-color: rgba(255,204,0,.65);
        color: var(--mc-grisOscuro);
    }

    .mc-btn--primary .mc-btn__icon{
        background: rgba(44,44,44,.12);
    }

    /* Tech box */
    .mc-tech{
        margin:18px auto 0 auto;
        max-width:560px;
        background: rgba(92,92,255,.08);
        border:1px dashed rgba(92,92,255,.35);
        border-radius:14px;
        padding:12px 14px;
        text-align:left;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        font-size:12px;
        color: var(--mc-grisOscuro);
    }

    .mc-tech__title{
        font-weight:900;
        margin-bottom:6px;
        color: var(--mc-moradoSuave);
    }

</style>
