<style>
    .modal-header {
        border-bottom: 0px solid #ce5e5e !important;
        background: #fff !important;
        color: #1d1616;
    }

    .modal-title {
        margin-left: 5% !important;
    }

    .tabbable.tabs-below {
        background: none !important;
    }

    .content-loading-modal {
        width: 100%;
        height: 238px;
    }

    .content-loading-modal h1 {
        text-align: center;
        margin-top: 11%;
        margin-bottom: 11%;
    }

    tr.warning-state {
        border-bottom: 3px solid rgb(221, 44, 0);
    }

    tr.success-state {
        border-bottom: 3px solid rgb(92, 198, 102);
    }

    input.form-group.manager-pago_cantidad {
        color: #1b1919 !important;
    }
</style>

<style>
    .toggle.ios, .toggle-on.ios, .toggle-off.ios {
        border-radius: 20px;
    }

    .toggle.ios .toggle-handle {
        border-radius: 20px;
    }

    .toggle {
        width: 92px !important;
        height: 34px !important;
    }
</style>

<style>
    .toggle.android {
        border-radius: 0px;
    }

    .toggle.android .toggle-handle {
        border-radius: 0px;
    }
</style>

<style>
    .billing-details, .billing-details-header, .billing-retention, .billing-information, .invoice-information {
        width: 100% !important;
    }

    table.billing-information {
        border: 1px solid #ddd;
        margin-bottom: 9px;
    }

    th.billing-information-th-logo {
        padding-top: 3%;
        text-align: center;
        padding-bottom: 3%;
        border-right: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

    table.invoice-information-customer {
        width: 100%;
        margin-top: 2%;
        margin-bottom: 2%;
    }

    table.billing-retention {
        height: 90px;
        border: 1px solid #ddd;
        margin-bottom: 9px;
    }

    span.billing-retention-th__value {
        padding-left: 18%;
    }

    table.billing-details-header {
        border: 1px solid #ddd;
        margin-bottom: 9px;
        height: 49px;
    }

    table.billing-details-header tr th {
        text-align: center;
        border: 1px solid #ddd;

        margin-bottom: 9px;
    }

    table.billing-details {
        border: 1px solid #ddd;
        margin-bottom: 9px;
        height: 49px;
    }

    table.billing-details tr th {
        text-align: center;
        border: 1px solid #ddd;
        margin-bottom: 9px;
    }

    table.billing-details-footer {
        width: 100%;
    }

    .results-left, .results-right {
        border: 1px solid #ddd;
    }

    th.billing-details-footer-th.payment-types th {
        border: 1px solid #ddd;
    }

    th.billing-details-footer-th.payment-types {
        width: 61%;
    }

    table.billing-details-header-retentions {
        width: 100%;
        margin-bottom: 9px;
    }

    table.billing-details-header-retentions-details {
        width: 100%;
        margin-bottom: 11px;
    }

    table.billing-details-header-payments {
        width: 100%;
    }

    tr.billing-details-header-retentions-tr {
        cursor: pointer;
    }

</style>
<script type="text/ng-template" id="indebtednessModal.html">
    <div ng-show="!loadData" class="content-loading-modal">

        <h1>
            Cargando....
        </h1>
    </div>
    <div ng-show="loadData">


        <div class="modal-header modal-header--custom">
            <h3 class="modal-title">
                <div ng-bind-html="htmlTitle"></div>
            </h3>
        </div>
        <div class="modal-body">


            <div class="tab-content" ng-show="!btn_loading">
                <div class="tab-pane active" id="manager-modal-tab">

                    <div class="tabbable tabs-below">
                        <div class="tab-content padding-10">
                            <div class="tab-pane " ng-class="{'active': (menuTabs[0].active==true)}" id="report-1">
                                <form name="formManager">
                                    @include( $partials . '.managerPartials.accountants.invoice.managerOptionsModal.indebtedness',['configPartial'=>$configPartial])
                                    @include( $partials . '.managerPartials.accountants.invoice.managerOptionsModal.indebtednessInit',['configPartial'=>$configPartial])
                                    @include( $partials . '.managerPartials.accountants.invoice.managerOptionsModal.indebtednessBreakDown',['configPartial'=>$configPartial])

                                    <button
                                        ng-show="!initManagerSteps"
                                        id="btn-manager-step1"
                                        data-style='zoom-in'
                                        data-size="s"
                                        class="btn btn-primary ladda-button"
                                        type="button" ng-disabled="!_validateManager()" ng-click="_handleManager()">
                                       <?php echo '{{lblModalSave}} '?>
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane" id="report-2" ng-class="{'active': (menuTabs[1].active==true)}"
                                 ng-show="initManagerSteps">




                                    @include( $partials . '.managerPartials.accountants.invoice.managerOptionsModal.indebtednessBreakDownCollectionPayments',['configPartial'=>$configPartial])

                            </div>

                        </div>
                        <ul class="nav nav-tabs">
                            <li ng-class=" {'active': (menuTabs[0].active==true)}">
                                <a data-toggle="tab" href="#report-1"
                                   ng-click="_viewTab({key:0})">  <?php echo '{{menuTabs[0].text}}'?></a>
                            </li>
                            <li ng-class="{'active': (menuTabs[1].active==true)}" ng-show="initManagerSteps">
                                <a data-toggle="tab" href="#report-2"
                                   ng-click="_viewTab({key:1})">  <?php echo '{{menuTabs[1].text}}'?></a>
                            </li>

                        </ul>
                    </div>

                </div>

            </div>

        </div>
        <div class="modal-footer">

        </div>
    </div>
</script>

<script type="text/ng-template" id="viewBillingModal.html">
    <div ng-show="!loadData" class="content-loading-modal">

        <h1>
            Cargando....
        </h1>
    </div>
    <div ng-show="loadData">


        <div class="modal-header modal-header--custom">
            <h3 class="modal-title">
                <div ng-bind-html="htmlTitle"></div>
            </h3>
        </div>
        <div class="modal-body">
            <div class="content-manager-view-html" ng-bind-html="managerViewHtml"></div>

        </div>
        <div class="modal-footer">

        </div>
    </div>
</script>

<script type="text/ng-template" id="annulmentBillingModal.html">
    <div ng-show="!loadData" class="content-loading-modal">

        <h1>
            Cargando....
        </h1>
    </div>
    <div ng-show="loadData">


        <div class="modal-header modal-header--custom">
            <h3 class="modal-title">
                <div ng-bind-html="htmlTitle"></div>
            </h3>
        </div>
        <div class="modal-body">
            <div class="content-manager-view-html" ng-bind-html="managerViewHtml"></div>

        </div>
        <div class="modal-footer">
            <button
                id="btn-manager-step1"
                data-style='zoom-in'
                data-size="s"
                class="btn btn-primary ladda-button"
                type="button" ng-click="_saveManager()">
                <?php echo ' {{lblModalSave}}'?>
            </button>
            <button

                id="btn-manager-dismiss"
                data-style='zoom-in'
                data-size="s"
                class="btn btn-danger ladda-button"
                type="button" ng-click="_dismiss()">
                <?php echo '  {{lblModalDismiss}}'?>
            </button>
        </div>
    </div>
</script>
