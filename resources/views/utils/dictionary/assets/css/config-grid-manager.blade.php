<style>

    .section--full-img {
        padding: 0 0;
    }

    h1.title {
        float: left;
        width: 100%;
        text-align: center;
        color: #4db7fe;
        font-size: 34px;
        font-weight: 700;
    }

    img.img-svg-full {
        width: 88%;
    }


    .btn-sm {
        padding: 5px 10px !important;
        font-size: 12px !important;;
        line-height: 1.5 !important;;
        border-radius: 3px !important;;
    }

    img.content-description__photos--img {
        height: 140px;
        width: 140px;
    }

    .content-description {
        padding-top: 9px;
        padding-bottom: 9px;
    }

    .btn {
        color: #f08124 ;
    }

    .text-left {

        font-size: 26px;
        text-align: left;
    }

    .text-left a {
        color: #4d4c4c !important;
    }

    .form-group {
        text-align: left;

    }

    select#typeDictionary {
        font-size: 21px;
    }

    label.form__label {
        color: #225278;
        font-size: 24px;
    }

    .bootgrid-footer--fixed {
        padding-right: 7% !important;
        padding-left: 6% !important;
        width: 80%;
        position: fixed;
        top: 77%;
    }

    ul.pagination li {
        cursor: pointer;
    }

    a {

        text-decoration: none !important;
    }

    .content-description__information {
        /* display: flex; /* Hace que los elementos hijos se muestren en línea horizontalmente */
        align-items: center; /* Alinea los elementos verticalmente */
    }

    .content-description__title {
        margin-right: 10px; /* Espacio entre el título y el contenido */
    }

    .word--description {
        /*  display: flex; /* Para que el contenido dentro también se muestre en línea horizontal */
        align-items: center; /* Alinea el contenido verticalmente */
    }

    .word--fonetic {
        margin-right: 5px; /* Espacio entre el fonético y el texto */
    }

    .word--description p {
        margin: 0; /* Elimina el margen predeterminado del párrafo */
    }

    span.content-description__title {
        color: #4d4c4c;
        font-size: 22px;
        font-weight: bold;
    }

    span.word--fonetic {
        color: #f08124;
    }


    .search {
        width: 45% !important;;
    }

    .container--manager-dictionary {

        width: 100%;
        padding: 0 10% 0 10%;
        position: relative;
        z-index: 5;
    }

    .custom-scroll-admin-grid {
        height: 450px;
        overflow-y: scroll;
        overflow-x: hidden;
    }

    .input-group-addon {
        font-size: 26px !important;
        color: #fff !important;;
        background-color: #f08124 !important;
        border: 0 solid #f08124 !important;;
        border-radius: 0 !important;;
    }


    .word-card:hover {
        box-shadow: 0 -5px 2px rgb(240 129 36);
        transform: translateY(-4px);
    }

    /* Identificador visual */
    .word-card__translation::before {
        content: "📘 ";
    }

    .word-card {
        background: #fff;
        border: 2px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        max-width: 100%;
        font-family: 'Segoe UI', sans-serif;
        margin: 20px auto;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .word-card__header {

        justify-content: space-between;
        align-items: baseline;
        border-bottom: 1px solid #e2e2e2;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .word-card__base {
        font-size: 32px;
        font-weight: bold;
        color: #2c3e50;
    }

    .word-card__translation {
        display: inline-block;
        margin-left: 12px;
        padding: 2px 8px;
        font-size: 23px;
        font-weight: 600;
        color: #2a2a2a;
        background-color: #f0f8ff; /* color suave */
        border-left: 4px solid #3b82f6; /* azul destacado */
        border-radius: 4px;
        transition: background-color 0.3s;

    }

    .word-card:hover .word-card__translation {
        background-color: #e0f2ff;
    }

    .word-card__section {
        margin-bottom: 18px;
    }

    .word-card__subtitle {
        font-size: 18px;
        font-weight: 600;
        color: #34495e;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .word-card__list {
        list-style: none;
        padding-left: 0;
    }

    i.word-card__expand-ico {
        text-align: right;
        left: 25%;

    }

    .word-card__item {
        padding: 6px 0;
        font-size: 15px;
        color: #2c3e50;
    }

    .word-card__phonetic {
        font-weight: 500;
        margin-right: 6px;
        color: #2980b9;
    }

    span.word-card__phonetic.word-card__phonetic--main {
        color: #f08124;
        font-size: 19px;
    }

    .word-card__notation {
        font-style: italic;
        color: #7f8c8d;
    }

    .word-card__text {
        color: #444;
        font-size: 15px;
        line-height: 1.6;
    }

    table.dictionary-data {
        width: 100%;
    }

    /* Aplica SOLO al tbody */
    .dictionary-data > tbody {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); /* 3 columnas en PC, 1 columna móvil */
        gap: 20px;
        padding: 20px;
    }

    /* Los tr deben "desaparecer" como filas */
    .dictionary-data > tbody > tr {
        display: contents; /* Para que los <td> (las word-card) floten directamente como ítems del grid */
    }

    /* Aseguramos que el td se comporte como bloque libre */
   .dictionary-data > tbody > tr > td {
        margin: 0;
        padding: 0;
    }
</style>
