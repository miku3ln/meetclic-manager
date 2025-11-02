<style>
    .select2-container {
        width: 100%;
    }
</style>
<form name="formManagerStep2">


    <input
        class="form-control"
        <?php echo 'name="{{fieldsManagerStep2[0].name}}"'?>
        type="hidden"
        ng-model="dataManagerModelStep2[fieldsManagerStep2[0].id]"/>
    <div class="row">

        <div class="col col-md-6">
            <div class="form-group"
                 ng-class=" { 'has-error':_getClassFormGroup(fieldsManagerStep2[5],formManagerStep2)}">
                <label
                    class="col-md-12 control-label   <?php echo "{{fieldsManagerStep2[5].required?'required':''}}"?> ">

                    <?php echo ' {{fieldsManagerStep2[5].label}}'?>
                    <span ng-show="fieldsManagerStep2[5].required" class='required'>*</span>
                </label>
                <div class="col-md-12">

                    <input

                        ui-select2="select2OptionsPayment"
                        class="select2--modal"

                        <?php echo ' name="{{fieldsManagerStep2[5].name}}"'?>
                        placeholder="Ingrese la Información."
                        type="hidden"
                        ng-model="dataManagerModelStep2[fieldsManagerStep2[5].id]"

                    <?php echo '    ng-required="{{fieldsManagerStep2[5].required}}"'?>

                    />

                    <div class="help-block error"
                         ng-show="_viewContainer(formManagerStep2,fieldsManagerStep2[5].name)">
                                <span ng-show="_viewErrorsElementForm(formManagerStep2,fieldsManagerStep2[5].name)">
                                     <?php echo '{{_getMsjErrorsElementForm(formManagerStep2,fieldsManagerStep2[5].name)}}'?>

                                </span>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <div class="row">

        <div class="col col-md-6">
            <div class="form-group"
                 ng-class=" { 'has-error':_getClassFormGroup(fieldsManagerStep2[3],formManagerStep2)}">
                <label
                    class="col-md-12 control-label    <?php echo "{{fieldsManagerStep2[3].required?'required':''}}"?>">

                    <?php echo '{{fieldsManagerStep2[3].label}}'?>
                    <span ng-show="fieldsManagerStep2[3].required" class='required'>*</span>
                </label>
                <div class="col-md-12">

                    <input

                        ui-select2="select2OptionsTypePayment"
                        class="select2--modal"

                        <?php echo 'name="{{fieldsManagerStep2[3].name}}"'?>

                        placeholder="Ingrese la Información."
                        type="hidden"
                        ng-model="dataManagerModelStep2[fieldsManagerStep2[3].id]"

                    <?php echo ' ng-required="{{fieldsManagerStep2[3].required}}"'?>

                    />

                    <div class="help-block error"
                         ng-show="_viewContainer(formManagerStep2,fieldsManagerStep2[3].name)">
                                <span ng-show="_viewErrorsElementForm(formManagerStep2,fieldsManagerStep2[3].name)">

                                                     <?php echo '{{_getMsjErrorsElementForm(formManagerStep2,fieldsManagerStep2[3].name)}}'?>


                                </span>
                    </div>

                </div>
            </div>

        </div>
        <div class="col col-md-6">
            <div class="form-group"
                 ng-class=" { 'has-error':_getClassFormGroup(fieldsManagerStep2[4],formManagerStep2)}">
                <label
                    class="col-md-12 control-label   <?php echo "{{fieldsManagerStep2[4].required?'required':''}}"?>">

                    <?php echo ' {{fieldsManagerStep2[4].label}}'?>
                    <span ng-show="fieldsManagerStep2[4].required" class='required'>*</span>
                </label>
                <div class="col-md-12">

                    <input

                        ui-select2="select2OptionsAccountants"
                        class="select2--modal"

                        <?php echo '  name="{{fieldsManagerStep2[4].name}}"'?>


                        placeholder="Ingrese la Información."
                        type="hidden"
                        ng-model="dataManagerModelStep2[fieldsManagerStep2[4].id]"

                    <?php echo '    ng-required="{{fieldsManagerStep2[4].required}}"'?>
                    />

                    <div class="help-block error"
                         ng-show="_viewContainer(formManagerStep2,fieldsManagerStep2[4].name)">
                                <span ng-show="_viewErrorsElementForm(formManagerStep2,fieldsManagerStep2[4].name)">
                                     <?php echo '{{_getMsjErrorsElementForm(formManagerStep2,fieldsManagerStep2[4].name)}}'?>

                                </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="row">

        <div class="col col-md-6">
            <div class="form-group"
                 ng-class=" { 'has-error':_getClassFormGroup(fieldsManagerStep2[1],formManagerStep2)}">
                <label
                    class="col-md-12 control-label   <?php echo "{{fieldsManagerStep2[1].required?'required':''}}"?>">

                    <?php echo ' {{fieldsManagerStep2[1].label}}'?>
                    <span ng-show="fieldsManagerStep2[1].required" class='required'>*</span>
                </label>
                <div class="col-md-12">

                    <input

                        <?php echo 'name="{{fieldsManagerStep2[1].name}}"'?>

                        placeholder="Ingrese la Información."
                        type="date"
                        ng-model="dataManagerModelStep2[fieldsManagerStep2[1].id]"
                    <?php echo 'ng-required="{{fieldsManagerStep2[1].required}}"'?>


                    />

                    <div class="help-block error"
                         ng-show="_viewContainer(formManagerStep2,fieldsManagerStep2[1].name)">
                                <span ng-show="_viewErrorsElementForm(formManagerStep2,fieldsManagerStep2[1].name)">


                                    <?php echo '   {{_getMsjErrorsElementForm(formManagerStep2,fieldsManagerStep2[1].name)}}'?>

                                </span>
                    </div>

                </div>
            </div>

        </div>
        <div class="col col-md-6">
            <div class="form-group"
                 ng-class=" { 'has-error':_getClassFormGroup(fieldsManagerStep2[2],formManagerStep2)}">
                <label
                    class="col-md-12 control-label    <?php echo " {{fieldsManagerStep2[2].required==true?'required':''}}"?>">
                    <?php echo '  {{fieldsManagerStep2[2].label}}'?>


                    <span ng-show="fieldsManagerStep2[2].required==1" class='required'>*</span>
                </label>
                <div class="col-md-12">

                    <input

                        <?php echo ' name="{{fieldsManagerStep2[2].name}}"'?>

                        placeholder="Ingrese la Información."
                        ng-model="dataManagerModelStep2[fieldsManagerStep2[2].id]"

                    <?php echo '    ng-required="{{fieldsManagerStep2[2].required}}"'?>


                    />

                    <div class="help-block error"
                         ng-show="_viewContainer(formManagerStep2,fieldsManagerStep2[2].name)">
                                <span ng-show="_viewErrorsElementForm(formManagerStep2,fieldsManagerStep2[2].name)">

                                    <?php echo '    {{_getMsjErrorsElementForm(formManagerStep2,fieldsManagerStep2[2].name)}}'?>

                                </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <button

        id="btn-manager-step2"
        data-style='zoom-in'
        data-size="s"
        class="btn btn-primary ladda-button"
        type="button" ng-disabled="!formManagerStep2.$valid" ng-click="_handleManagerStep2()">

        <?php echo ' {{lblModalSave}}'?>
    </button>
</form>
<div class="row">
    <div class="col col-md-12">
        <table id="indebtedness-breakdown-collection-grid"
               class="">
            <thead>
            <tr>
                <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                <th data-column-id="pago_cantidad" data-formatter="pago_cantidad">Valor</th>
                <th data-column-id="fecha_pago" data-formatter="fecha_pago">Fecha</th>
                <th data-column-id="typos_de_pagos"
                    data-formatter="typos_de_pagos">Tipo de Pago
                </th>
                <th data-column-id="contabilidad_cuenta" data-formatter="contabilidad_cuenta">Cuenta</th>
                <th data-column-id="nota" data-formatter="nota">Nota</th>


            </tr>
            </thead>
        </table>
    </div>

</div>
