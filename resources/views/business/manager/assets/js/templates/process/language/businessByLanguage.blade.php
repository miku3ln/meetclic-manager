<script type='text/x-template' id='business-by-language-template'>
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

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="business-by-language-grid"
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
            <div class="content-form" v-if="showManager">
                <b-form id="businessByLanguage" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
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
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('main',$v.model.attributes.main)">
                                    <label class="form__label " v-html='getLabelForm("main")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.main.$model" type="checkbox"
                                               v-bind:id="getNameAttribute('main')"
                                               v-bind:name="getNameAttribute('main')"
                                               @change="_setValueForm('main', $v.model.attributes.main.$model)"
                                        >
                                    </div>

                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('language_id_data',$v.model.attributes.language_id_data)">
                                    <label class="form__label " v-html='getLabelForm("language_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.language_id_data.$model" type="hidden"
                                               v-bind:id="getNameAttribute('language_id_data')"
                                               v-bind:name="getNameAttribute('language_id_data')"
                                               @change="_setValueForm('language_id_data', $v.model.attributes.language_id_data.$model)"
                                        >
                                        <select id="language_id_data"
                                                class="form-control m-select2 "
                                                v-initS2Language="{rowId:model.attributes.id,_managerS2Language:_managerS2Language}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.language_id_data.$error">
      <span v-if="!$v.model.attributes.language_id_data.required">
       <?php  echo "{{model.structure.language_id_data.required.msj}}"?>
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

