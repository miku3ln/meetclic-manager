<style>

    /*
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    */
    /*
        Created on : 20/09/2016, 13:12:04
        Author     : LMigu3ln
    */

    #main {
        /*margin-top: -17px !important;*/
    }

    body.menu-on-top.fixed-header {
        /*padding-top: -21px !important;*/
    }

    #content-render {
        /*margin-top: 13px;*/

    }

    #content-data-menu {
        display: none;
    }

    #content {
        /*margin-top: -84px;*/
    }

    /*-----------INFORMACION---*/
    .profile-pic > img {
        border-radius: 0;
        position: relative;
        border: 0px solid #fff !important;
        top: -67px !important;
        left: 10px;
        display: inline-block;
        text-align: right;
        z-index: 4;
        max-width: 100px;
        margin-bottom: -30px;
    }

    /*
    ----------MANAGER INVOICE--------------------*/
    /*
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    */
    /*
        Created on : 01/09/2016, 9:22:13
        Author     : Migu3ln Alba
    */

    .grid {
        width: 100%;
        height: 350px;
    }

    #d_total {
        text-align: center;
        height: 109px;
        background: #CCCCCC;

    }

    div#content-s_value_total {
        padding-bottom: 30px;
        /* margin-bottom: 12px; */
    }

    .data-sub {
        /*margin-bottom: 16%;*/
    }

    div#s_total {
        padding-top: 5%;
        text-align: center;
    }

    span#s_total {
        font-size: 30px;
    }

    span#s_value_total {
        font-size: 30px;
        color: #b7302c;
    }

    div#content-gestion {
        height: 162px;
        color: #f7f6f4;
        background: #354a5f !important;
    }

    /*CONTENEDOR TOTAL S2*/
    .select2-container .select2-choice {
        height: 25px !important;
    }

    .select2-chosen {
        margin-top: -4px;
    }

    .select2-container .select2-choice abbr {
        font-size: 14px !important;
        right: 25px !important;
        margin-top: -3px !important;
    }

    span.select2-chosen {
        color: #cccccc !important;
    }

    .select2-container.select2-allowclear .select2-choice .select2-chosen {
        color: #666666 !important;
    }

    /*--------labels*--*/

    #lbl-iva, #lbl-descuento, #lbl-subtotal {
        text-align: left;
    }

    div#content-gestion {
        padding-top: 7px;
    }

    #productos-data {
        width: 250px;
    }

    .select-style--invoice {
        width: 89% !important;
    }

    /*----------END GESTION DATA--*/
    .ui-grid-cell {
        font-size: 8pt;
    }

    .ui-grid-cell--invoice .ui-grid-cell {
        height: 33px !important;

    }

    .ui-grid-row--tax-retention .ui-grid-cell {
        height: 66px !important;

    }

    /*retentions*/
    span.details-retention-title {
        font-size: 12px;
        color: #0e0d0d;
        font-weight: 600;
    }

    span.details-retention-value {
        font-size: 12px;
        color: #0e0d0d;
        font-weight: 400;
    }

    .content-value.ng-binding {
        font-size: 12px;
        color: #0e0d0d;
        font-weight: 400;
        text-align: center;
    }

    /*---SELECCIONAR LOS LBLS DEL GRID*/
    .ui-grid-canvas .ui-grid-cell-contents {
        padding: 10px;
        color: #000000;
        text-align: center;
    }

    /*----TABLE VENTAS---*/

    /*.xywer-tbl-angular{
           width: 500px;
        height: 150px;
    }*/
    .form-actions {
        background: #fff !important;
    }

    .form-control {
        background-color: #fff !important;
    }

    /*---------------ENCABEZADO--------*/

    #content-cliente, #content-producto {
        color: #fff;
        margin-top: 1.2%;
    }

    .gestion-productos-servicios {
        margin-top: 1.2%;
    }

    div#table-productos {
        margin-bottom: 0.45%;
    }

    @media only screen and (max-width: 800px) and (min-width: 0) {
        div#content-row-filtro {
            background: #96a4a5;
            height: 100%;

        }

        div#content-gestion {
            height: 270px;
        }

        .gestion-data {
            width: 100%;
        }
    }

    div#content-gestion-btns {
        text-align: right;
    }

    .gestion-data {
        width: 54%;
    }

    .row-gestion {
        margin-bottom: 1%;
    }

    div#content-gestion-factura {
        margin-bottom: 1.1%;
    }

    .meet-factura {
        background-color: #E86962;
        border-color: #fff !important;
        color: #fff;
        width: 92px;
        height: 29px;
        border-radius: 5px !important;
    }

    /*----------MODIFICACIONES---*/

    /*------add producto selected row---*/
    .add-data-element {
        /*color: #fff !important;*/
    }

    /*------add producto selected row---*/

    .add-data-element div.ui-grid-cell {
        background-color: #cccccc !important;
        color: #999999;
    }

    .input-data-cantidad {
        height: 50px;
    }

    /*---color del div contenedor al editar---*/
    .div-input-data-cantidad {
        color: #cccccc;
    }

    /*---expand --*/

    .expandableRow.ng-scope {
        background: #9AE5E3;
    }

    .frm-expandableRow label {
        color: #fff;
    }

    .delete-data {
        background: none;
        font-size: 16px !important;
        color: #7E8C8D;
        margin-top: 11%;
        border: none;
    }

    .scrollFiller {
        background: #9AE5E3;
    }

    /**-----detalle-- ne*/
    .content-data-frm-gestion.input-data {
        height: 24px !important;
        width: 68% !important;
        margin-top: 6px;
    }

    .text-line-subrayado {
        color: #d07131;
        /*text-decoration: line-through;*/
        font-size: 12px;
        line-height: 1.2;
    }

    .precio-venta {
        width: 50px;
        font-size: 12px;
        color: #838383;
        font-weight: bold;
        margin: 16%;
    }

    .strike {
        position: relative;
    }

    .precio-venta.strike {
        color: #d07131;
        margin-left: 0px;
    }

    .strike::after {
        margin-left: -94%;
        content: '';
        border-bottom: 1px solid #d07131;
        position: absolute;
        top: 46%;
        width: 100%;
    }

    .data-span {
        /*margin: 16%;*/
    }

    .descuento-data {
        /*margin: 15%;*/
    }

    .lbl-data {
        color: #000000 !important;
        margin-top: 0px;
        text-align: left;
        width: 125px;
    }

    label.lbl-data.lbl-descuento {
        margin-top: 0px;
    }

    /*.btn-link{
        color: #f9fafb !important;
    }*/

    /*------SELECT2---*/
    /*CUANDO SELECCIONA*/
    .select2-allowclear.select2-container .select2-choice {
        background: #CCCCCC;
    }

    /*color de la letra*/
    .select2-allowclear.select2-container a.select2-choice span.select2-chosen {
        color: #919191;
    }

    /*agregar un proveedro--*/
    a#add-proveedor-btn {
        z-index: 1;
        position: absolute;
        left: 98.9%;
        top: 17%;
    }

    .add-data-row {
        color: #fff !important;
        width: 22px;
        background-color: #00AFF1 !important;
        border-color: #00AFF1 !important;
    }

    .add-data-row:hover {
        background-color: #7E8B8C !important;
        border-color: #7E8B8C !important;
    }

    /*---items modificar en responsive---*/
    .content-margin-left {
        margin-left: 0px !important;
    }

    /*---FORMS--*/
    /*--INPUTS CALENDARIO--*/
    .meet-form span.input-group-btn {
        background: #00AFF1;
    }

    .meet-form span.input-group-btn button.btn {
        height: 25px;
        border-left: 0px solid #00AFF1 !important;
        border-right: 1px solid #00AFF1 !important;
        background: #00AFF1;
        color: #fff;
        width: 25px;
    }

    i.glyphicon.glyphicon-calendar {
        margin-left: -5px;
    }

    /*BOTON GESTIONAR*/
    .btn-gestionar-factura {
        font-size: 18px !important;
    }

    div#content-filtres-data {
        background: #CCCCCC !important;
    }

    /*filtros izquierda*/

    .content-return {
        margin-top: -6px !important;
        font-size: 26px !important;
    }

    /*change*/
    /*---contenido de total--*/
    .content-gestion-body {
        color: #ccc !important;

    }

    .content-button-add-transaction {
        right: 0%;
        position: absolute;
    }

    .tbl-details-payments__title {
        font-weight: 600;
    }

    .cell-bank {
        height: 88px !important;
        color: black;
    }

    .cell-credit-card {
        height: 88px !important;
        color: black;
    }

    .cell-cash {
        color: black;
    }

    .btn--manager-transaction {
        background-color: #00AFF1 !important;
        border-color: #00AFF1 !important;
    }

    .content-gestion-body label {
        font-size: 23px;
    }

    .content-gestion-body input {
        font-size: 23px;
        color: #BC3F3B;
    }

    #btn-factura-gestion {
        /*margin-left: 44% !important;*/
    }

    .btn-factura-gestion-normal {

    }

    /*-------MIXTO SIN RETENCIONES---*/
    div#content-total-informacion {
        color: #fff;
        background-color: #34495E;
    }

    .row.form-group.firs-data {
        margin-top: 12px;
    }

    #content-total-informacion .form-control {
        height: 19px !important;
    }

    /*----NORMAL RETENCIONES--*/
    div#retenciones {
        margin-top: 31px;
    }

    /*--total rtenciones resultados*/
    table.tbl-data-retenciones {
        margin-left: 15px;
    }

    th.left-data {
        text-align: center;

    }

    label.lbl-total-retenciones-info {
        font-weight: 500;
        font-size: 25px;
        color: #34495e;
    }

    th.left-data {
        width: 175px;
    }

    .data-info {
        text-align: center;
        font-weight: 500;
        font-size: 18px;
        color: #34495E;
        width: 85px;
        height: 21px;
    }

    label.lbl-total-retenciones-data {
        font-weight: 500;
        font-size: 25px;
        color: #B83E3B;
    }

    th.right-data {
        border-left: 8px solid #fff;
        background: #34495e;
    }

    th.right-data-alter {
        border-right: 17px solid #fff;
        background: #34495e;
        /* background: azure; */
    }

    th.left-data.left-data-info {
        background: #CCCCCC;
        padding-left: 10px;
    }

    label.lbl-data-info-retenciones {
        color: #fff;
        font-size: 13px;
    }

    /*---diseÃ±o de elemntos de filtros superiores--*/
    /*change*/
    a#add-cliente-btn {
        height: 25px;
        z-index: 1;
        position: absolute;
        left: 98.9%;
        top: 0px;
        width: 25px;
    }

    a#add-cliente-btn span {
        margin-left: -1px;
        margin-top: 5px;
    }

    /*----FACTURA---*/
    .lbl-detalle {
        margin-top: 7px;
        margin-left: 0% !important;
        font-size: 14px !important;
    }

    /*---PRINT FACTURA---*/
    .lbl-title {
        font-weight: bold;
    }

    /*---FORMULARIOS FACTURA*/
    #gestion_data_frm input {
        height: 25px;
    }

    /*GESTION DE FACTURA DETALLE*/
    div#content-row-filtro {
        padding-top: 1px;
        background: #CCCCCC;
        padding-bottom: 6px;
        margin-top: 1.50%;
        margin-bottom: 1.8%;
    }

    #lbl-descuento {
        padding-left: 7% !important;
        margin-top: 1px;
    }

    label#lbl-retencion {
        margin-top: 1px;
    }

    div#toogle-type-descuento {
        padding-left: 0px;
        padding-right: 0px;
    }

    div#type-descuento-gestion {
        padding-right: 0px;
        padding-left: 0px;
    }

    div#input-value-descuento {
        padding-right: 0px;
        padding-left: 0px;
    }

    input#value-descuento-gestion {
        margin-left: 33px;
        width:100%;
    }

    /*RETENCIONES*/
    .ats-switch span {
        margin-top: -2%;
    }

    .ats-switch {
        height: 24px;
    }

    div#content-retencion-row {
        padding-left: 0px;
        padding-right: 0px;
    }

    input#has-retencion {
        margin-left: 21%;
        height: 13px;
        margin-top: 4px;
        background-color: #fff;
    }

    /*PRODUCTOS GSTION*/
    div#content-all-productos {
        padding-left: 0px;
        padding-right: 0px;
    }

    div#content-producto-gestion {
        padding-left: 0px;
        padding-right: 0px;
    }

    /*---btns de gestions--*/
    /*-----CHANGE--*/
    div#content-data-productos-gestion {
        padding-left: 0px;
        padding-right: 0px;
    }

    a#add-search-producto-btn {
        margin-top: -1%;
        position: relative;
        margin-left: -45%;
    }

    a#add-producto-servicio-btn {
        margin-top: -1%;
        position: relative;
        margin-left: 4%;
    }

    /*---lupitas*/
    a#add-search-producto-btn span::before {
        margin-left: -1px;
        margin-top: 14px !important;
        padding-top: 16px;
    }

    a#add-producto-servicio-btn span {
        margin-left: 0px;
    }

    /*----ENCABEZADO FACTURA--*/
    /*EMPRESA INFORMACION*/
    .establecimiento-col1 {
        padding-left: 0px !important;
        padding-right: 2% !important;
    }

    .establecimiento-col2 {
        padding-left: 0px !important;
        padding-right: 2% !important;
    }

    .establecimiento-col3 {
        padding-left: 0px !important;
        /*padding-right: 2% !important;*/
    }

    /*---FORMULARIO STYLE SHEET*/
    .lbl-frm-factura {
        font-size: 10pt !important;
    }

    .lbl-gestion-info {
        color: #666666;
    }

    /*---TOTAL GESTION FACTURA--*/
    div#row-gestion-factura {
        padding-right: 15px;
        padding-left: 15px;
        background: #065C77;
        padding-top: 7%;
        padding-bottom: 11%;
    }

    .lbl-gestion-result {
        padding-left: 3px !important;
        color: #fff;
        padding-top: 7px !important;
    }

    div#col-factura-total {
        margin-top: 15px;
    }

    input#input-factura-total {
        font-size: 12pt;
        height: 45px;
        color: #E86962;
    }

    /*---GRID--*/
    /*.ui-grid-row-header-cell.ui-grid-expandable-buttons-cell {
        background: none;
    }*/
    .ui-grid-pinned-container.ui-grid-pinned-container-left .ui-grid-header-cell:last-child .ui-grid-row-header-cell.ui-grid-expandable-buttons-cell {
        background: none !important;
        margin-top: 12px;
    }

    .ui-grid-row-header-cell {
        background: #00AFF1 !important;
        height: 33px !important;
    }

    .ui-grid-expandable-buttons-cell i {
        color: #fff;
    }

    /*----NO DADO CLICK*/
    .ui-grid-row:nth-child(odd) .ui-grid-cell {
        background: #cccccc !important;
    }

    .ui-grid-row.ng-scope {
        margin-bottom: 8px;
    }

    /*-*---GESTION DE PROCESOS FACTURAS*/
    /*CONTENEDOR TOTAL DE LOS PROCESOS*/
    div#content-tipo-pago {
        margin-top: 1.1%;
    }

    /*---titulos*/
    .title-gestion {
        margin-top: 0px;
        margin-bottom: 0px;
    }

    /*--------CONTENDEDORES GESTION DE FACTURA*/
    /*---------contenedor principal---*/
    .content-return {
        color: #00AFF1 !important;
    }

    #content-render {
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
        padding-left: 2%;
        padding-right: 3%;
        margin-top: 7px;
    }

    div#row-btn-gestion-factura {
        margin-top: 6px !important;
    }

    .ats-switch.switch-danger span.switch-left {
        background: #e84c3d;
    }

    /*---switc---*/
    .ats-switch.switch-danger span.switch-left {
        background: #00AFF1 !important;
    }

    .ats-switch {
        border-radius: 0px;
    }

    /*------GESTION RETENCIONES FORMULARIO*/
    div#row-gestion-pay {
        /*margin-top: 15%;*/
    }

    /*---LEFT RETENCIONES*/
    div#row-gestion-pay h2 {
        /*margin-left: 15.4%;*/
    }

    div#row-gestion-pay h2 strong.title_left {
        color: #065c77;
    }

    .ui-grid-viewport {
        margin-top: 5px;
    }

    .ui-grid-canvas {
        margin-top: 1px !important;
    }

    /*---SELECT2 LISTO*/
    div#s2id_productos-data-info {
        width: 82% !important;
    }

    div#col-factura-total-btn {
        padding-left: 0px;
    }

    div#row-factura-total {
        margin-top: 13px;
    }

    /*----GESTION PROCESOS---*/
    /*TITULO*/
    label#lbl-pago-factura {
        color: #065c77;
        font-weight: 800;
        font-size: 16px;
    }

    div#informativo_gestion {
        margin-bottom: 1.5%;
    }

    input#span-data {
        padding: 0px 17px;
        font-size: 16px;
        border: 1px solid #ccc;
        background: #cccccc;
        width: 100%;
        height: 28px;
        color: #ba5d5e;
        font-weight: 600;
    }

    /*PROCESOS*/
    /*RESULTADO PROCESOS*/
    div#content-gestion-procesos-facturas {
        margin-top: 1.4%;
    }

    div#content-gestion-factura-result {
        margin-bottom: 1.1%;
    }

    div#row-gestion-factura-result {
        padding-right: 15px;
        padding-left: 15px;
        background: #065C77;
        padding-top: 7%;
        padding-bottom: 11%;
    }

    /*---botones gestion*/
    div#row-factura-total-result {
        text-align: right;
        margin-top: 13px;
    }

    #btn-factura-gestion-save {
        margin-left: 0%;
    }

    #frm-retenciones span.input-group-btn button.btn {
        height: 25px;
        width: 25px;
        border-left: 0px solid #00AFF1 !important;
        border-right: 1px solid #00AFF1 !important;
        background: #00AFF1;
        color: #fff;
    }

    #frm-retenciones input {
        height: 25px;
    }

    div#row-first {
        margin-bottom: 1.3%;
    }

    input#codigo-factura-gestion {
        width: 93.9%;
    }

    div#content-row-grid-retenciones {
        margin-top: 2%;
    }

    table.tbl-detaller-procesos {
        width: 100%;
    }

    td.td-values {
        color: #fff;
        background: #2bb1ef;
        width: 50%;
    }

    /*
    -------UIGRID CSS------*/
    .input-data-valor {
        color: #000000 !important;
    }

    /*
    ---GRID-----*/
    .delete-data--pagos {
        margin-top: 4% !important;
    }

    .select-style--invoice {
        width: 89% !important;
    }

    /*
    --------MANAGER FIXED *---------*/
    .manager-invoice-fixed {
        z-index: 15000;
        position: fixed;
        width: 80%;
        background: #b5afaf;
        height: 79px;
    }

    .invoice-total-fixed {
        position: fixed;
        width: 100%;
        background: #b5afaf;
        height: 34px;
        top: 10%;

    }

    th.billing-details-th.description {
        text-align: left;
    }

    /*
    ---DETAILS CUSTOMER-----*/
    .content-details__title {
        font-weight: 600;
    }

    .form-control--checkbox {
        border: 1px solid #b6b3b3 !important;
    }

    .form-group--padding {
        padding-left: 2% !important;
        padding-right: 2% !important;
    }

    /*
    ---BUTTONS GRID----*/
    .content-manager-buttons-grid {
        margin-top: 2%;

    }

    .content-manager-buttons-grid__a {
        margin-left: 0.5%;
    }

    /*
    ---MOVEMENT CASH---*/
    .table-data-details {
        width: 100%;
    }

    tr.table-data-details__tr {
        height: 20px !important;
    }

    .span-details {
        color: #065C77;
        font-weight: 800;
    }

    .span-size-middle {
        font-size: 10px;

    }

    .span-size-small {
        font-size: 14px;

    }

    th.table-data-details__th.col-th-1 {
        width: 60%;
    }

    /*
    ---DATE CURRENT---*/
    .full button span {
        background-color: limegreen;
        border-radius: 32px;
        color: black;
    }

    .partially button span {
        background-color: orange;
        border-radius: 32px;
        color: black;
    }

    /*
    ----ERRORS WAYPAYMENTS---*/
    .ui-grid-cell.ui-grid-cell--error-value-payment {

        border: 1px solid red !important;
    }

    .ui-grid-cell.ui-grid-cell--warning-value-payment {

        border: 1px solid #ff5e18 !important;
    }

    /*
    DETAILS HORIZONTAL*/
    .data-details {
        padding-top: 1%;
        padding-bottom: 1%;
    }

    .span-title {
        font-size: 15px;
        font-weight: 800;
    }

    .span-size-middle.title {
        font-size: 14px;
    }

    /*
    ----------GRID DETAILS COLUMN ADD----*/
    .fa-check--add {
        font-size: 25px !important;
        cursor: pointer;
    }

    .fa-check--active-add {
        color: rgb(22, 193, 121);
    }

    .fa-check--inactive-add {
        color: rgb(193, 17, 17);
    }

    /*
    ---GRID MANAGER STUDENTS ---*/
    .row-current-not-manager {
        border-bottom: 2px solid #ff5e18;
    }

    .row-current-students {
        cursor: pointer;
    }

    /*----ASKWER---*/
    label.error {
        color: #c1272d !important;
    }

    span.validationMessage {
        color: #c1272d !important;
    }

    /*TYPES ACTIVITIES*/
    .manager-types-activities {
        border-bottom: 2px solid #cccccc;
        border-top: 2px solid #cccccc;
        border-right: 2px solid #cccccc;
        border-left: 2px solid #cccccc;
        margin-top: 8px;
        margin-bottom: 8px;
        margin-left: 0px;
        margin-right: 8px;

        padding-left: 3%;
        padding-right: 3%;
        padding-bottom: 3%;
        padding-top: 3%;

    }

    .manager-types-activities--test {
        padding-left: 3%;
        padding-right: 3%;
    }

    /*
    UPLOAD*/
    div#content-img-view {
        width: 120px !important;
        height: 118px !important;
    }

    .img-view-data {
        width: 120px !important;
        height: 118px !important;
    }

    div#content-img-view {
        border-radius: 0px;
        margin-bottom: 0px;
        padding: 0px;
        width: 120px !important;
        height: 118px !important;
        border: 0px solid #ddd;
    }

    .btn-upload-recursos {
        border-width: 2px;
        border-style: solid;
        border-color: rgb(221, 221, 221);
        width: 24px;
        background: #00AFF1;
        border-radius: 13px;
        height: 24px;
    }

    .btn-upload-recursos:hover {
        background: #4a5350;
    }

    .btn-upload-recursos i {
        color: #b6b6b6;
        font-size: 14px;
        margin-left: -1px;
    }

    div#select_row_img {
        position: absolute;
        top: 65%;
        left: 31%;
    }

    /*
    ---RESULTS ASKWER*--*/
    .form-horizonta--view {
        /* width: 99%; */
        padding-left: 4%;
        padding-right: 4%;
    }

    .span-title-select-label {
        font-size: 14px;
        font-weight: 800;
        color: blue;
    }

    .span-title-comment-label {
        font-size: 12px;
        font-weight: 800;
        color: #a90329;
    }

    .gridStyle {
        border: 1px solid rgb(212, 212, 212);
        width: 400px;
        height: 300px;
    }

    .tbl-result th {
        border: 3px solid grey;
        border-collapse: collapse;
        padding: 5px;
    }

    .tbl-result td {
        border: 3px solid grey;
        border-collapse: collapse;
        padding: 5px;
    }

    .tbl-result th {
        border: 3px solid grey;
        border-collapse: collapse;
        padding: 5px;
        white-space: pre-line !important;
        background-color: #f1f1f1;
    }

    .tbl-result tr:nth-child(odd) {
        background-color: #f1f1f1;
    }

    .tbl-result tr:nth-child(even) {
        background-color: #ffffff;
    }

    .askwer-section-result {
        margin-top: 17px !important;
        margin-bottom: 17px !important;
    }

    h3.info-result {
        margin-top: -2px;
        margin-bottom: 11px;
    }

    .askwer-row {
        margin-bottom: 4%;
    }


    .md-dialog-container--finish-course {
        z-index: 500000000 !important;
    }

    .manager-finish-course {
        text-align: center;
        padding-left: 2%;
        width: 449px;
        padding-bottom: 2%;
        padding-right: 2%;
        padding-top: 2%;
    }

    .btn--approve {
        background: #00AFF1 !important;
        color: #ffffff !important;
    }

    .btn--not-approve {

        background-color: #E86962 !important;
        border-color: #fff !important;
    }

    .btn--finish-course {
        width: 118px !important;
    }

    .row.manager-description {
        width: 800px;
        overflow-x: scroll;
    }
    span.select2-hidden-accessible {
        display: none;
    }
    /*
    BADGES CONFIG*/
    .badge--active {
        background: #39B54A !important ;
    }

    .badge--informative {
        background: #57889c !important ;
    }

    .badge--danger {
        background: #c11111 !important ;
    }

    .badge--warning {
        background: #ff8f1a !important ;
    }
    .content-description__value {

    }

    /*
    ----NOTES ERRORS--------*/
    .note-warning {
        padding: 3px;
        color: black;
        background-color: rgb(255,255,100);
        text-align: center;
        border-radius: 5px;
        position: fixed;
        left: 14%;
        top: 9%;
        box-shadow: 3px 3px 5px #eee;
    }
    .note-warning h1 {
        font-size: 10px !important;
    }
    /*OTHER*/
    .textarea--manager {
        width: 91% !important;
    }

    .ui-grid-cell-focus--warning {
        border: 2px solid #f4ca0d;
        border-radius: 0px;
        /* background: red; */
    }

    /*meet-btn.css*/
    /*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
    /*
        Created on : 18/11/2016, 8:53:34
        Author     : Migu3ln Alba
    */
    .meet-btn-warning {
        width: 87px;
        border-radius: 5px;
        background-color: #f8ae44;
        border-color: #f8ae44;
        color: #fff;
    }
    .meet-btn-warning:hover {
        background-color: #e67f22;
        border-color: #e67f22;
        color:#fff;

    }
    .meet-btn-error{
        width: 87px;
        border-radius: 5px;
        background-color: #c86663;
        border-color: #c86663;
        color:#fff;
    }
    .meet-btn-error:hover{
        background-color: #e24340;
        border-color: #e24340;
        color:#fff;

    }
    .meet-btn-success:hover{
        background-color: #bf7925;
        border-color: #bf7925;
        color:#fff;

    }
    .meet-btn-success{
        width: 87px;
        border-radius: 5px;
        color:#fff;
        background-color: #e4ab4d;
        border-color: #e4ab4d;
    }
    .btn-success.active, .btn-success.focus, .btn-success:active, .btn-success:focus, .btn-success:hover, .open>.dropdown-toggle.btn-success {
        color: #fff;
        background-color: #2a838e;
        border-color: #2a838e;
    }

    /*---botones gestion--*/
    .a-meet-error{

    }
    .a-meet-success{

    }
    .a-meet-warning{

    }
    .a-meet-default{

    }
    .a-meet-info{

    }
    /*----------GESTION CRUD---*/

    .a-meet-update {
        background-color: transparent !important;
        border-color: transparent !important;
        color: #bf7925 !important;
        border-radius: 0px !important;
        -webkit-border-radius: 0px !important;
        -moz-border-radius: 0px !important;
        box-shadow: inset 0 -2px 0 rgba(0,0,0,0) !important;
        -moz-box-shadow: inset 0 -2px 0 rgba(0,0,0,0) !important;
        -webkit-box-shadow: inset 0 -2px 0 rgba(0,0,0,0)!important;
    }
    .a-meet-update:hover {
        color:#cccccc;
    }
    .a-meet-create{
        /*a5db84*/
        background-color: #a5db84 !important;
        border-color: #a5db84 !important;
        color:#fff;
    }
    .a-meet-create:hover {
        color:#fff;
    }
    .a-meet-delete{
        /*fe6d54*/
        background-color: #fe6d54 !important;
        border-color: #fe6d54 !important;
        color:#fff;
    }
    .a-meet-delete:hover {
        color:#fff;
    }
    .a-meet-view{
        /*fdcc55*/
        background-color: #fdcc55 !important;
        border-color: #fdcc55 !important;
        color:#fff;
    }
    .a-meet-view:hover {
        color:#fff;
    }
    /*-----------INIT BOTONOES--------*/
    /*GESTION---*/
    .btn-gestion {
        color: #fff;
        background-color: #00AFF1;
        border-color: #00AFF1;
    }
    .btn-gestion-important {
        color: #fff;
        background-color: rgb(193, 39, 45);
        border-color:  rgb(193, 39, 45);
    }

    /*-----------END BOTONOES--------*/

    /*SAVE DATA*/
    /*SAVE DATA*/
    .meet-btn-cancel{
        background-color: #999999;
        border-color: #fff !important;
        color: #fff;
        width: 145px;
        height: 37px;
        border-radius: 9px !important;
    }

    .btn-add-data {
        color: #373e4e;
        font-size: 27px;
        font-weight: 400;
        border-color: #fdfafa !important;

        border-radius: 2px !important;
        -webkit-border-radius: 2px !important;
        -moz-border-radius: 2px !important;
        box-shadow: inset 0 -2px 0 rgba(0,0,0,.05) !important;
        -moz-box-shadow: inset 0 -2px 0 rgba(0,0,0,.05) !important;
        -webkit-box-shadow: inset 0 -2px 0 rgba(243, 227, 227, 0.05) !important;

    }
    /*---PARA GENERAR REPORTES O AGREGAR---*/
    .meet-generate-gestion{
        background-color: #34495e;
        border-color: #fff !important;
        color: #fff;
        width: 85px;
        height: 29px;
        border-radius: 9px !important;
    }

    /*---INIT BOTONOES DE GESTION GRID--*/
    .btn-gestion-grid {
        font-size: 20px;
        border: none;
        background: none;
    }
    /*--icono--*/
    .btn-gestion-grid:before {
        /*color: #7e8c8d;*/
    }
    /*---END BOTONOES DE GESTION GRID--*/
    /*---botones a--*/
    .meet-a-delete{
        cursor: pointer;
        color: #D8503F !important;
        border: 0px solid transparent;
    }
    /*---botones personalizados gestion*/
    .a-gestion-grid {
        cursor: pointer;
        color: #00AFF1;
    }

    /*---BOTOINES DE GESTION GRID---*/


    /*meeet-tbl.css*/
    /*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
    /*
        Created on : 05/10/2016, 8:58:51
        Author     : Migu3ln (Perrin)
    */

    /*
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    */
    /*
        Created on : 11/06/2016, 12:04:47
        Author     : Migu3ln (P3rrin)
    */
    /*#065c77 == azul*/
    /*#0c4156=azul table*/
    /*#16a087=verde*/
    /*96a4a5=griz submenu*/
    /*c7b299= cafe activo menu*/
    /*----formularios colores---*/
    /* #c1d0db=body formulario gris*/
    /*----------tabla defecto---*/
    /* #0c4156=azul cabecera*/
    /* #f1c411 =amarillo*/
    /* naranja=#e84c3d !important*/

    tr.select-row-manager {
        background: #7e8c8de0 !important;
        color: #e6e6e6 !important;
    }

    table#prueba {
        /* text-align: center; */
        width: 80%;
    }

    /*cabeza de la tablla*/
    .xywer-tbl thead > tr {
        background: #065C77 !important;
        height: 47px !important;
    }

    /*---ALTERNADA TABLA--*/
    .xywer-tbl > tbody > tr:nth-child(odd) > td, .table-striped > tbody > tr:nth-child(odd) > th {
        background-color: #96a4a5 !important;

    }

    .xywer-tbl thead > tr > th a {
        color: #fff !important;
        font-size: 14px;
        font-weight: 200;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    /*---OPCIONES---*/
    .bootgrid-header {
        background: #ffffff !important;
        height: 52px;
        width: 100.0%;
        margin-bottom: 0px !important;
    }

    /*---COLOR DEL BUSCADOR---*/
    .bootgrid-header .search .glyphicon, .bootgrid-footer .search .glyphicon {
        background: #e6e6e6 !important;
        color: #7e8c8d;
        font-size: 14px;
    }

    /*--gestion---*/
    .widget-body-toolbar {
        border-bottom: 0px solid #96a4a5;
        background: transparent;
    }

    .bootgrid-header .search .glyphicon, .bootgrid-footer .search .glyphicon {
        left: 122px;
    }

    /*--borders del buscador--*/
    .input-group-addon {
        color: #fff;
        /*color: #d25400;*/
        border: none !important;

    }

    input.search-field.form-control {
        border: none !important;
    }

    .bootgrid-header div.row .actionBar {
        margin-top: 12px !important;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;

    }

    /*---INPUT BUSCADOR---*/
    .bootgrid-header .search-field {
        color: #0c4156 !important;
        background: #e6e6e6 !important;
        margin-left: -58px;
    }


    /*----------------BOOTGRID GESTION----------*/
    /*---color de la fila del encabezado dela tabla--*/
    .table-content-widget-gestion thead > tr {
        background: #0c4156 !important;
        height: 47px !important;
    }

    /*--letras de cada columna a--*/
    .table-content-widget-gestion thead > tr > th a {
        color: #ffffff !important;
    }

    .table-content-widget-gestion thead > tr > th a span {
        margin-top: 12px !important;

    }

    /*---ALTERNADA TABLA--*/
    .table-striped > tbody > tr:nth-child(odd) > td {
        background-color: #e6e6e6 !important;
        /*color: #6c6c6c;*/
        font-size: 14px;
        font-weight: 200;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;

    }

    .table-striped > tbody > tr {
        color: #6c6c6c;
        background-color: #e6e6e6 !important;
        font-size: 14px;
        font-weight: 200;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;

    }

    /*---LA PRIMERA  ALTERNADA--*/

    /*---HOVER TR--*/
    .xywer-tbl tbody > tr:hover {
        background: #7e8c8d !important;
        color: #ffffff;
    }

    .xywer-tbl tbody > tr:hover .edit-registro-label {
        color: #0c4156 !important;
    }

    .edit-registro-label {
        cursor: auto;
        width: 132px;
        background: #fff;
        text-align: center;
    }

    /*--------------LIST VIEW--------*/
    .jarviswidget > header {
        /*background: #8cc062   !important;*/
    }

    .jarviswidget header:first-child .nav-tabs li a {
        color: #fff !important;

    }

    .jarviswidget header:first-child .nav-tabs li.active a {
        color: #e7493b !important;

    }

    .jarviswidget > header > h2 {
        top: 1px !important;
    }

    /*---------GRID SIN ESTILO----*/
    .jarviswidget-color-blueDark > header {
        background: #065c77 !important;
        height: 58px !important;
        color: #ffffff !important;
    }

    /*---content--*/
    .jarviswidget > div {
        /*background: #96a4a5!important;*/
    }

    /*----------UIGRIDS---------*/
    /*paleta*/
    /*#f39c11= anaranjado*/
    /*#96a4a5= gris tabla*/
    /*----------GRID--*/
    .ui-grid-header-cell .sortable {
        color: #ffffff;
    }

    /*96a4a5*/
    /*-table top--*/
    .ui-grid-row:nth-child(odd) .ui-grid-cell {
        background: #afbcbc;

    }

    .ui-grid-cell {
        border-bottom: 0px solid;
        border-right: 0px solid;
        border-color: #ffffff;
    }

    .ui-grid-row:nth-child(even) .ui-grid-cell {
        background: #cccccc;
    }

    .ui-grid-header-cell-wrapper {
        background: #065c77;

    }

    .ui-grid-header-cell-row {
        height: 48px;

    }

    .ui-grid-icon-angle-down {
        display: none;
    }

    .ui-grid-cell-contents.ui-grid-header-cell-primary-focus {
        margin-top: 12px;
    }

    .ui-grid-header-cell {
        border-right: 1px solid;
        border-color: #d4d4d4;
        border-right: 1px solid;
        border-color: #d4d4d4;
        border-color: #065c77;

    }

    /*---distancia entre encabezado table y body table--*/
    .ui-grid-canvas {
        margin-top: 6px;
    }

    /*altura de celdas---*/
    .grid1479831094004 .ui-grid-row, .grid1479831094004 .ui-grid-cell, .grid1479831094004 .ui-grid-cell .ui-grid-vertical-bar {
        height: 32px;
    }

    /*----borde final---*/
    .ui-grid-top-panel {
        background: #065c77;
    }

    input.ui-grid-filter-input.ui-grid-filter-input-0.ng-dirty.ng-valid-parse.ng-not-empty.ng-touched {
        color: #6d6d6d;
    }

    .ui-grid-cell-contents span {
        font-weight: 100 !important;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
        color: #fff;
    }

    /*---al seleccionar una fila total--*/
    .ui-grid-row.ui-grid-row-selected > [ui-grid-row] > .ui-grid-cell {
        background-color: #7e8c8d !important;
    }

    /*--------GESTION DE BOTONOES---*/
    .gestion-view-data {
        background: none;
        margin-top: 3%;
        border: none;
        font-size: 16px !important;
        color: #ffffff;
        margin-top: 4%;
    }

    .gestion-view-data:hover {
        color: #065C77;

    }

    /*--------GESTION DE BOTONOES---*/
    input[type="text"].ui-grid-filter-input {
        color: #7e8c8d;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;

    }

    /*---focus column--*/
    .ui-grid-cell-focus {
        outline: 0;
        background-color: #cccccc;
    }

    /*INIT GESTION DATA--*/

    /*footer*/
    .ui-grid-pager-control input {
        border-radius: 0px;
        background-color: #afbcbc;
        border: 1px solid #afbcbc;
    }

    /*---botones--*/
    .ui-grid-pager-control button {
        border-radius: 0px;
    }

    button.ui-grid-pager-first {
        border-color: #96a4a5;
        background-color: #96a4a5 !important;
    }

    .ui-grid-pager-row-count-picker select {
        background-color: #afbcbc;
        border-radius: 0px !important;
        border: 1px solid #afbcbc;
    }

    .ui-grid-pager-row-count-picker select {
        border-radius: 0px !important;
    }

    button.ui-grid-pager-last {
        border-color: #96a4a5;
        background-color: #96a4a5 !important;
    }

    .ui-grid {
        border: 0px solid #d4d4d4;
    }

    .ui-grid-pager-container {
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    .ui-grid-render-container {
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    .ui-grid-canvas {
        color: #fff;
    }

    button.ui-grid-paper-next:active {
        background-color: yellow !important;
        background-color: yellow !important;
    }

    div#content-data-search {
        margin-right: 0%;
        background-color: #ffffff;
        margin-left: 0%;
    }

    div#content-data-search div div div.actionBar {
        margin-top: 1.6%;
        margin-bottom: -0.75%;
    }

    .ats-switch .knob {
        background: #fff !important;
    }

    .ats-switch {
        border-radius: 0px;
    }

    .meet-search-input {
        background: #e6e6e6 !important;
        border-color: #e6e6e6;
        height: 35px;
    }


    .meet-search-icon {
        top: 0px;
        color: #7e8c8d !important;
        height: 6px;
        left: 100%;
        background: #e6e6e6 !important;
    }

    .meet-search-btn {
        background: #fff;
        color: #7e8c8d;
    }

    /*---lineas dl borde d la tabla--*/
    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        border-top: 0px solid #ddd !important;
    }

    /*----listo separacion cabezera---*/
    .ui-grid-header {
        margin-bottom: -6px;
    }

    /*-----------GESTION DE FILTROS------*/
    /*---botones background*/
    .actions button.btn {
        background: #E6E6E6;
        color: #818e8f;
    }

    /*-----BORDES RERECHOS*/
    button.btn.btn-default.btn-refresh {
        border-right: 7px solid #00AFF1;
        margin-top: 0px;
    }

    .dropdown.btn-group {
        border-right: 7px solid #00AFF1;
    }

    button.btn {
        border: 0px solid transparent;
    }

    .bootgrid-footer .infoBar {
        /*background: #e7493b;*/
    }

    /*------ANCHO DE LA SELECION*/
    /*------HOVER*/
    .bootgrid-header .actionBar .btn-group > .btn-group .dropdown-menu .dropdown-item:hover {
        background: #00AFF1;
        color: #fff !important;

    }

    /*-----ALINEACION DE CUADRADO*/
    .bootgrid-header .actionBar .btn-group > .btn-group .dropdown-menu .dropdown-item .dropdown-item-checkbox {
        margin: 0px 2px 4px -11px;
        border-radius: 0px !important;
    }

    .input[type=radio] {
        border-radius: 0px !important;

    }

    .bootgrid-header .actionBar .btn-group > .btn-group .dropdown-menu .dropdown-item {
        padding: 2px 15px;
        font-size: 11px;
    }

    .li-last-boot {
        display: none;
    }

    /*-----PAJINACION COLOR*/
    .pagination > li > a {
        color: #065C77;
        background-color: #AFBCBC;
        border: 1px solid #AFBCBC;
        cursor: pointer;
    }

    .pagination > .active > a {
        background-color: #7E8C8D !important;
        border-color: #7E8C8D !important;
    }

    /*------BUTOON DE LA SELECION*/
    .checkbox-select {


    }

    /*----CHECBOX*/
    input[type=checkbox] {
        width: 14px;
        height: 14px;
        cursor: pointer;
        font-size: 10px;
    }

    input[type=checkbox]:checked:after {
        content: "\2714";
        margin-left: 3px;
        font-size: 10px;
    }

    /*------sirve*/
    input[type=checkbox] {
        -webkit-appearance: none;
        appearance: none;
        cursor: pointer;
        border: 1px solid #96A4A5;
        border-radius: 0px;
        background-color: #96A4A5;
        color: black;
        box-sizing: content-box;
    }

    .dropdown-menu > .active > a {
        color: #fff;
        text-decoration: none;
        outline: 0;
        background-color: #00AFF1;
    }

    .bootgrid-footer .infoBar {
        /*background: #96a4a5;*/
    }

    /*---FILTROS TABLA --*/
    div#content-filtres-data {
        height: auto;
        margin-right: 1%;
        margin-left: 0%;
        background: #cccccc;
    }

    /*--filtros division--*/
    div#content-filtres-adicionales {
        margin-top: 3px;
    }

    div#sad-meet-maldy .meet-create-gestion {
        margin-top: 3px;
        margin-bottom: 2%;
    }

    #admin_gestion {
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    .meet-create-gestion {
        border-radius: 8px;
        width: 77px;
        background: #00AFF1;
        color: #ffffff;
    }

    .meet-create-gestion:hover {
        background: #00aff1b0;
    }

    .bootgrid-table th:hover, .bootgrid-table th:active {
        background: #607D8B;
    }

    .margin-gestion {
        margin-top: 14% !important;
    }

    /*//////hover del pajinacion*/
    .pagination > li > a:hover {
        background-color: #ffffff;
        border-color: #ffffff;
    }

    .pagination > li.prev > a:hover {
        color: #00aff1 !important;

    }

    .pagination > li.next > a:hover {
        color: #00aff1 !important;

    }

    .pagination > li.first > a:hover {
        color: #00aff1 !important;

    }

    .pagination > li.last > a:hover {
        color: #00aff1 !important;
    }

    /*////// activacion*/
    .pagination > .active > a {
        color: #666666;
        background-color: #ffffff !important;
        border-color: #ffffff !important;
    }

    .pagination > li > a, .pagination > li > span {
        box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0);
        -moz-box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0);
        -webkit-box-shadow: inset 0 -2px 0 rgba(0, 0, 0, 0);
    }

    .pagination > li > a {
        color: #666666;
        background-color: #e4e4e4;
        border: 1px solid #e4e4e4;
        cursor: pointer;
    }

    .pagination > .disabled > a {
        color: #666666;
        background-color: #e4e4e4;
        border-color: #e4e4e4;
        cursor: not-allowed;
    }

    .bootgrid-footer div div div.infos {
        color: #00AFF1;
        font-size: 11pt;
        text-align: right !important;
    }

    /*---ERRORES ROW--*/
    .meet-error-border-right {
        border-left: 34px solid #c1272d;
    }

    .meet-success-border-right {
        border-left: 34px solid #39b54a;
    }

    .meet-warning-border-right {
        border-left: 34px solid #29477c;
    }

    .meet-info-border-right {
        border-left: 34px solid #29477c;
    }

    /*border-width: 19px 0px 1px 0;*/

    /*---NO RESULTADOS--*/
    td.no-results {
        text-align: left !important;
    }

    .xywer-tbl {
        width: 99% !important;
    }

    tr.tr-empty {
        border-right: 1px solid #6F96C5;
        border-left: 1px solid #6F96C5;
        border-bottom: 1px solid #6F96C5;
        border-top: 2px solid #6F96C5;
    }

    i.table-i-empty {
        font-size: 40px;
        color: #29477c;
    }

    span.title-info-empty {
        /* padding-top: 31px; */
        color: #29477c;
        font-size: 24px;
        margin-right: 13px;
        font-weight: 700;
    }

    span.title-info-data-empty {
        color: #29477c;
        font-size: 13px;
        margin-right: 13px;
        font-weight: 200;
    }

    /*---filtros table--*/
    .content-filtres-data > div {
        margin-top: 1px;
    }

    /*---rows gestion de tables--*/
    .row-data-gestion {
        color: #271919;
    }

    .edit-registro-label {
    }

    /*----FOOTER--*/
    .bootgrid-footer {
        margin-left: -28px;
    }

    /*--bordes*/
    .pagination > li:first-child > a, .pagination > li:first-child > span {
        margin-left: 0;
        border-bottom-left-radius: 0px !important;
        border-top-left-radius: 0px !important;
    }


    /*REBRANDING TBL XYWER*/
    /*------TABLAS*/
    .xywer-tbl-admin {
        width: 99%;
        margin-bottom: 15%;
    }

    /*HEAD*/
    .xywer-tbl-admin thead > tr {
        background: #065C77 !important;
        height: 47px !important;
    }

    /*HEAD LETRAS*/

    .xywer-tbl-admin thead > tr > th a {
        color: #fff !important;
        font-size: 14px;
        font-weight: 200;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    /*---TBODY*/
    .xywer-tbl-admin > tbody > tr {
        background-color: #e6e6e6;
        color: #7e8c8d;
        font-size: 12px;
        font-weight: 200;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    .xywer-tbl-admin > tbody > tr:hover {
        color: #fff;
        background-color: #7e8c8d;

    }

    .xywer-tbl-admin > tbody > tr.selected {
        color: #fff;
        background-color: #7e8c8d;

    }

    /*---UPDATE*/
    .xywer-tbl-admin > tbody > tr:hover .a-meet-update {
        color: #cccccc !important;


    }

    .xywer-tbl-admin tbody tr {
        height: 55px;
    }

    /*---SEARCH icon*/
    .bootgrid-header .search .fa, .bootgrid-footer .search .fa {
        font-size: 16px !important;
        color: #818e8f !important;
        background: #e6e6e6 !important;
    }

    /*---GRID---*/
    .input-group-addon:first-child {
        left: 67% !important;
        position: relative !important;
    }


    /*
    KARDEX MANAGER*/

    div#btn-gestion {
        margin-top: 1px;
    }

    #kardex-form .content-pagados {
        margin-left: -5%;
        /* left: 10%; */
    }

    #kardex-form {
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    #kardex-form .div-data-content-semaforos {
        margin-right: 4%;
        padding-bottom: 6%;
        padding-top: 0%;
    }

    form#frm-reporte {
        margin-top: 2%;
    }

    /*---table kardedx*/
    /*rowspan="2"*/
    th.kardex-b1 {
        text-align: center;
        border-right: 1px solid #ddd !important;
        border-left: 1px solid #ddd !important;
        color: #fff;
        background: #34495e;
    }

    th.kardex-b1.egresos {
        background: #215e03;
    }

    th.kardex-data.current-data, th.kardex-data-right.current-data {
        background: #565656;
        color: #f2f6f6;
        font-size: 17px;
    }

    th.kardex-b2 {
        text-align: center;
        border-right: 1px solid #565656 !important;
        border-left: 1px solid #565656 !important;
        border-top: 1px solid #fff !important;
        color: #fff;
        background: #7e8c8d;
    }

    table#table-data-kardex {
        width: 100%;
    }

    .kardex-data {
        border-bottom: 1px solid #737373 !important;
        border-right: 1px solid #737373 !important;
        border-left: 1px solid #737373 !important;
        background: #e6e6e6;
    }

    .kardex-data-left {
        border-bottom: 1px solid #737373 !important;
        border-right: 1px solid #737373 !important;
        border-left: 1px solid #ddd !important;
        background: #e6e6e6;
    }

    .kardex-data-right {
        border-bottom: 1px solid #737373 !important;
        border-right: 1px solid #565656 !important;
        border-left: 1px solid #737373 !important;
        background: #e6e6e6;
    }

    #table-data-inventario-final {
        margin-bottom: 13px;
        width: 45%;
    }

    th.inventario-final-title {
        font-weight: 300;
        background: #34495e;
        color: #fff;
    }

    /*---titulos de karde*/
    th.inventario-cantidad_existente-title, .inventario-punitario_existente-title, .inventario-ptotal_existente-title {
        background: #7e8c8d;
        color: #fff;
        font-weight: 300;
    }

    .inventario-cantidad_existente, .inventario-punitario_existente, .inventario-ptotal_existente {
        text-align: center;
    }

    /*---bordes-*/
    th.inventario-punitario_existente-title.inventario-total-th-title {
        border-left: 6px solid #f3ebeb;
    }

    th.inventario-punitario_existente.inventario-total-th {
        border-left: 6px solid #f3ebeb;
    }

    th.inventario-ptotal_existente-title.inventario-total-th-title {
        border-left: 6px solid #f3ebeb;
    }

    th.inventario-ptotal_existente.inventario-total-th {
        border-left: 6px solid #f3ebeb;
    }

    .inventario-total-th {
        background: #e6e6e6;

    }

    .inventario-final {
        color: #fff;
        background: #34495e;
    }

    .danger-semaforo {
        color: #fff;
        background: #c1272d;
    }

    .warning-semaforo {
        color: #fff;
        background: #fbb03b;
    }

    .success-semaforo {
        color: #fff;
        background: #8cc63f;

    }

    /*---BORDERS ROWS--*/
    .xywer-border-tr-info {
        border-top: 1px solid #29477c;
        border-bottom: 1px solid #29477c;
        border-left: 1px solid #29477c;
        border-right: 1px solid #29477c;
    }

    span.title-info i {
        font-size: 37px;
        color: #29477c;
    }

    span.title-info {
        /* padding-top: 31px; */
        color: #29477c;
        font-size: 24px;
        margin-right: 13px;
    }

    span.title-info-data {
        color: #29477c;
        font-size: 13px;
        margin-right: 13px;
        font-weight: 200;
    }

  /*  meet-formularios*/
    /*
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
*/
    /*
        Created on : 18/11/2016, 9:00:38
        Author     :MIGU3LN ALBA
    */
    /*----INPUT COLOR--*/
    .form-control{
        /*background-color: #cccbcb;*/
    }
    /*---SELECT 2---*/
    .select2-search-choice-close:before{
        color: #e84c3d !important;
    }
    /*---x*/
    .select2-container .select2-choice abbr{
        font-size: 16px ;
        right: 27px ;
    }
    /*flecha*/
    .select2-container .select2-choice .select2-arrow b {
        top: -3px;
    }
    .form-control:focus {
        background-color: #fff;
    }
    form input.form-control::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #B2B2B2 !important;
    }
    form textarea.form-control::-webkit-input-placeholder { /* Chrome/Opera/Safari */
        color: #B2B2B2 !important;
    }
    /*::-moz-placeholder {  Firefox 19+
      color: pink !important;
    }
    :-ms-input-placeholder {  IE 10+
      color: pink !important;
    }
    :-moz-placeholder {  Firefox 18-
      color: pink !important;
    }*/
    /*---calendar---*/
    span.input-group-addon{
        background:#9d153b;
        color:#fff;
    }
    /*---drop select2---*/
    .select2-drop-active{
        border: 0px solid #f9fafb !important;
        border-bottom-width: 0px !important;
    }
    .select2-container .select2-choice{
        background: #fff;
        border: 1px solid #ccc;
    }
    /*-----CUADRITOS VERDES*/
    .select2-container .select2-choice .select2-arrow{
        background:#00AFF1!important;
        color: #fff;
        width: 25px;
    }
    .select2-results .select2-highlighted{
        background: #78cbd6!important;
        color: #fff;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    /*Span del select2*/
    span.select2-chosen{
        color:#BCBCBC;
    }

    /*searching------*/
    .select2-results .select2-no-results, .select2-results .select2-searching, .select2-results .select2-selection-limit {
        color: #BCBCBC;
    }

    .select2-results
    {
        background: #fff;
        margin: 0px 0px 0px 0;
        padding: 0 0 0 0px;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
    }

    .select2-search{
        padding-left: 0px;
        padding-right: 0px;
    }
    .select2-search input{
        background: #fff;

    }
    .select2-search:before{
        color: #fff !important;

    }
    /*--errors---*/

    .form-inline .help-block.error, .form-inline .help-inline.error, .form-horizontal .help-block.error, .form-horizontal .help-inline.error, .form-vertical .help-block.error, .form-vertical .help-inline.error{

        color:#b7302c !important;
    }
    .has-error .checkbox, .has-error .checkbox-inline, .has-error .control-label, .has-error .help-block, .has-error .radio, .has-error .radio-inline, .has-error.checkbox label, .has-error.checkbox-inline label, .has-error.radio label, .has-error.radio-inline label{
        color:#b7302c !important;

    }

    /*-----------MODALES---AGNULAR*/
    /*---encabezado---*/
    md-toolbar.md-default-theme:not(.md-menu-toolbar), md-toolbar:not(.md-menu-toolbar) {
        background-color: #373e4e !important;
        color: rgba(255,255,255,0.87);
    }
    /*---bordes modal---*/
    md-dialog.md-default-theme, md-dialog{
        border-radius: 0px !important;
    }


    /*-------------tabs----*/
    .tabs-left .nav-tabs>li.active>a{
        box-shadow: 0px 0 0 #63c6af!important;
        /*    webkit-box-shadow: -2px 0 0 #999999;*/
        margin-left: 0px!important;
    }
    /*--contenido del modal--*/
    .content-dialog {
        margin-top: 1%;
    }
    .tabs-left.tabs-left-meet.nav-tabs>li.active>a {
        -webkit-box-shadow: -2px 0 0 #ff3300;
        -moz-box-shadow: -2px 0 0 #57889c;
        box-shadow: -2px 0 0 #57889c;
        border-top-width: 1px!important;
        border-left: none!important;
        margin-left: 1px!important;
    }
    /*--liinea-- righ*/
    .tabs-left.tabs-left-meet>.nav-tabs {
        float: left;
        margin-right: 19px;
        border-right: 0px solid #ddd;
    }
    /*li activo*/
    /*.nav-tabs.ul-nav-tabs-meet>li.active>a{
        border-left-style: none !important;
        background-color: #e84c3d;
        margin-left: 0px !important;
        color:#fff;
    }*/
    .nav-tabs.ul-nav-tabs-meet>li>a{
        border-left-style: outset !important;
        color:#666666;
    }

    /*---border li--*/
    .tabs-left.tabs-left-meet > .nav-tabs > li > a{
        border-radius: 0px 0 0 0px;

    }
    .tabs-left.tabs-left-meet>.nav-tabs.ul-nav-tabs-meet{
        margin-left: 2%;
    }
    .tabs-left .nav-tabs>li>a {
        box-shadow: -6px 0 0 #999999;
        webkit-box-shadow: -2px 0 0 #999999;
    }

    md-dialog .md-actions, md-dialog md-dialog-actions{
        padding-right: 32%;
    }
    /*--end modal--*/
    /*---btns---*/
    .btn-save-meet {
        background-color: #373e4e;
        border-color: #fff !important;
        color: #fff;
        width: 145px;
        height: 37px;
        border-radius: 9px !important;
    }
    .btn-save-meet:hover{
        color: #f9fafb;
    }
    .btn-cancel-meet {
        background-color: #999999;
        border-color: #fff !important;
        color: #fff;
        width: 145px;
        height: 37px;
        border-radius: 9px !important;
    }
    /*----VALIDACIONES---*/

    .has-error{
        color:#c1272d !important;
    }
    span.required{
        color:#c1272d !important;

    }
    .has-success{
        color:#9cdaa4 !important;
    }
    .has-success span.required{
        color:#9cdaa4 !important;
    }
    .control-label {
        text-align: left !important;
    }
    /*----succes---*/

    .has-success .control-label{
        color:#9cdaa4 !important;

    }
    .has-success .form-control{
        /*color:#9cdaa4 !important;*/

    }
    .help-block.error {
        font-size: 11px;
        text-align: right !important;
    }
    .form-subtitle {
        font-weight: bold;
    }

    /*----TITULOS--*/
    .header-title {
        font-weight: 900;
    }


    /*------GESTION DE INFORMACION---*/
    .title-gestion{
        color: #3f4956;
        font-weight: 200;
        font-size: 23px;
    }
    /*------MARGIN LET Y TOP ALL*/

    /*letras*/
    h3#title-info {
        font-size: 26px;
        color: #34495E!important;
    }

    td.title-table {
        font-size: 14px;
        color: #E67F22!important;
    }

    .form-horizontal .control-label{
        margin-bottom: 0;
        padding-top: 7px;
        font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif !important;
        font-size: 14px;
    }
    ul.select2-choices {
        margin-left: -9%;
    }
    /*-------LA OPCION DE CERRAR X*/
    .select2-search-choice-close:before {
        color: #fff!important;
    }
    .btn[disabled]{
        opacity: 0.65;
    }

    #content-info{
        margin-top: -10%;

    }
    /*---ESPACIADO DE INPUTS --*/
    .smart-form-meet .row {
        margin-top: 1%;
    }

    /*----ADMIN--*/
    .content-return {
        font-size: 33px ;
        height: 33px;
        width: 33px;
        color: #34b196;
        cursor: pointer;
        margin-top: -8%;

    }
    .btn-gestion-admin button{
        color:#7e8c8d;
        font-size: 18px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 2px;
        box-shadow: inset 0 0px 0 rgba(0,0,0,.05);
        -moz-box-shadow: inset 0 -2px 0 rgba(0,0,0,.05);
        -webkit-box-shadow: inset 0 0px 0 rgba(0,0,0,.05);
        -webkit-border-radius: 0px !important;
        background: none;
    }
    /*---VALIDACIONES DE ERRORES--*/
    .smart-form .state-error+em {
        margin-top: 1px;
        text-align: right !important;
    }
    /*//////*/
    /*input.form-control.ng-pristine.ng-valid.ng-empty.ng-touched {
        margin-left: -13%;
    }*/
    div#s2id_Cliente_t_telefono_tipo_id {
        margin-left: 2%;
    }
    div#s2id_Cliente_t_operadora_tipo_id {
        margin-left: 11%;
    }


    .form-horizontal .control-label.left-label {
        text-align: left !important;
    }

    .form-horizontal .control-label.right-label {
        text-align: right !important;
    }

    /*---------SCROLL CONFIG---*/

    /*---COLOR DEL SCROLL*/
    .select2-results::-webkit-scrollbar {
        width: 10px;
    }
    .select2-results::-webkit-scrollbar-track {
        /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);*/
        border-radius: 10px;
        background-color: #e6e6e6;
    }

    .select2-results::-webkit-scrollbar-thumb {
        border-radius: 10px;
        /*-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);*/
    }
    .select2-container-multi .select2-choices .select2-search-choice {
        background-color: #065C77 !important;
        border: 0px solid #065C77  !important;
        border-radius: 12px;
    }
</style>
