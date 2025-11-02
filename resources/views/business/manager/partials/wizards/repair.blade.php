<script type="text/ng-template" id="CustomerModal.html">
    <div ng-show="!loadData" class="content-loading-modal">
        <h1>
            Cargando data....
        </h1>
    </div>
    <div ng-show="loadData">
        <form id="formManager" name="formManager">

            <div class="modal-header modal-header--custom">
                <div class="modal-title" ng-bind-html="htmlTitle">

                </div>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class=" col-md-4 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('people_type_identification_id_data')">
                            <label for="status">Tipo de Identificacion *</label>
                            <select ng-model="model.attributes.people_type_identification_id_data"
                                    name='people_type_identification_id_data' class="form-control" required>
                                <?php echo '<option ng-repeat="x in peopleTypeIdentificationData" value="{{x.value}}">{{x.text}}</option>'; ?>
                            </select>
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.people_type_identification_id_data.$touched">
                        <span ng-show="formManager.people_type_identification_id_data.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                    <div class=" col-md-4 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('ruc_type_id_data')">
                            <label for="status">Tipo de Ruc *</label>
                            <select ng-model="model.attributes.ruc_type_id_data"
                                    name='ruc_type_id_data' class="form-control" required>
                                <?php echo '<option ng-repeat="x in rucTypeData" value="{{x.value}}">{{x.text}}</option>'; ?>
                            </select>
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.ruc_type_id_data.$touched">
                        <span ng-show="formManager.ruc_type_id_data.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                    <div class=" col-md-4 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('identification_document')">
                            <label for="business_name">Documento/Cedula*</label>
                            <input
                                ng-model="model.attributes.identification_document"
                                type="text"
                                id="identification_document"
                                name="identification_document"
                                class="form-control m-input"
                                select-value-element
                                required
                            >
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.identification_document.$touched">
                        <span ng-show="formManager.identification_document.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                </div>
                <div class="row" ng-if="model.attributes.people_type_identification_id_data=='1'">
                    <div class=" col-md-6 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('business_name')">
                            <label for="business_name">Razon Social*</label>
                            <input
                                ng-model="model.attributes.business_name"
                                type="text"
                                id="business_name"
                                name="business_name"
                                class="form-control m-input"
                                select-value-element
                                required
                            >
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.business_name.$touched">
                        <span ng-show="formManager.business_name.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('business_reason')">
                            <label for="business_name">Razon Comercial*</label>
                            <input
                                ng-model="model.attributes.business_reason"
                                type="text"
                                id="business_reason"
                                name="business_reason"
                                class="form-control m-input"
                                select-value-element
                                required
                            >
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.business_reason.$touched">
                        <span ng-show="formManager.business_reason.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class=" col-md-3 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('people_nationality_id_data')">
                            <label for="status">Nacionalidad *</label>
                            <select ng-model="model.attributes.people_nationality_id_data"
                                    name='people_nationality_id_data' class="form-control" required>
                                <?php echo '<option ng-repeat="x in peopleNationalityData" value="{{x.value}}">{{x.text}}</option>'; ?>
                            </select>
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.people_nationality_id_data.$touched">
                        <span ng-show="formManager.people_nationality_id_data.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                    <div class=" col-md-3 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('people_profession_id_data')">
                            <label for="status">Profesion *</label>
                            <select ng-model="model.attributes.people_profession_id_data"
                                    name='people_profession_id_data' class="form-control" required>
                                <?php echo '<option ng-repeat="x in peopleProfessionData" value="{{x.value}}">{{x.text}}</option>'; ?>
                            </select>
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.people_profession_id_data.$touched">
                        <span ng-show="formManager.people_profession_id_data.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                    <div class=" col-md-3 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('gender_data')">
                            <label for="status">Genero *</label>
                            <select ng-model="model.attributes.gender_data"
                                    name='gender_data' class="form-control" required>
                                <?php echo '<option ng-repeat="x in genderData" value="{{x.value}}">{{x.text}}</option>'; ?>
                            </select>
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.gender_data.$touched">
                        <span ng-show="formManager.gender_data.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                    <div class=" col-md-3 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('birthdate')">
                            <label for="business_name">Fecha Nacimiento*</label>
                            <input
                                ng-model="model.attributes.birthdate"
                                type="date"
                                id="birthdate"
                                name="birthdate"
                                class="form-control m-input"
                                select-value-element
                                required
                            >
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.birthdate.$touched">
                        <span ng-show="formManager.birthdate.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-md-6 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('name')">
                            <label for="business_name">Nombres*</label>
                            <input
                                ng-model="model.attributes.name"
                                type="text"
                                id="name"
                                name="name"
                                class="form-control m-input"
                                select-value-element
                                required
                            >
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.name.$touched">
                        <span ng-show="formManager.name.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                    <div class=" col-md-6 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('last_name')">
                            <label for="business_name">Apellidos*</label>
                            <input
                                ng-model="model.attributes.last_name"
                                type="text"
                                id="last_name"
                                name="last_name"
                                class="form-control m-input"
                                select-value-element
                                required
                            >
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.last_name.$touched">
                        <span ng-show="formManager.last_name.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-md-6 col-sm-12">
                        <div class="form-group" ng-class="getErrorForm('phone')">
                            <label for="business_name"># Telefono*</label>
                            <input
                                ng-model="model.attributes.phone"
                                type="text"
                                id="phone"
                                name="phone"
                                class="form-control m-input"
                                select-value-element
                                required
                            >
                            <span class="messages"
                                  ng-show="formManager.$submitted || formManager.phone.$touched">
                        <span ng-show="formManager.phone.$error.required"
                              class="required ">Campo Requerido.</span>

                    </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-danger "
                        ng-click="_close()">
                    <?php echo 'Cancelar'?>
                </button>
                <button type="button"
                        ng-disabled="!validateForm()"
                        class="btn btn-success "
                        ng-click="_saveModel()">
                    <?php echo 'Registrar'?>
                </button>
            </div>
        </form>

    </div>
</script>
<div class="content-row-manager-buttons">
    <div class="manager-create" ng-if="managerMenuConfig.rowId==null">
        <button

            type="button"
            class="btn "
            ng-class="{'btn-success':!managerViews.register,'btn-danger':managerViews.register}"
            ng-click="_viewManager(managerViews.admin?1:2)">
            <?php  echo "{{managerViews.register?'Regresar':'Nuevo'}}" ?>
        </button>
        <button ng-if="managerViews.register==1 ||managerViews.register==3" type="button"
                ng-disabled="!validateForm()"
                class="btn btn-success "
                ng-click="_saveModel()">
            <?php echo '{{managerViews.register==1?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?>
        </button>
    </div>
    <div ng-if="managerMenuConfig.rowId">
        <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">

            <a
                init-tooltip
                ng-repeat="(key, menu) in managerMenuConfig.menuCurrent"
                id="a-menu-<?php echo "{{menu.rowId}}"?>"
                ng-click="_managerMenuGrid(key, menu)"
                class="content-manager-buttons-grid__a " data-toggle="tooltip"
                data-placement="top" data-original-title="<?php echo '{{menu.title}}' ?>">
                <i class="<?php echo '{{menu.icon}}' ?>"></i>
            </a>

        </div>
        <button
            ng-if="!managerMenuConfig.view"
            type="button"
            class="btn btn-danger "
            ng-click="_managerRowGrid({managerType:'returnEntity'})">
            <?php  echo "Regresar" ?>
        </button>
        <button ng-if="!managerMenuConfig.view" type="button"
                ng-disabled="!validateForm()"
                class="btn btn-success "
                ng-click="_saveModel()">
            <?php echo '{{labelsConfig.buttons.update}}'?>
        </button>

    </div>
</div>
<form id="formManager" name="formManager">
    <div class="manager-register" ng-if="managerViews.register">

        @include( $partials . '.wizards.repair.register',['configPartial'=>$configPartial])
    </div>
</form>
<div class="manager-admin" ng-show="managerViews.admin">
    @include( $partials . '.wizards.repair.admin',['configPartial'=>$configPartial])
</div>

