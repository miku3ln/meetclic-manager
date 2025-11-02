<script type='text/x-template' id='accounting-config-modules-account-by-account-template'>
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
</b-container >


    @include( 'partials.adminViewVue',['title'=>'Modulos','grid_name'=>'accounting-config-modules-account-by-account-grid'])

    <div class="content-form" v-if="showManager">
    <b-form id="accountingConfigModulesAccountByAccountForm" v-on:submit.prevent="_submitForm">


        <b-container>
<input v-model="model.attributes.id" type="hidden"
v-bind:id="getNameAttribute('id')"
v-bind:name="getNameAttribute('id')"
>
<b-row>
<b-col md="12">
 <div class="form-group"
:class="getClassErrorForm('accounting_account_id_data',$v.model.attributes.accounting_account_id_data)">
<label class="form__label "><?php echo'{{getLabelForm("accounting_account_id_data")}}'?></label>
<div class="content-element-form">
<input v-model="$v.model.attributes.accounting_account_id_data.model" type="hidden"
v-bind:id="getNameAttribute('accounting_account_id_data')"
v-bind:name="getNameAttribute('accounting_account_id_data')"
@change="_setValueForm('accounting_account_id_data', $v.model.attributes.accounting_account_id_data.$model)"
>
<select id="accounting_account_id_data"
class="form-control m-select2 "
v-initS2AccountingAccount="{rowId:model.attributes.id,_managerS2AccountingAccount:_managerS2AccountingAccount}"
>
</select>
  </div>
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.accounting_account_id_data.$error">
      <span v-if="!$v.model.attributes.accounting_account_id_data.required">
       <?php  echo "{{model.structure.accounting_account_id_data.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div>
</div>

 </b-col>
<b-col md="12">
 <div class="form-group"
:class="getClassErrorForm('description',$v.model.attributes.description)">
<label class="form__label "><?php echo'{{getLabelForm("description")}}'?></label>
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
      <span v-if="!$v.model.attributes.description.required">
       <?php  echo "{{model.structure.description.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div>
</div>

 </b-col>
<b-col md="12">
 <div class="form-group"
:class="getClassErrorForm('code',$v.model.attributes.code)">
<label class="form__label "><?php echo'{{getLabelForm("code")}}'?></label>
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.code.$model"
type="text"
v-bind:id="getNameAttribute('code')"
v-bind:name="getNameAttribute('code')"
class="form-control m-input"
@change="_setValueForm('code', $v.model.attributes.code.$model)"
v-focus-select
>
  </div>
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.code.$error">
      <span v-if="!$v.model.attributes.code.required">
       <?php  echo "{{model.structure.code.required.msj}}"?>
      </span>
      <span v-if="!$v.model.attributes.code.maxLength">
       <?php  echo "{{model.structure.code.maxLength.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div>
</div>

 </b-col>
<b-col md="12">
 <div class="form-group"
:class="getClassErrorForm('accounting_config_modules_types_id_data',$v.model.attributes.accounting_config_modules_types_id_data)">
<label class="form__label "><?php echo'{{getLabelForm("accounting_config_modules_types_id_data")}}'?></label>
<div class="content-element-form">
<input v-model="$v.model.attributes.accounting_config_modules_types_id_data.model" type="hidden"
v-bind:id="getNameAttribute('accounting_config_modules_types_id_data')"
v-bind:name="getNameAttribute('accounting_config_modules_types_id_data')"
@change="_setValueForm('accounting_config_modules_types_id_data', $v.model.attributes.accounting_config_modules_types_id_data.$model)"
>
<select id="accounting_config_modules_types_id_data"
class="form-control m-select2 "
v-initS2AccountingConfigModulesTypes="{rowId:model.attributes.id,_managerS2AccountingConfigModulesTypes:_managerS2AccountingConfigModulesTypes}"
>
</select>
  </div>
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.accounting_config_modules_types_id_data.$error">
      <span v-if="!$v.model.attributes.accounting_config_modules_types_id_data.required">
       <?php  echo "{{model.structure.accounting_config_modules_types_id_data.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div>
</div>

 </b-col>
<b-col md="12">
 <div class="form-group"
:class="getClassErrorForm('type_of_income',$v.model.attributes.type_of_income)">
<label class="form__label "><?php echo'{{getLabelForm("type_of_income")}}'?></label>
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.type_of_income.$model"
type="checkbox"
v-bind:id="getNameAttribute('type_of_income')"
v-bind:name="getNameAttribute('type_of_income')"
class="form-control m-input"
@change="_setValueForm('type_of_income', $v.model.attributes.type_of_income.$model)"
v-focus-select
>
  </div>
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.type_of_income.$error">
     </b-form-invalid-feedback>
   </div>
</div>

 </b-col>
<b-col md="12">
 <div class="form-group"
:class="getClassErrorForm('status',$v.model.attributes.status)">
<label class="form__label "><?php echo'{{getLabelForm("status")}}'?></label>
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

