<script type='text/x-template' id='accounting-level-template'>
    <div>

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
                    <?php echo '{{labelsConfig.buttons.create}}'?></button>

                <div v-if="!showManager">
                    <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                        <menu-admin-grid
                            @input="_managerRowGrid($event)"
                            :manager-menu-config="managerMenuConfig" >

                        </menu-admin-grid>


                    </div>
                </div>
            </div>
        </b-container>


        @include( 'partials.adminViewVue',['title'=>'Niveles','grid_name'=>'accounting-level-grid'])

        <div class="content-form" v-if="showManager">
            <b-form id="accountingLevelForm" v-on:submit.prevent="_submitForm">


                <b-container>
                    <input v-model="model.attributes.id" type="hidden"
                           v-bind:id="getNameAttribute('id')"
                           v-bind:name="getNameAttribute('id')"
                    >
                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('value',$v.model.attributes.value)">
                                <label class="form__label "v-html='getLabelForm("value")' ></label>
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
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('description',$v.model.attributes.description)">
                                <label class="form__label "v-html='getLabelForm("description")' ></label>
                                <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.description.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('status',$v.model.attributes.status)">
                                <label class="form__label "v-html='getLabelForm("status")' ></label>
                                <div class="content-element-form">
                                    <select v-model.trim="$v.model.attributes.status.$model"
                                            v-bind:id="getNameAttribute('status')"
                                            v-bind:name="getNameAttribute('status')"
                                            class="form-control m-input"
                                            @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                    >
                                        <option v-for="(row,index) in model.structure.status.options"
                                                v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.status.$error">
      <span v-if="!$v.model.attributes.status.required">
       <?php  echo "{{model.structure.status.required.msj}}"?>
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
</script>

