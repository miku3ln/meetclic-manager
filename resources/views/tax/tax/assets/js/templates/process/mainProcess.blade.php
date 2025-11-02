<script type='text/x-template' id='tax-template'>
    <div>

        <div class='content-component'>

            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                        <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?></button>
                    <button v-if="showManager" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{managerType==1?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?></button>

                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" ng-if="managerMenuConfig.view">
                            <div v-for="(menu, key) in managerMenuConfig.menuCurrent" class="inline-data">
                                <a
                                    v-if="menu.isUrl"
                                    v-init-tool-tip
                                    v-bind:id="'a-menu-'+menu.rowId"
                                    v-bind:href="menu.url+menu.rowId"
                                    class="btn btn-xs content-manager-buttons-grid__a "
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                    <i v-bind:class="<?php echo 'menu.icon' ?>"></i> </a>
                                <a
                                    v-else
                                    v-init-tool-tip
                                    v-bind:id="'a-menu-'+menu.rowId"
                                    v-on:click="_managerMenuGrid(key, menu)"
                                    class="btn btn-xs content-manager-buttons-grid__a "
                                    data-toggle="tooltip"
                                    data-placement="top"
                                    v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                    <i v-bind:class="<?php echo 'menu.icon' ?>"></i> </a>
                            </div>

                        </div>
                    </div>
                </div>
            </b-container>
            @include( 'partials.adminViewVue',['title'=>'Menu','grid_name'=>'tax-grid'])


            <div class="content-form" v-if="showManager">
                <b-form id="taxForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <div class="row">
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('state',$v.model.attributes.state)">
                                    <label class="form__label " v-html='getLabelForm("state")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.state.$model"
                                                v-bind:id="getNameAttribute('state')"
                                                v-bind:name="getNameAttribute('state')"
                                                class="form-control m-input"
                                                @change="_setValueForm('state', $v.model.attributes.state.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.state.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php  echo "{{model.structure.state.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </div>
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label class="form__label " v-html='getLabelForm("value")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.value.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('value')"
                                            v-bind:name="getNameAttribute('value')"
                                            class="form-control m-input"
                                            @change="_setValueForm('value', $v.model.attributes.value.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.value.$error">
      <span v-if="!$v.model.attributes.value.required">
       <?php  echo "{{model.structure.value.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.value.maxLength">
       <?php  echo "{{model.structure.value.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('percentage',$v.model.attributes.percentage)">
                                    <label class="form__label " v-html='getLabelForm("percentage")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.percentage.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('percentage')"
                                            v-bind:name="getNameAttribute('percentage')"
                                            min="0" class="form-control m-input"
                                            @change="_setValueForm('percentage', $v.model.attributes.percentage.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.percentage.$error">
      <span v-if="!$v.model.attributes.percentage.required">
       <?php  echo "{{model.structure.percentage.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </b-row>

                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>

