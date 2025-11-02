<?php
$resourcePathServer = env('APP_IS_SERVER') ? "public/" : '';
$assetsTemplateMintonUpdate = 'templates/minton/';
?>
<style>
    .pager--buttons-steps {
        position: fixed;
        top: 87%;
        z-index: 1500;
    }

    .nav-link--prices-packing {
        background-color: #ffffff !important;
        color: #696363 !important;
    }

    .nav-link--prices-packing.active {
        background-color: rgba(50, 59, 68, .2) !important;
        color: #696363 !important;
    }

    .link-add-manager i {
        font-size: 29px;
    }

    .link-add-manager:hover {
        cursor: pointer;
    }

    .invalid-feedback {
        color: #f04124 !important;
    }

    .disabled-element {
        color: gray; /* Cambia el color del texto para indicar que está deshabilitado */
        pointer-events: none; /* Evita que los eventos del mouse lleguen al elemento */
        opacity: 0.5; /* Puede reducir la opacidad para indicar visualmente que está deshabilitado */
    }

    .tableFixHead {
        overflow: auto;
        height: 400px;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    /* Just common table stuff. Really. */
    .tableFixHead table {
        border-collapse: collapse;
        width: 100%;
    }

    .tableFixHead th, td {
        padding: 8px 16px;
    }

    .tableFixHead th {
        background: #eee;
    }

    .search.form-group {
        width: 28% !important;
    }

    a.link--manager {
        cursor: pointer;
        font-size: 21px;
    }

    .manager-view-product-parent__ul {
        /*  list-style-type: none;*/
        padding: 0;
        margin: 0;
        /*   overflow: hidden;*/
    }

    .manager-view-product-parent__li {
        float: left;
        margin-right: 20px; /* Espacio entre cada elemento <li> */
    }

    .manager-view-product-parent__li-title {

        margin-right: 5px;
    }

    .manager-view-product-parent__li-value {
        font-weight: bold;
        margin-right: 5px;
    }

    /* Esto es opcional: añadir un borde a cada elemento <li> */
    .manager-view-product-parent__li {
        /*  border: 1px solid #ccc; */
        padding: 5px;
        border-radius: 5px;
    }

    .content-row-manager-buttons--tabs {
        text-align: right;
    }

    .content-row-manager-buttons--tabs-left {
        text-align: left;
    }

    .container-manager-buttons--tabs {
        margin-bottom: 1.5%;
    }

    .container-manager-buttons--tabs {
        margin-bottom: 1.5%;
    }

    .card {
        padding-left: 22px;
        padding-right: 22px;
    }

    .container-manager-buttons--tabs-input {
        width: 100%;
        top: 18%;
        z-index: 15;
        position: fixed;
        display: inline-block;
    }

    .content-row-manager-buttons--tabs-left {
        width: 100%;
    }

    .dz-error.dz-complete {
        border-bottom: 2px solid #c95818 !important;
    }

    .dz-success.dz-complete {
        border-bottom: 2px solid #18c984 !important;

    }

    .content-description__value--state-text-success {
        font-weight: bold;
        color: #70d3cb;
    }

    .content-description__value--state-text-warning {
        font-weight: bold;
        color: #c95818;
    }

    .content-description__value--bold {
        font-weight: bold;
    }


    .xywer-tbl-admin--inka thead > tr {
        background: #f1f5f7 !important;
        height: 47px !important;
    }

    .xywer-tbl-admin--inka thead > tr > th a {
        color: #6c757d !important;

    }

    .xywer-tbl-admin--inka > tbody > tr {
        background-color: #ffffff !important;
    }

    .xywer-tbl-admin--inka > tbody > tr:hover {

        background-color: #e7e8e9 !important;
        color: #6c757d !important;;

        cursor: pointer;
    }

    .xywer-tbl-admin--inka th, td {
        border-bottom: 1px solid #6c757d;
        border-left: 1px solid #6c757d;
        border-right: 1px solid #6c757d;
        border-top: 1px solid #6c757d;

    }

    .xywer-tbl-admin--inka tbody tr {
        border: 1px solid #6c757d;
        /* padding: 8px; */
    }

    .xywer-tbl-admin--inka .manager-thead th {
        padding-left: 3% !important;
    }
    .xywer-tbl-admin--inka > tbody > tr.selected{
        color: #6c757d !important;
        background-color: #e7e8e9 !important;

    }
    .search.form-group {
        width: 50% !important;
    }
    .manager-inline div.search.form-group {
        width: 65% !important;
    }
    .bootgrid-header {
        padding-bottom: 71px;
    }
    .manager-inline-content {
        width: 100%;
    }

    .manager-inline {
        display: inline;
    }

    .manager-inline-content.manager-inline-content--align-right {
        text-align: right;
    }

    .manager-inline-content.manager-inline-content--align-left {
        text-align: left;
    }

    .manager-inline div.actions div:nth-child(3) {
        background: aqua;
        display: none;
    }

    .caret {
        display: inline-block;
        width: 0;
        height: 0;
        margin-left: 2px;
        vertical-align: middle;
        border-top: 4px solid;
        border-right: 4px solid transparent;
        border-left: 4px solid transparent;
    }

    table th > .column-header-anchor {
        color: #333;
        cursor: not-allowed;
        display: block;
        position: relative;
        text-decoration: none;
    }

    table th > .column-header-anchor.sortable {
        cursor: pointer;
    }
    .manager-information tbody tr {
        border: 0px solid #6c757d !important;
        /* padding: 8px; */
    }
    table.manager-information {
        width: 100%;
    }
    td.manager-information__td-img {
        width: 13%;
    }
    img.content-description__photos--img-row {
        width: 70px;
        height: 70px;
    }
    .manager-information__td-information-description {
        font-weight: bold;
        font-size: 18px;
    }

</style>
<?php
$url_path_plugins = "libs/";
?>
@php
    $managerOptions=array();
@endphp
<link href="{{ asset($resourcePathServer.'css/menu-drogon.css') }}" rel="stylesheet"
      type="text/css">
@include('partials.plugins.resourcesCss',['bootgrid'=>true])
<link href="{{ asset($resourcePathServer.$url_path_plugins.'wizard/wizard.min.css') }}" rel="stylesheet"
      type="text/css">
@if  (!in_array($configPartial['typeManager'] ,$allowProcessAngular) )
    @include('partials.mangerVueCss',$managerOptions)
    {{--frameworks VUE JS PLUGINS--}}
    @if ($configPartial['typeManager'] !='managerEducationalInstitutionByBusiness'  && $configPartial['typeManager'] != 'managerBusinessByDiscount')
        <link rel="stylesheet" href="{{ asset($resourcePathServer.$url_path_plugins.'vue-select/vue-select.min.css')}}">
        <!-- Add Bootstrap and Bootstrap-Vue CSS to the <head> section -->
        <link type="text/css" rel="stylesheet"
              href="{{ asset($resourcePathServer.$url_path_plugins.'vue-datetimepicker/vue-datetimepicker.min.css')}}"/>
        <link type="text/css" rel="stylesheet"
              href="{{ asset($resourcePathServer.$url_path_plugins.'vue2-timepicker/vue2-timepicker.min.css')}}"/>
        <link href="{{ asset($resourcePathServer."plugins/vue-date-picker/DateTimePicker.css") }}" rel="stylesheet"
              type="text/css">
    @endif
    @if ($configPartial['typeManager'] =='managerEducationalInstitutionByBusiness' )

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/jquery-confirm.min.css')}}">
        <link type="text/css" rel="stylesheet"
              href="{{ asset($resourcePathServer.'libs/angular1.5/libs/switch/angular-toggle-switch-bootstrap-3.css')}}"/>
        <link type="text/css" rel="stylesheet"
              href="{{ asset($resourcePathServer.'libs/angular1.5/libs/angular-switcher-master/dist/angular-switcher.min.css')}}"/>
        {{--libs/askwer/Knockout--}}
        <link type="text/css" rel="stylesheet"
              href="{{ asset($resourcePathServer.'libs/askwer/Knockout/framework/css/bootstrap-editable.css')}}"/>
        <link type="text/css" rel="stylesheet"
              href="{{ asset($resourcePathServer.'libs/askwer/Knockout/plugins/fancybox/jquery.fancybox-1.3.4.css')}}"/>
        <link type="text/css" rel="stylesheet"
              href="{{ asset($resourcePathServer.'libs/askwer/css/stylesAskwer.css')}}"/>
        <link type="text/css" rel="stylesheet" href="{{ asset($resourcePathServer.'libs/askwer/css/styles.css')}}"/>
    @elseif ($configPartial['typeManager'] === 'managerPatient')

        <style>


            .card {
                height: auto !important;
            }

            .manager-content-upload.upload-demo {
                width: 100%;
                height: 100%;
            }

            .upload-demo .upload-demo-wrap,
            .upload-demo .upload-result,
            .upload-demo.ready .upload-msg {
                display: none;
            }

            .upload-demo.ready .upload-demo-wrap {
                display: block;
            }

            .upload-demo.ready .upload-result {
                display: inline-block;
            }

            .upload-demo-wrap {
                width: auto;
                height: auto;
                margin: 0 auto;
            }

            .upload-msg {
                text-align: center;
                padding: 50px;
                font-size: 22px;
                color: #aaa;
                width: auto;
                height: auto;
                margin: 50px auto;
                border: 1px solid #aaa;
            }


            .header-process__return {
                cursor: pointer;
                font-size: 34px;
            }

            .content-description__title-process {
                color: #5867dd;
                font-weight: 600;
            }

            .content-description__information-process {

                display: inherit;
            }

            .header-process__title {
                cursor: pointer;
            }

            /*TREATMENT*/
            .vdg-header {
                display: none !important;
            }

            div#app-management {
                margin-top: -5%;
            }

            .card-body {

                padding: 0 !important;
            }

            /*ODONTOGRAM*/
            /*  ---LEGEND--*/
            .content-legend {
                text-align: center;
                padding-bottom: 9%
            }

            .content-legend__item {
                margin-right: 3%;
                display: inline-block;
            }

            .content-legend__item-bullet {
                width: 2rem;
                height: .45rem;
                display: inline-block;
                border-radius: 1.1rem;
                margin-bottom: .12rem;
                margin-right: .8rem;
            }

            .content__form-dental_piece_by_odontogram {
                background: antiquewhite;
                position: fixed;
                right: 0;
                top: 17%;
                display: none;
                z-index: 15;
            }

            svg#content-all-data-odontogram-inferior {
                margin-top: 2%;
            }

            .content__render-odontogram-loader {
                height: 360px;
                text-align: center;
            }

            div#content-render-data-odontogram-inferior, div#content-render-data-odontogram-superior {
                width: 100%;

            }

            .hide-element {
                display: none;
            }

            .pointer-mouse {
                cursor: pointer;
            }

            tr.active {
                background: antiquewhite;
            }

            .m-datatable__table.xywer-tbl-admin tbody {
                display: table;
                width: 100%;
            }

            /*
            ------RRESOURCES---*/
            .image-animation {
                animation-name: image-animation;
                animation-timing-function: ease-in-out;
                animation-iteration-count: infinite;
                animation-duration: 1s;
                animation-direction: alternate;
                margin-top: 25%;
                width: 90px
            }

            @keyframes image-animation {
                0% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.5;
                }
                100% {
                    opacity: 0;
                }
            }

            .piece-hover {
                fill-opacity: 0;
                stroke-opacity: 0.3;
            }

            .piece-hover--management {
                fill: rgb(0, 138, 202);
                fill-opacity: 0.3;
                stroke-opacity: 0;
                display: block !important;
            }

            .full-scream-content-all-data-odontogram-inferior {
                /*0 130 1163 200*/
                padding-top: 5%; /*0 80 1163 200*/
            }

            .nav-link:before {
                content: '';
                position: absolute;
                bottom: -19px;
                left: 0;
                right: 0;
                height: 4px;
                border-radius: 4px;
                display: none;
            }

            a.nav-link:before {
                content: '';
                position: absolute;
                bottom: -19px;
                left: 0;
                right: 0;
                height: 4px;
                border-radius: 4px;
                display: none;
            }

            .select2-dropdown {
                z-index: 2106 !important;
            }

            button.btn.close.btn-secondary {
                color: black;
            }


            .xywer-tbl-admin thead > tr > th {
                color: #fff;
            }

            span.birthday-date {
                position: absolute;
                top: 2%;
                right: 10%;
                display: inline-block;
                padding: .25em .4em;
                font-size: 75%;
                font-weight: 700;
                line-height: 1;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: .25rem;
                -webkit-transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                background-color: #37cde6;
            }

            .not-image {
                display: none !important;
            }
        </style>
        @include('partials.plugins.resourcesCss',['croppie'=>true])

    @elseif ($configPartial['typeManager'] === 'managerProductService')
        @include('partials.plugins.resourcesCss',['dataGridVue'=>true])

    @elseif($configPartial['typeManager'] === 'managerProductManager')

        <style>

        </style>
    @elseif ($configPartial['typeManager'] === 'managerBusinessByHistory')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">

    @elseif ($configPartial['typeManager'] === 'managerBusinessByAcademicOfferings')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">
    @elseif ($configPartial['typeManager'] === 'managerBusinessByAcademicOfferingsInstitution')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">

    @elseif ($configPartial['typeManager'] === 'managerBusinessByPartnerCompanies')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">
    @elseif ($configPartial['typeManager'] === 'managerBusinessByInformationCustom')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">
    @elseif ($configPartial['typeManager'] === 'managerBusinessCounterCustom')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">
    @elseif ($configPartial['typeManager'] === 'managerBusinessByFrequentQuestion')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">

    @elseif ($configPartial['typeManager'] === 'managerBusinessByRequirements')

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'assets/libs/summernote/summernoteServer.min.css':'assets/libs/summernote/summernote.min.css'))}}">

    @elseif ($configPartial['typeManager'] === 'managerProductManager')

        <link
            href="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate."assets/libs/dropzone/min/dropzone.min.css")}}"
            rel="stylesheet"
            type="text/css"/>

        <link href="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate."assets/libs/quill/quill.core.css")}}"
              rel="stylesheet"
              type="text/css"/>
        <link href="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate."assets/libs/quill/quill.snow.css")}}"
              rel="stylesheet"
              type="text/css"/>

        <link href="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate."assets/css/icons.min.css")}}"
              rel="stylesheet"
              type="text/css"/>
        <link href="{{ asset($resourcePathServer.$assetsTemplateMintonUpdate."assets/css/all-manager.css")}}"
              rel="stylesheet"
              type="text/css"/>
    @endif

    @if ($configPartial['typeManager'] == 'managerBusinessByDiscount')
        @include('partials.pluginsVue.resourcesCss',['dateTimePicker'=>true])
    @endif
@else

    @if(($configPartial['typeManager'] === 'managerRepair'))
        @include('partials.angular.mangerResourcesCss',[
            "uiGrid"=>true,
            "toogle"=>true,
            "s2Angular"=>true,
      ])
    @elseif(($configPartial['typeManager'] === 'managerPointOfSale'))
        @include('partials.angular.mangerResourcesCss',[
            "uiGrid"=>true,
            "toogle"=>true,
            "s2Angular"=>true,
      ])

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'plugins/printjs/demo/PrintArea.css':'plugins/printjs/demo/PrintArea.css'))}}">
    @elseif(($configPartial['typeManager'] === 'managerInvoiceSale'))
        @include('partials.angular.mangerResourcesCss',[
            "uiGrid"=>true,
            "toogle"=>true,
            "s2Angular"=>true,
      ])
        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'plugins/ladda/css/ladda.min.css':'plugins/ladda/css/ladda.min.css'))}}">

        <link rel="stylesheet"
              href="{{ asset($resourcePathServer.(env('APP_IS_SERVER')?'plugins/printjs/demo/PrintArea.css':'plugins/printjs/demo/PrintArea.css'))}}">

    @endif
@endif
@if($configPartial['typeManager'] === 'managerOrderPaymentsManager')
    @include('partials.plugins.resourcesCss',['bootstrapColorpicker'=>true])
@endif
<style>
    .colorpicker.dropdown-menu {
        z-index: 35000 !important;
    }

    .fade:not(.show) {
        opacity: 1 !important;
    }

    .tooltip[x-placement^=top] .tooltip-arrow:before, .tooltip .tooltip-arrow:before {
        top: 0;
        border-width: .4rem .4rem 0;
        border-top-color: #000;
    }

    ​
    .tooltip .tooltip-arrow:before {
        position: absolute;
        content: "";
        border-color: transparent;
        border-style: solid;
    }

    .content-description__information--image {
        position: relative;
    }

    .content-description__information--quantity {
        position: absolute;
        top: 75%;
    }
</style>
<style>

    .manager-contact-msg a {

        position: fixed;
        color: rgb(255, 255, 255);
        right: 0%;
        top: 65%;
        margin-top: -50px;
        z-index: 5000 !important;
    }


    .manager-contact-msg a img {
        z-index: 11;
        position: absolute;
        right: 0;
        top: 0;
        width: 60px;
    }

    .manager-contact-msg a p {
        width: 0;
        height: 36px;
        overflow: hidden;
    }

    .manager-contact-msg a:hover p {
        background: #55535ab8;
        border-radius: 5px 0 0 5px;
        width: 180px;
        padding: 8px;
        color: #fff;
        position: absolute;
        z-index: 10;
        right: 26px;
        top: 11px;
        font-family: Helvetica, Arial, sans-serif;
        -webkit-transition: width 1s linear;
        transition: width 0.5s linear;
    }

    #map-preview {
        height: 400px;
        width: 100%;
        position: relative;
    }

    .slider {
        width: 90%;
        margin: 100px auto !important;
    }

    .slick-slide {
        margin: 0px 20px !important;
    }

    .slick-slide img {
        width: 100% !important;
    }

    .slick-prev:before,
    .slick-next:before {
        color: black !important;
    }


    .slick-slide {
        transition: all ease-in-out .3s;
        opacity: .2 !important;
    }

    .slick-active {
        opacity: .5 !important;
    }

    .slick-current {
        opacity: 1 !important;
    }

    .content-wrapper-card {
        position: relative;
    }

    .content-wrapper-card__title {
        position: absolute;
        top: 56%;
        font-size: 9px;
    }

    .content-wrapper-card__description {
        position: absolute;
        top: 78%;
        font-size: 9px;
    }

    .nav-tabs li.active {
        background-color: #007bff;
    }

    .nav-tabs > li.active > a {
        color: #f0f3f5;
    }

    .nav-tabs li a:hover {
        border-color: #e9ecef #e9ecef #dee2e6 !important;
    }
</style>


@if ($configPartial['typeManager'] === 'managerHumanResourcesEmployeeProfile')
    <link rel="stylesheet"
          href="{{ asset($resourcePathServer . (env('APP_IS_SERVER') ? 'assets/libs/summernote/summernoteServer.min.css' : 'assets/libs/summernote/summernote.min.css')) }}">
@endif
