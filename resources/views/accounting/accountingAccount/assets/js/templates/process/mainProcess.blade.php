<script type='text/x-template' id='accounting-account-template'>
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
        @include( 'partials.adminViewVue',['title'=>'Menu','grid_name'=>'accounting-account-grid'])

        <div class="content-form" v-if="showManager">
            <b-form id="accountingAccountForm" v-on:submit.prevent="_submitForm">


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
                                        @click="onListenElementsForm({'element':'value','objectElement':$v.model.attributes.value})"
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
                                 :class="getClassErrorForm('status',$v.model.attributes.status)">
                                <label class="form__label "v-html='getLabelForm("status")' ></label>
                                <div class="content-element-form">
                                    <select
                                        @click="onListenElementsForm({'element':'status','objectElement':$v.model.attributes.status})"
                                        v-model.trim="$v.model.attributes.status.$model"
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
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('accounting_account_type_id_data',$v.model.attributes.accounting_account_type_id_data)">
                                <label
                                    class="form__label "v-html='getLabelForm("accounting_account_type_id_data")' ></label>
                                <div class="content-element-form">
                                    <input
                                        v-model="$v.model.attributes.accounting_account_type_id_data.model"
                                           type="hidden"
                                           v-bind:id="getNameAttribute('accounting_account_type_id_data')"
                                           v-bind:name="getNameAttribute('accounting_account_type_id_data')"
                                           @change="_setValueForm('accounting_account_type_id_data', $v.model.attributes.accounting_account_type_id_data.$model)"
                                    >
                                    <select
                                        @click="onListenElementsForm({'element':'accounting_account_type_id_data','objectElement':$v.model.attributes.accounting_account_type_id_data})"

                                        id="accounting_account_type_id_data"
                                            class="form-control m-select2 "
                                            v-initS2AccountingAccountType="{rowId:model.attributes.id,_managerS2AccountingAccountType:_managerS2AccountingAccountType}"
                                    >
                                    </select>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.accounting_account_type_id_data.$error">
      <span v-if="!$v.model.attributes.accounting_account_type_id_data.required">
       <?php  echo "{{model.structure.accounting_account_type_id_data.required.msj}}"?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('accounting_level_id_data',$v.model.attributes.accounting_level_id_data)">
                                <label
                                    class="form__label "v-html='getLabelForm("accounting_level_id_data")' ></label>
                                <div class="content-element-form">
                                    <input v-model="$v.model.attributes.accounting_level_id_data.model" type="hidden"
                                           v-bind:id="getNameAttribute('accounting_level_id_data')"
                                           v-bind:name="getNameAttribute('accounting_level_id_data')"
                                           @change="_setValueForm('accounting_level_id_data', $v.model.attributes.accounting_level_id_data.$model)"
                                    >
                                    <select id="accounting_level_id_data"
                                            @click="onListenElementsForm({'element':'accounting_level_id_data','objectElement':$v.model.attributes.accounting_level_id_data})"

                                            class="form-control m-select2 "
                                            v-initS2AccountingLevel="{rowId:model.attributes.id,_managerS2AccountingLevel:_managerS2AccountingLevel}"
                                    >
                                    </select>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.accounting_level_id_data.$error">
      <span v-if="!$v.model.attributes.accounting_level_id_data.required">
       <?php  echo "{{model.structure.accounting_level_id_data.required.msj}}"?>
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
    @click="onListenElementsForm({'element':'description','objectElement':$v.model.attributes.description})"

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
      <span v-if="!$v.model.attributes.description.required">
       <?php  echo "{{model.structure.description.required.msj}}"?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('parent_key',$v.model.attributes.parent_key)">
                                <label class="form__label "v-html='getLabelForm("parent_key")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'parent_key','objectElement':$v.model.attributes.parent_key})"

                                        v-model.trim="$v.model.attributes.parent_key.$model"
                                        type="number"
                                        v-bind:id="getNameAttribute('parent_key')"
                                        v-bind:name="getNameAttribute('parent_key')"
                                        min="0" class="form-control m-input"
                                        @change="_setValueForm('parent_key', $v.model.attributes.parent_key.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.parent_key.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('has_parent',$v.model.attributes.has_parent)">
                                <label class="form__label "v-html='getLabelForm("has_parent")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'has_parent','objectElement':$v.model.attributes.has_parent})"

                                        v-model.trim="$v.model.attributes.has_parent.$model"
                                        type="checkbox"
                                        v-bind:id="getNameAttribute('has_parent')"
                                        v-bind:name="getNameAttribute('has_parent')"
                                        class="form-control m-input"
                                        @change="_setValueForm('has_parent', $v.model.attributes.has_parent.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.has_parent.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('is_parent',$v.model.attributes.is_parent)">
                                <label class="form__label "v-html='getLabelForm("is_parent")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'is_parent','objectElement':$v.model.attributes.is_parent})"

                                        v-model.trim="$v.model.attributes.is_parent.$model"
                                        type="checkbox"
                                        v-bind:id="getNameAttribute('is_parent')"
                                        v-bind:name="getNameAttribute('is_parent')"
                                        class="form-control m-input"
                                        @change="_setValueForm('is_parent', $v.model.attributes.is_parent.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.is_parent.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('movement',$v.model.attributes.movement)">
                                <label class="form__label "v-html='getLabelForm("movement")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'movement','objectElement':$v.model.attributes.movement})"

                                        v-model.trim="$v.model.attributes.movement.$model"
                                        type="checkbox"
                                        v-bind:id="getNameAttribute('movement')"
                                        v-bind:name="getNameAttribute('movement')"
                                        class="form-control m-input"
                                        @change="_setValueForm('movement', $v.model.attributes.movement.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.movement.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('rfc',$v.model.attributes.rfc)">
                                <label class="form__label "v-html='getLabelForm("rfc")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'rfc','objectElement':$v.model.attributes.rfc})"

                                        v-model.trim="$v.model.attributes.rfc.$model"
                                        type="checkbox"
                                        v-bind:id="getNameAttribute('rfc')"
                                        v-bind:name="getNameAttribute('rfc')"
                                        class="form-control m-input"
                                        @change="_setValueForm('rfc', $v.model.attributes.rfc.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.rfc.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('cost_center',$v.model.attributes.cost_center)">
                                <label class="form__label "v-html='getLabelForm("cost_center")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'cost_center','objectElement':$v.model.attributes.cost_center})"

                                        v-model.trim="$v.model.attributes.cost_center.$model"
                                        type="checkbox"
                                        v-bind:id="getNameAttribute('cost_center')"
                                        v-bind:name="getNameAttribute('cost_center')"
                                        class="form-control m-input"
                                        @change="_setValueForm('cost_center', $v.model.attributes.cost_center.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.cost_center.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('base_amount',$v.model.attributes.base_amount)">
                                <label class="form__label "v-html='getLabelForm("base_amount")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'base_amount','objectElement':$v.model.attributes.base_amount})"

                                        v-model.trim="$v.model.attributes.base_amount.$model"
                                        type="checkbox"
                                        v-bind:id="getNameAttribute('base_amount')"
                                        v-bind:name="getNameAttribute('base_amount')"
                                        class="form-control m-input"
                                        @change="_setValueForm('base_amount', $v.model.attributes.base_amount.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.base_amount.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('base_amount_percentage',$v.model.attributes.base_amount_percentage)">
                                <label
                                    class="form__label "v-html='getLabelForm("base_amount_percentage")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'base_amount_percentage','objectElement':$v.model.attributes.base_amount_percentage})"

                                        v-model.trim="$v.model.attributes.base_amount_percentage.$model"
                                        type="number"
                                        v-bind:id="getNameAttribute('base_amount_percentage')"
                                        v-bind:name="getNameAttribute('base_amount_percentage')"
                                        min="0" class="form-control m-input"
                                        @change="_setValueForm('base_amount_percentage', $v.model.attributes.base_amount_percentage.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.base_amount_percentage.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('base_amount_value',$v.model.attributes.base_amount_value)">
                                <label class="form__label "v-html='getLabelForm("base_amount_value")' ></label>
                                <div class="content-element-form">
                                    <input
                                        @click="onListenElementsForm({'element':'base_amount_value','objectElement':$v.model.attributes.base_amount_value})"

                                        v-model.trim="$v.model.attributes.base_amount_value.$model"
                                        type="number"
                                        v-bind:id="getNameAttribute('base_amount_value')"
                                        v-bind:name="getNameAttribute('base_amount_value')"
                                        min="0" class="form-control m-input"
                                        @change="_setValueForm('base_amount_value', $v.model.attributes.base_amount_value.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.base_amount_value.$error">
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

