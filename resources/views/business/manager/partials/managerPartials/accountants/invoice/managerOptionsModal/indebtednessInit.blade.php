<input
    class="form-control"

    <?php echo '   name="{{fieldsManager[0].name}}"'?>
    type="hidden"
    ng-model="dataManagerModel[fieldsManager[0].id]"/>
<div class="row">
    <div class="col-md-6" ng-show="!initManagerSteps">
        <div class="form-group" ng-class=" { 'has-error':_getClassFormGroup(fieldsManager[3],formManager)}">
            <label class="col-md-12 control-label  <?php echo "{{fieldsManager[3].required?'required':''}}"?>">

                <?php echo ' {{fieldsManager[3].label}}'?>
                <span ng-show="fieldsManager[3].required" class='required'>*</span>
            </label>
            <div class="col-md-12">

                <toggle class="m"

                        <?php echo ' name="{{fieldsManager[3].name}}"'?>

                        ng-change="_generateDataPayments()"
                        ng-model="dataManagerModel[fieldsManager[3].id]"
                        on="<i class='fa fa-play'></i> Manual" off="<i class='fa fa-pause'></i> Automático">

                </toggle>
                <div class="help-block error"
                     ng-show="_viewContainer(formManager,fieldsManager[3].name)">
                                <span ng-show="_viewErrorsElementForm(formManager,fieldsManager[3].name)">


                                    <?php echo '  {{_getMsjErrorsElementForm(formManager,fieldsManager[3].name)}}'?>

                                </span>
                </div>

            </div>
        </div>
    </div>
    <div ng-class="{'col-md-6':initManagerSteps==false,'col-md-12':initManagerSteps==true}">


        <div class="form-group" ng-class=" { 'has-error':_getClassFormGroup(fieldsManager[1],formManager)}">
            <label class="col-md-12 control-label  <?php echo "{{fieldsManager[1].required?'required':''}}"?>">

                <?php echo '    {{fieldsManager[1].label}}'?>

                <span ng-show="fieldsManager[1].required" class='required'>*</span>
            </label>
            <div class="col-md-12">

                <input
                    ng-disabled="initManagerSteps"
                    ng-change="_generateDataPayments()"
                    class="form-control"

                    <?php echo ' name="{{fieldsManager[1].name}}"'?>
                    placeholder="Ingrese la Información."

                    <?php echo '  type="{{fieldsManager[1].type}}"'?>
                    ng-model="dataManagerModel[fieldsManager[1].id]"


                <?php echo '  ng-required="{{fieldsManager[1].required}}"'?>

                />

                <div class="help-block error"
                     ng-show="_viewContainer(formManager,fieldsManager[1].name)">
                                <span ng-show="_viewErrorsElementForm(formManager,fieldsManager[1].name)">

                                    <?php echo '   {{_getMsjErrorsElementForm(formManager,fieldsManager[1].name)}}'?>

                                </span>
                </div>

            </div>
        </div>
    </div>


</div>

<div class="row">
    <div class="col-md-6" ng-show="!initManagerSteps && dataManagerModel[fieldsManager[3].id]">


        <div class="form-group" ng-class=" { 'has-error':_getClassFormGroup(fieldsManager[4],formManager)}">
            <label class="col-md-12 control-label  <?php echo "{{fieldsManager[4].required?'required':''}}"?>">

                <?php echo '      {{fieldsManager[4].label}}'?>


                <span ng-show="fieldsManager[4].required" class='required'>*</span>
            </label>
            <div class="col-md-12">

                <input

                    ng-change="_generateDataPayments()"
                    class="form-control"

                    <?php echo '    name="{{fieldsManager[4].name}}"'?>
                    placeholder="Ingrese la Información."

                    <?php echo '  type="{{fieldsManager[4].type}}"'?>
                    ng-model="dataManagerModel[fieldsManager[4].id]"
                <?php echo '   ng-required="{{fieldsManager[4].required}}"'?>

                />
                <div class="help-block error"
                     ng-show="_viewContainer(formManager,fieldsManager[4].name)">
                                <span ng-show="_viewErrorsElementForm(formManager,fieldsManager[4].name)">

                                    <?php echo ' {{_getMsjErrorsElementForm(formManager,fieldsManager[4].name)}}'?>

                                </span>
                </div>

            </div>
        </div>
    </div>
</div>
