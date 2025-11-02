<!--BUSINESS-MANAGER-TEMPLATE-ROOT--ORDERS-->
<?php


$utilManagerUser = new \App\Utils\UtilUser;
$user = Auth::user();

$dataManagerActions = array(
    array(
        "title" => "Ver Pedido",
        "data-placement" => "top",
        "i-class" => "fas fa-eye",
        "managerType" => "viewEntity",
        "isUrl" => false,
        "action" => 'orderPaymentsManager/admin',
    ),
    array(
        "title" => "Administrar Pedido",
        "data-placement" => "top",
        "i-class" => "fas fa-check-double",
        "managerType" => "managerEntity",
        "isUrl" => false,
        "action" => 'orderPaymentsManager/changeStateBankOrder',
    ),
    array(
        "title" => "Verificar Deposito",
        "data-placement" => "top",
        "i-class" => "fas fa-clipboard-check",
        "managerType" => "managerEntityBank",
        "isUrl" => false,
        "action" => 'orderPaymentsManager/changeStateBankOrder',
    )

);
$dataManagerProcessActions = array(
    array(
        "title" => "Configuracion de Tienda",
        "data-placement" => "top",
        "i-class" => "fas fa-pencil-alt",
        "managerType" => "updateEntity",
        "action" => 'businessByInventoryManagement/admin',
        'type' => 'configurationPointOfSale',
    ),
    array(
        "title" => "Configuracion de Tienda",
        "data-placement" => "top",
        "i-class" => "fas fa-pencil-alt",
        "managerType" => "updateEntity",
        "action" => 'businessByInventoryManagementSubcategory/getAdmin',
        'type' => 'configurationSubcategories',
    ),


);
$buttonsManagements = [


];

foreach ($dataManagerActions as $key => $value) {
    if ($utilManagerUser->allowActionByUser(['actionCurrent' => $value['action'], 'user' => $user])) {
        array_push($buttonsManagements, $value);
    }
}
$buttonsProcess = [


];
foreach ($dataManagerProcessActions as $key => $value) {
    if ($utilManagerUser->allowActionByUser(['actionCurrent' => $value['action'], 'user' => $user])) {
        array_push($buttonsProcess, $value);
    }
}
?>


<script id="buttons-manager-admin">
    var $buttonsManagements = <?php echo json_encode($buttonsManagements); ?>;

    var $buttonsProcess = <?php echo json_encode($buttonsProcess); ?>;

</script>

<script type='text/x-template' id='order-payments-manager-template'>
    <div>

        <div class='content-component'>


            <div v-if="configModalDeliverOrder.viewAllow">
                <deliver-order-component
                    ref="refDeliverOrder"
                    :params="configModalDeliverOrder"
                >
                </deliver-order-component>
            </div>
            <div v-if="configModalViewOrder.viewAllow">
                <view-order-component
                    ref="refViewOrder"
                    :params="configModalViewOrder"
                >
                </view-order-component>
            </div>
            <div v-if="configModalBankReviewOrder.viewAllow">
                <bank-review-order-component
                    ref="refBankReviewOrder"
                    :params="configModalBankReviewOrder"
                >
                </bank-review-order-component>
            </div>
            <div v-if="configModalBusinessByInventoryManagement.viewAllow">
                <business-by-inventory-management-component
                    ref="refBusinessByInventoryManagement"
                    :params="configModalBusinessByInventoryManagement"
                >
                </business-by-inventory-management-component>
            </div>
            <div v-if="configModalBusinessByInventoryManagementSubcategory.viewAllow">
                <business-by-inventory-management-subcategory-component
                    ref="refBusinessByInventoryManagementSubcategory"
                    :params="configModalBusinessByInventoryManagementSubcategory"
                >
                </business-by-inventory-management-subcategory-component>
            </div>
            <b-container class="container-manager-buttons-form">
                <div class="content-row-manager-buttons-form">
                    <button type="button" class="btn  btn-info"
                            v-if="viewProcessButton({type:'configurationPointOfSale'})"
                            v-on:click="_managementShopInventoryConfigDesign()">
                        Configuracion de Tienda
                    </button>
                    <button type="button" class="btn  btn-info"
                            v-if="viewProcessButton({type:'configurationSubcategories'})"
                            v-on:click="_managementShopInventorySubcategory()">
                        Configuracion Subcategorias
                    </button>
                </div>
                <div class="content-row-manager-buttons">
                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" ng-if="managerMenuConfig.view">
                            <div v-for="(menu, key) in managerMenuConfig.menuCurrent" class="inline-data">
                                <a v-if="menu.isUrl"
                                   v-bind:href="menu.url+menu.rowId"
                                   v-init-tool-tip
                                   v-bind:id="'a-menu-'+menu.rowId"
                                   class="btn btn-xs content-manager-buttons-grid__a hola" data-toggle="tooltip"
                                   data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                    <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                                </a>
                                <a v-else
                                   v-init-tool-tip
                                   v-bind:id="'a-menu-'+menu.rowId"
                                   v-on:click="_managerMenuGrid(key, menu)"
                                   class="btn btn-xs content-manager-buttons-grid__a " data-toggle="tooltip"
                                   data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                    <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form__label ">Tipo de Pago</label>
                            <div class="content">
                                <select
                                    v-model.trim="filtersGrid.type_payment_customer"
                                    id="manager_state"
                                    name="type_payment_customer"
                                    class="form-control m-input"
                                    @change="_setValueForm('type_payment_customer')"
                                >
                                    <option v-for="(row,index) in type_payment_customer_data"
                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4" v-if="filtersGrid.type_payment_customer>-1">
                        <div class="form-group">
                            <label class="form__label ">Estado de Envio</label>
                            <div class="content">
                                <select
                                    v-model.trim="filtersGrid.manager_state"
                                    id="manager_state"
                                    name="manager_state"
                                    class="form-control m-input"
                                    @change="_setValueForm('manager_state')"
                                >
                                    <option v-for="(row,index) in manager_state_data"
                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="order-payments-manager-grid"
                           class=""

                    >
                        <thead>
                        <tr>
                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                            <th data-column-id="description" data-formatter="description">Descripción</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>


        </div>
    </div>
</script>

