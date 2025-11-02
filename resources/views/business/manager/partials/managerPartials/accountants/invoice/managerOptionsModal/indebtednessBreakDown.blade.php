<div class="row">
    <div class="total">
        Total: <span class="total-label badge "
                     ng-class="{'badge-success':!(totalIndebtedness <= 0 || totalIndebtedness < $scope.dataManagerModel[$scope.fieldsManager[2].id]),'badge-warning':(totalIndebtedness <= 0 || totalIndebtedness < $scope.dataManagerModel[$scope.fieldsManager[2].id])}">
             <?php echo ' {{getValueCustomer(totalIndebtedness)}}'?>
        </span>
    </div>
    <div class="col col-md-12">
        <table id="indebtedness-breakdown-grid"
               class="">
            <thead>
            <tr>
                <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                <th data-column-id="payment_value" data-formatter="pago_cantidad">Valor</th>
                <th data-column-id="fecha_pago_acuerdo" data-formatter="fecha_pago_acuerdo">Fecha</th>
                <th data-column-id="state_payment" data-formatter="state">Estado</th>

            </tr>
            </thead>
        </table>
    </div>

</div>
