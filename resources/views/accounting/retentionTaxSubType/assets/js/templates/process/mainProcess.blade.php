<script type='text/x-template' id='retention-tax-sub-type-template'>
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
    <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?></button>

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

<div class="content-manager-grid">

    <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
        <table id="retention-tax-sub-type-grid"
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
    <b-form id="retentionTaxSubTypeForm" v-on:submit.prevent="_submitForm">


        <b-container>
<input v-model="model.attributes.id" type="hidden"
v-bind:id="getNameAttribute('id')"
v-bind:name="getNameAttribute('id')"
>
<b-row>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('value',$v.model.attributes.value)">
<label class="form__label "><?php echo'{{getLabelForm("value")}}'?></label> 
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
<label class="form__label "><?php echo'{{getLabelForm("description")}}'?></label> 
<div class="content-element-form">
<textarea
rows="2" class="form-control"
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
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('type',$v.model.attributes.type)">
<label class="form__label "><?php echo'{{getLabelForm("type")}}'?></label> 
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.type.$model"
type="number"
v-bind:id="getNameAttribute('type')"
v-bind:name="getNameAttribute('type')"
min="0" class="form-control m-input"
@change="_setValueForm('type', $v.model.attributes.type.$model)"
v-focus-select
>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.type.$error">
      <span v-if="!$v.model.attributes.type.required">
       <?php  echo "{{model.structure.type.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div> 
</div> 

 </b-col>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('retention_tax_type_id_data',$v.model.attributes.retention_tax_type_id_data)">
<label class="form__label "><?php echo'{{getLabelForm("retention_tax_type_id_data")}}'?></label> 
<div class="content-element-form">
<input v-model="$v.model.attributes.retention_tax_type_id_data.model" type="hidden"
v-bind:id="getNameAttribute('retention_tax_type_id_data')"
v-bind:name="getNameAttribute('retention_tax_type_id_data')"
@change="_setValueForm('retention_tax_type_id_data', $v.model.attributes.retention_tax_type_id_data.$model)"
>
<select id="retention_tax_type_id_data"
class="form-control m-select2 "
v-initS2RetentionTaxType="{rowId:model.attributes.id,_managerS2RetentionTaxType:_managerS2RetentionTaxType}"
>
</select>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.retention_tax_type_id_data.$error">
      <span v-if="!$v.model.attributes.retention_tax_type_id_data.required">
       <?php  echo "{{model.structure.retention_tax_type_id_data.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div> 
</div> 

 </b-col>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('percentage',$v.model.attributes.percentage)">
<label class="form__label "><?php echo'{{getLabelForm("percentage")}}'?></label> 
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
</b-row>

</b-container>

    </b-form>

</div>



</div>
</div>
</script>

