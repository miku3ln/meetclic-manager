<style>
    /* ===============================
       MC Conjugator (BEM)
       =============================== */
    .mc-conj {
        --mc-bg: #FFFFFF;
        --mc-border: #E6E8F2;
        --mc-muted: #6B7280;
        --mc-dark: #111827;
        --mc-black:#0F172A;   /* negro suave (tipo slate-900) */
        --mc-green:#16A34A;   /* verde */
        --mc-gray:#6B7280;    /* gris */
        --mc-head:#64748B;    /* gris para subheader */
        /* Colores por tiempo */
        --mc-present: #16A34A; /* verde */
        --mc-past: #2563EB; /* azul */
        --mc-future: #DC2626; /* rojo */
        --mc-plus: #F59E0B; /* rojo */

        --mc-radius: 16px;
        --mc-shadow: 0 10px 24px rgba(20, 22, 60, .08);

        background: var(--mc-bg);
        border: 1px solid var(--mc-border);
        border-radius: var(--mc-radius);
        box-shadow: var(--mc-shadow);
        padding: 16px;
        font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
        color: var(--mc-dark);
    }

    .mc-conj__head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
    }

    .mc-conj__title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 800;
        letter-spacing: .2px;
        font-size: 18px;
        margin: 0;
    }

    .mc-conj__dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        flex: 0 0 14px;
        background: var(--mc-muted);
    }

    .mc-conj__subtitle {
        margin: 6px 0 0 24px;
        color: var(--mc-muted);
        font-size: 13px;
        line-height: 1.35;
    }

    .mc-conj__badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        border: 1px solid var(--mc-border);
        background: #F8FAFC;
        color: var(--mc-muted);
        white-space: nowrap;
    }

    .mc-conj__grid {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border: 1px solid var(--mc-border);
        border-radius: 14px;
    }

    .mc-conj__grid thead th {
        text-align: left;
        font-size: 12px;
        color: var(--mc-muted);
        background: #F6F7FB;
        padding: 10px 12px;
        border-bottom: 1px solid var(--mc-border);
    }

    .mc-conj__grid tbody td {
        padding: 12px;
        border-bottom: 1px solid var(--mc-border);
        vertical-align: top;
        font-size: 14px;
    }

    .mc-conj__grid tbody tr:last-child td {
        border-bottom: none;
    }

    .mc-conj__pron {
        font-weight: 800;
    }

    .mc-conj__mod {
        font-weight: 800;
        color: var(--mc-muted);
    }

    .mc-conj__mod em {
        font-style: normal;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .mc-conj__verb {
        font-weight: 900;
    }

    .mc-conj__ex {
        line-height: 1.35;
    }

    .mc-conj__ex .mc-conj__ex-kw {
        font-weight: 900;
        text-decoration: underline;
        text-underline-offset: 2px;
    }

    .mc-conj__ex .mc-conj__ex-es {
        color: var(--mc-muted);
        font-weight: 700;
        margin-left: 6px;
    }

    .mc-conj__footnote {
        margin-top: 10px;
        font-size: 12px;
        color: var(--mc-muted);
        line-height: 1.4;
    }

    /* ===============================
       Modificadores por tiempo (BEM)
       =============================== */
    .mc-conj--PRESENTE .mc-conj__dot {
        background: var(--mc-present);
    }

    .mc-conj--PASADO .mc-conj__dot {
        background: var(--mc-past);
    }

    .mc-conj--FUTURO .mc-conj__dot {
        background: var(--mc-future);
    }

    .mc-conj--PRESENTE .mc-conj__verb {
        color: var(--mc-present);
    }

    .mc-conj--PASADO .mc-conj__verb {
        color: var(--mc-past);
    }

    .mc-conj--FUTURO .mc-conj__verb {
        color: var(--mc-future);
    }

    .mc-conj--PRESENTE .mc-conj__mod {
        color: var(--mc-present);
    }

    .mc-conj--PASADO .mc-conj__mod {
        color: var(--mc-past);
    }

    .mc-conj--FUTURO .mc-conj__mod {
        color: var(--mc-future);
    }

    /* Responsive */
    @media (max-width: 760px) {
        .mc-conj {
            padding: 12px;
        }

        .mc-conj__grid thead {
            display: none;
        }

        .mc-conj__grid, .mc-conj__grid tbody, .mc-conj__grid tr, .mc-conj__grid td {
            display: block;
            width: 100%;
        }

        .mc-conj__grid tbody td {
            border-bottom: none;
            padding: 10px 12px;
        }

        .mc-conj__grid tbody tr {
            border-bottom: 1px solid var(--mc-border);
            padding: 6px 0;
        }

        .mc-conj__grid tbody tr:last-child {
            border-bottom: none;
        }
    }
    /* Header */
    .mc-conj__title{ color: var(--mc-black); }
    .mc-conj__subtitle{ color: var(--mc-head); }

    /* Tabla */
    .mc-conj__grid thead th{
        color: var(--mc-head);
        font-weight:700;
    }

    /* Pronombre (columna 1) */
    .mc-conj__pron{
        color: var(--mc-black);
        font-weight:900;
    }

    /* Modificación (columna 2) */
    .mc-conj__mod{
        color: var(--mc-green) !important;
        font-weight:900;
    }

    /* Verbo modificado (columna 3) */
    .mc-conj__verb{
        color: var(--mc-green) !important;
        font-weight:900;
    }

    /* Ejemplo: Kichwa negro + subrayado */
    .mc-conj__ex-kw{
        color: var(--mc-black) !important;
        font-weight:900;
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    /* Ejemplo: Español gris */
    .mc-conj__ex-es{
        color: var(--mc-gray) !important;
        font-weight:700;
    }

    /* Regla abajo */
    .mc-conj__footnote{
        color: var(--mc-gray);
    }

    /* ✅ Subrayados exactos como tu captura */
    .mc-conj__mod{
        color: var(--mc-green);
        font-weight: 900;
        white-space: nowrap;
    }

    /* Texto verde, pero subrayados por color */
    .mc-conj__mod .mc-mod__minus{
        color: var(--mc-future);
        font-weight: 900;
        text-decoration: underline;
        text-decoration-thickness: 4px;
        text-underline-offset: 6px;
        text-decoration-color: #EF4444; /* rojo */
    }
    .mc-conj__mod .mc-mod__plus{
        color: var(--mc-plus);
        font-weight: 900;
        text-decoration: underline;
        text-decoration-thickness: 4px;
        text-underline-offset: 6px;
        text-decoration-color: #F59E0B; /* amarillo/naranja */
    }
    .mc-conj__mod .mc-mod__sign{
        color: var(--mc-green);
        font-weight: 900;
        margin: 0 2px;
    }

    /* Ejemplo Kichwa negro subrayado, Español gris */
    .mc-conj__ex-kw{
        color: var(--mc-black);
        font-weight: 900;
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .mc-conj__ex-es{
        color: var(--mc-gray);
        font-weight: 700;
    }

</style>
<style>
    /* ================================
   MorphemeGlossaryPlugin (mg)
   ================================ */

    :root{
        --mg-border:#111;
        --mg-head-bg:#f6f6f6;
        --mg-word-green:#198754; /* verde estilo ejemplo */
        --mg-font: system-ui, -apple-system, "Segoe UI", Roboto, Arial, "Noto Sans", sans-serif;
    }

    /* Wrapper */
    .mg{
        width: 100%;
        overflow-x: auto; /* por si hay pantallas pequeñas */
    }

    /* Table */
    .mg__table{
        width: 100%;
        border-collapse: collapse;
        font-family: var(--mg-font);
        background: #fff;
    }

    /* Cells */
    .mg__th,
    .mg__td,
    .mg__cell{
        border: 1.6px solid var(--mg-border);
        padding: 10px 12px;
        vertical-align: top;
        font-size: 14px;
        line-height: 1.25;
    }

    /* Headers */
    .mg__th{
        background: var(--mg-head-bg);
        font-weight: 800;
        text-align: left;
        white-space: nowrap;
    }

    /* First header row: "Palabra" */
    .mg__th--label{
        width: 160px;
    }

    /* Word cell (green + underline like word) */
    .mg__td--word{
        font-weight: 900;
        color: var(--mg-word-green);
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    /* Morpheme col */
    .mg__cell--morpheme{
        width: 140px;
        font-weight: 900;
    }

    /* Root col (green + underline like root) */
    .mg__cell--root{
        width: 160px;
        font-weight: 900;
        color: var(--mg-word-green);
        text-decoration: underline;
        text-underline-offset: 3px;
    }

    /* Row hover (suave) */
    .mg__row:hover .mg__cell{
        background: #fafafa;
    }

    /* Responsive: en móvil reduce padding */
    @media (max-width: 640px){
        .mg__th,
        .mg__td,
        .mg__cell{
            padding: 8px 10px;
            font-size: 13px;
        }
        .mg__th{ white-space: normal; }
    }
    .mg__th--section{
        text-align:center;
        font-weight:900;
    }
</style>
