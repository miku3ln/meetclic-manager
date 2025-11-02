<script type="text/ng-template" id="pricesManager.html">
    <div class="modal-header modal-header--custom">
        <h3 class="modal-title">
            <div ng-bind-html="htmlTitle"></div>
        </h3>
    </div>
    <div class="modal-body">
        <form name="formManagerModal">
            <div class="row" ng-if="typeProductBoxUnit">

                <div toggle-switch class="switch-danger"
                     html="true"
                     on-label="Caja"
                     off-label='Unidad'
                     ng-model="modelCurrent.managerTypeContent"
                     name="managerTypeContent"
                     ng-change="_managerTypeContent(modelCurrent.managerTypeContent)">
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <label class=" lbl-gestion-info">
                            Precios *
                        </label>
                    </div>
                </div>
                <div class="row">
                    <!--change-->
                    <div class="col-md-8">
                        <div class="form-group" ng-class="{'has-error': (formManagerModal.managerDataPrice.$error.required && formManagerModal.managerDataPrice.$touched),
                                                                '': !(formManagerModal.managerDataPrice.$error.required && formManagerModal.managerDataPrice.$touched)
                                                        }">
                            <select ng-required="true" ng-model="modelCurrent.managerDataPrice" name="managerDataPrice">
                                <option value="  <?php echo '{{price.value}}';?>" ng-repeat="price in pricesCurrent"

                                >
                                    <?php echo '{{price.text}}';?>
                                </option>
                            </select>
                            <span class="messages"
                                  ng-show="formManagerModal.$submitted || formManagerModal.managerDataPrice.$touched">
                                <span ng-show="formManagerModal.managerDataPrice.$error.required" class="required ">Campo Requerido.</span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row" ng-if="!typeProductBoxUnit">


                <div class="row">
                    <div class="col-md-8">
                        <label class=" lbl-gestion-info">
                            Precios *
                        </label>
                    </div>
                </div>
                <div class="row">
                    <!--change-->
                    <div class="col-md-8">
                        <div class="form-group" ng-class="{'has-error': (formManagerModal.managerDataPrice.$error.required && formManagerModal.managerDataPrice.$touched),
                                                                '': !(formManagerModal.managerDataPrice.$error.required && formManagerModal.managerDataPrice.$touched)
                                                        }">
                            <select ng-required="true" ng-model="modelCurrent.managerDataPrice" name="managerDataPrice">
                                <option value=" <?php echo '{{price.value}}'?>" ng-repeat="price in row.entity.dataPrices"

                                >
                                    <?php echo '{{price.text}}';?>
                                </option>
                            </select>
                            <span class="messages"
                                  ng-show="formManagerModal.$submitted || formManagerModal.managerDataPrice.$touched">
                                <span ng-show="formManagerModal.managerDataPrice.$error.required" class="required ">Campo Requerido.</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button

            id="btn-manager-close"
            data-style='zoom-in'
            data-size="s"
            class="btn btn-danger ladda-button"
            type="button" ng-click="_dismiss()">
            Cancelar
        </button>

        <button

            id="btn-manager"
            data-style='zoom-in'
            data-size="s"
            class="btn btn-success ladda-button"
            type="button" ng-disabled="!formManagerModal.$valid" ng-click="_changePrice()">
            <?php echo '{{lblModalSave}}';?>
        </button>
    </div>

</script>
