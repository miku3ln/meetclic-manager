@include( $partials . '.wizards.sales.invoice.assets.js.modal',['configPartial'=>$configPartial])


<style>
    .nav-tabs {
        border-bottom: 1px solid #ddd
    }

    .nav-tabs > li {
        float: left;
        margin-bottom: -1px
    }

    .nav-tabs > li > a {
        margin-right: 2px;
        line-height: 1.42857143;
        border: 1px solid transparent;
        border-radius: 2px 2px 0 0
    }

    .nav-tabs > li > a:hover {
        border-color: #eee #eee #ddd
    }

    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
        color: #555;
        background-color: #fff;
        border: 1px solid #ddd;
        border-bottom-color: transparent;
        cursor: default
    }

    .nav-tabs.nav-justified {
        width: 100%;
        border-bottom: 0
    }

    .nav-tabs.nav-justified > li {
        float: none
    }

    .nav-tabs.nav-justified > li > a {
        text-align: center;
        margin-bottom: 5px
    }

    .nav-tabs.nav-justified > .dropdown .dropdown-menu {
        top: auto;
        left: auto
    }

    @media (min-width: 768px) {
        .nav-tabs.nav-justified > li {
            display: table-cell;
            width: 1%
        }

        .nav-tabs.nav-justified > li > a {
            margin-bottom: 0
        }
    }

    .nav-tabs.nav-justified > li > a {
        margin-right: 0;
        border-radius: 2px
    }

    .nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
        border: 1px solid #ddd
    }

    @media (min-width: 768px) {
        .nav-tabs.nav-justified > li > a {
            border-bottom: 1px solid #ddd;
            border-radius: 2px 2px 0 0
        }

        .nav-tabs.nav-justified > .active > a, .nav-tabs.nav-justified > .active > a:focus, .nav-tabs.nav-justified > .active > a:hover {
            border-bottom-color: #fff
        }
    }

    .nav-pills > li {
        float: left
    }

    .nav-pills > li > a {
        border-radius: 2px
    }

    .nav-pills > li + li {
        margin-left: 2px
    }

    .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
        color: #fff;
        background-color: #3276b1
    }

    .nav-stacked > li {
        float: none
    }

    .nav-stacked > li + li {
        margin-top: 2px;
        margin-left: 0
    }

    .nav-justified {
        width: 100%
    }

    .nav-justified > li {
        float: none
    }

    .nav-justified > li > a {
        text-align: center;
        margin-bottom: 5px
    }

    .nav-justified > .dropdown .dropdown-menu {
        top: auto;
        left: auto
    }

    @media (min-width: 768px) {
        .nav-justified > li {
            display: table-cell;
            width: 1%
        }

        .nav-justified > li > a {
            margin-bottom: 0
        }
    }

    .nav-tabs-justified {
        border-bottom: 0
    }

    .nav-tabs-justified > li > a {
        margin-right: 0;
        border-radius: 2px
    }

    .nav-tabs-justified > .active > a, .nav-tabs-justified > .active > a:focus, .nav-tabs-justified > .active > a:hover {
        border: 1px solid #ddd
    }

    @media (min-width: 768px) {
        .nav-tabs-justified > li > a {
            border-bottom: 1px solid #ddd;
            border-radius: 2px 2px 0 0
        }

        .nav-tabs-justified > .active > a, .nav-tabs-justified > .active > a:focus, .nav-tabs-justified > .active > a:hover {
            border-bottom-color: #fff
        }
    }

    .tab-content > .tab-pane {
        display: none
    }

    .tab-content > .active {
        display: block
    }

    .nav-tabs .dropdown-menu {
        margin-top: -1px;
        border-top-right-radius: 0;
        border-top-left-radius: 0
    }

    .nav-tabs > li > a .badge {
        font-size: 11px;
        padding: 3px 5px;
        opacity: .5;
        margin-left: 5px;
        min-width: 17px;
        font-weight: 400
    }

    .nav-tabs > li > a > .fa {
        opacity: .5
    }

    .tabs-left .nav-tabs > li > a .badge {
        margin-right: 5px;
        margin-left: 0
    }

    .nav-tabs > li > a .label {
        display: inline-block;
        font-size: 11px;
        margin-left: 5px;
        opacity: .5
    }

    .nav-tabs > li.active > a .badge, .nav-tabs > li.active > a .label, .nav-tabs > li.active > a > .fa {
        opacity: 1
    }

    .nav-tabs > li > a {
        border-radius: 0;
        color: #333
    }

    .nav-tabs > li.active > a {
        -webkit-box-shadow: 0 -2px 0 #57889c;
        -moz-box-shadow: 0 -2px 0 #57889c;
        box-shadow: 0 -2px 0 #57889c;
        border-top-width: 0 !important;
        margin-top: 1px !important;
        font-weight: 700
    }

    .tabs-left .nav-tabs > li.active > a {
        -webkit-box-shadow: -2px 0 0 #57889c;
        -moz-box-shadow: -2px 0 0 #57889c;
        box-shadow: -2px 0 0 #57889c;
        border-top-width: 1px !important;
        border-left: none !important;
        margin-left: 1px !important
    }

    .tabs-left .nav-pills > li.active > a {
        border: none !important;
        box-shadow: none !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important
    }

    .tabs-right .nav-tabs > li.active > a {
        -webkit-box-shadow: 2px 0 0 #57889c;
        -moz-box-shadow: 2px 0 0 #57889c;
        box-shadow: 2px 0 0 #57889c;
        border-top-width: 1px !important;
        border-right: none !important;
        margin-right: 1px !important
    }

    .tabs-below .nav-tabs > li.active > a {
        -webkit-box-shadow: 0 2px 0 #57889c;
        -moz-box-shadow: 0 2px 0 #57889c;
        box-shadow: 0 2px 0 #57889c;
        border-bottom-width: 0 !important;
        border-top: none !important;
        margin-top: 0 !important
    }

    .tabs-left > .nav-pills > li, .tabs-left > .nav-tabs > li, .tabs-right > .nav-pills > li, .tabs-right > .nav-tabs > li {
        float: none
    }

    .tabs-left > .nav-pills > li > a, .tabs-left > .nav-tabs > li > a, .tabs-right > .nav-pills > li > a, .tabs-right > .nav-tabs > li > a {
        min-width: 74px;
        margin-right: 0;
        margin-bottom: 3px
    }

    .tabs-left > .nav-pills, .tabs-left > .nav-tabs {
        float: left;
        margin-right: 19px;
        border-right: 1px solid #ddd
    }

    .tabs-left > .nav-pills {
        border-right: none
    }

    .tabs-left > .nav-tabs > li > a {
        margin-right: -1px
    }

    .tabs-left > .nav-tabs > li > a:focus, .tabs-left > .nav-tabs > li > a:hover {
        border-color: #eee #d5d5d5 #eee #eee
    }

    .tabs-left > .nav-tabs .active > a, .tabs-left > .nav-tabs .active > a:focus, .tabs-left > .nav-tabs .active > a:hover {
        border-color: #d5d5d5 transparent #d5d5d5 #ddd;
        *border-right-color: #fff
    }

    .tabs-left > .tab-content {
        margin-left: 109px
    }

    .tabs-right > .nav-tabs {
        float: right;
        margin-left: 19px;
        border-left: 1px solid #ddd
    }

    .tabs-right > .nav-tabs > li > a {
        margin-left: -1px
    }

    .tabs-right > .nav-tabs > li > a:focus, .tabs-right > .nav-tabs > li > a:hover {
        border-color: #eee #eee #eee #ddd
    }

    .tabs-right > .nav-tabs .active > a, .tabs-right > .nav-tabs .active > a:focus, .tabs-right > .nav-tabs .active > a:hover {
        border-color: #ddd #ddd #ddd transparent;
        *border-left-color: #fff
    }

    .tabs-below > .nav-tabs, .tabs-left > .nav-tabs, .tabs-right > .nav-tabs {
        border-bottom: 0
    }

    .pill-content > .pill-pane, .tab-content > .tab-pane {
        display: none
    }

    .pill-content > .active, .tab-content > .active {
        display: block
    }

    .tabs-below > .nav-tabs {
        border-top: 1px solid #ddd
    }

    .tabs-below > .nav-tabs > li {
        margin-top: -1px;
        margin-bottom: 0
    }

    .tabs-below > .nav-tabs > li > a:focus, .tabs-below > .nav-tabs > li > a:hover {
        border-top-color: #ddd;
        border-bottom-color: transparent
    }

    .tabs-below > .nav-tabs > .active > a, .tabs-below > .nav-tabs > .active > a:focus, .tabs-below > .nav-tabs > .active > a:hover {
        border-color: transparent #ddd #ddd
    }

    .nav-tabs.bordered {
        background: #fff;
        border: 1px solid #ddd
    }

    .nav-tabs.bordered > :first-child a {
        border-left-width: 0 !important
    }

    .nav-tabs.bordered + .tab-content {
        border: 1px solid #ddd;
        border-top: none
    }

    .tabs-pull-right.nav-pills > li, .tabs-pull-right.nav-tabs > li {
        float: right
    }

    .tabs-pull-right.nav-pills > li:first-child > a, .tabs-pull-right.nav-tabs > li:first-child > a {
        margin-right: 1px
    }

    .tabs-pull-right.bordered.nav-pills > li:first-child > a, .tabs-pull-right.bordered.nav-tabs > li:first-child > a {
        border-left-width: 1px !important;
        margin-right: 0;
        border-right-width: 0
    }

    span.title-span {
        font-size: 15px;
        margin-bottom: 27px;
        font-weight: 700;
    }

    tr.values-tr {
        height: 10px !important;
    }

</style>

<div class="row" id="content-portlet-gestion">
    <article class="col-sm-12 col-md-12 col-lg-12 sortable-grid">
        <div class="content-gestion">
            <h2 class="title-gestion">
                <strong
                    class="title_left"></strong><i
                    class="title_rigth"> Facturas</i></h2>
            <div id="admin-facturacion">
                <div id="content-gestion-menu">
                    <ul id="menu-dogon-horizontal" ng-repeat="menu in menu_gestion">
                        <li class="menu-drogon-li">
                            <a class="menu-drogon-a" ng-click="_managerRowInvoice(menu.gestion_key)">
                                <i class="<?php echo '{{menu.class}}'?>"></i><span
                                    class="menu-dogon-horizontal-li-span"><?php echo '{{menu.value}}'?></span>
                            </a>
                        </li>

                    </ul>

                </div>
                <style>
                    div#s2id_select-typeOfProofData {
                        width: 100%;
                    }

                    div#s2id_select-stateData {
                        width: 100%;
                    }

                    div#content-filters {
                        margin-bottom: 2%;
                        margin-top: 2%;
                    }
                </style>

                <div id="content-filters">
                    <div class="row">
                        <div class="col-md-2">
                            <select id="select-stateData" ng-change="resetGridAdmin();" ui-select2="stateDataOptions"
                                    ng-model="modelFilters.stateData" data-placeholder="Pick a number">
                                <option ng-repeat="(key, value) in stateData" value=" <?php echo '{{value.id}}'; ?>">

                                    <?php echo '{{value.value}}'; ?>
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select

                                id="select-typeOfProofData" ng-change="resetGridAdmin();"
                                ui-select2="typeOfProofDataOptions"
                                ng-model="modelFilters.typeOfProofData" data-placeholder="Pick a number">
                                <option ng-repeat="(key, value) in typeOfProofData"
                                        value="<?php echo '{{value.id}}'; ?>">

                                    <?php echo '{{value.value}}'; ?>
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">

                            <p class="input-group">
                                <input type="text" class="form-control frm-search" uib-datepicker-popup
                                       ng-model="modelFilters.dateInit"
                                       is-open="popupFiltroFInicio.opened" ng-click="FiltroFInicio()"
                                       ng-change="resetGridAdmin();"
                                       datepicker-options="dateOptions" placeholder="Fecha Inicio" ng-required="true"
                                       close-text="Close"/>
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="FiltroFInicio()">
                                            <i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                            </p>
                        </div>
                        <div class="col-md-3">
                            <!--<label class="col-md-5 control-label" fors="select-">Fecha Fin:<span class="required">*</span></label>-->
                            <p class="input-group">
                                <input type="text" class="form-control frm-search" ng-click="FiltroFFin()"
                                       ng-change="resetGridAdmin();"
                                       uib-datepicker-popup placeholder="Fecha fin" ng-model="modelFilters.dateEnd"
                                       is-open="popupFiltroFFin.opened" datepicker-options="dateOptions"
                                       ng-required="true"
                                       close-text="Close"/>
                                <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="FiltroFFin()">
                                            <i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
                            </p>
                        </div>
                    </div>

                </div>


            </div>


            <div class="custom-scroll table-responsive " id="content-manager-grid" ng-show="managerGetData">
                <table id="facturas-grid"
                       class="">
                    <thead>
                    <tr>
                        <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                        <th data-column-id="description" data-formatter="description">Descripción</th>

                        <th data-column-id="codigo_factura_info" data-formatter="codigo_factura_info"> Documento#</th>
                        <th data-column-id="razon_social" data-formatter="razon_social">Cliente</th>
                        <th data-column-id="fecha_factura" data-formatter="fecha_factura">Fecha Emision</th>
                        <th data-column-id="valor_factura" data-formatter="valor_factura">Total</th>
                        <th data-column-id="btn" data-formatter="estado-formatter"></th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </article>
</div>
