<?php
$params_data = array();

$typeOfProofData = TipoComprobante::model()->getListTypeBouncher($params_data)

?>
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
<script type="text/javascript">

    var $typeOfProofData = <?php echo json_encode($typeOfProofData); ?>;

</script>
<div id="content-filters">

    <div class="row">
        <div class="col-md-2">
            <select id="select-stateData" ng-change="resetGridAdmin();" ui-select2="stateDataOptions"
                    ng-model="modelFilters.stateData" data-placeholder="Pick a number">
                <option ng-repeat="(key, value) in stateData" value="{{value.id}}">

                    {{value.value}}
                </option>
            </select>
        </div>
        <div class="col-md-4">
            <select
                    id="select-typeOfProofData" ng-change="resetGridAdmin();" ui-select2="typeOfProofDataOptions"
                    ng-model="modelFilters.typeOfProofData" data-placeholder="Pick a number">
                <option ng-repeat="(key, value) in typeOfProofData" value="{{value.id}}">

                    {{value.value}}
                </option>
            </select>
        </div>
        <div class="col-md-3">

            <p class="input-group">
                <input type="text" class="form-control frm-search" uib-datepicker-popup ng-model="modelFilters.dateInit"
                       is-open="popupFiltroFInicio.opened" ng-click="FiltroFInicio()" ng-change="resetGridAdmin();"
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
                <input type="text" class="form-control frm-search" ng-click="FiltroFFin()" ng-change="resetGridAdmin();"
                       uib-datepicker-popup placeholder="Fecha fin" ng-model="modelFilters.dateEnd"
                       is-open="popupFiltroFFin.opened" datepicker-options="dateOptions" ng-required="true"
                       close-text="Close"/>
                <span class="input-group-btn">
                                        <button type="button" class="btn btn-default" ng-click="FiltroFFin()">
                                            <i class="glyphicon glyphicon-calendar"></i></button>
                                    </span>
            </p>
        </div>
    </div>

</div>
            