<div class="row">
    <div class="col-md-12">
        <div class="form-group" ng-class="{ 'has-error':_getClassFormGroup(fieldsManager[2],formManager)}">
            <label class="col-md-12 control-label   <?php echo "{{fieldsManager[2].required?'required':''}}"?>">
                <?php echo ' {{fieldsManager[2].label}} '?>
                <span ng-show="fieldsManager[2].required" class='required'>*</span>
            </label>
            <div class="col-md-12">

                <input

                    ng-disabled="true"
                    class="form-control"


                    <?php echo 'name="{{fieldsManager[2].name}}"'?>
                    placeholder="Ingrese la Información."
                    <?php echo ' type="{{fieldsManager[2].type}}"'?>
                    ng-model="dataManagerModel[fieldsManager[2].id]"

                <?php echo ' ng-required="{{fieldsManager[2].required}}"'?>

                />

                <div class="help-block error"
                     ng-show="_viewContainer(formManager,fieldsManager[2].name)">
                                <span ng-show="_viewErrorsElementForm(formManager,fieldsManager[2].name)">
                                    <?php echo '  {{_getMsjErrorsElementForm(formManager,fieldsManager[2].name)}}'?>
                                </span>
                </div>

            </div>
        </div>
    </div>


</div>
