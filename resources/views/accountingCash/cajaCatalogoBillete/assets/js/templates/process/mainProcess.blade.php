<script type='text/x-template' id='caja-catalogo-billete-template'>
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
        <table id="caja-catalogo-billete-grid"
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
    <b-form id="cajaCatalogoBilleteForm" v-on:submit.prevent="_submitForm">


        <b-container>
<input v-model="model.attributes.id" type="hidden"
v-bind:id="getNameAttribute('id')"
v-bind:name="getNameAttribute('id')"
>
<b-row>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('caja_tipo_billete_id',$v.model.attributes.caja_tipo_billete_id)">
<label class="form__label "><?php echo'{{getLabelForm("caja_tipo_billete_id")}}'?></label> 
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.caja_tipo_billete_id.$model"
type="number"
v-bind:id="getNameAttribute('caja_tipo_billete_id')"
v-bind:name="getNameAttribute('caja_tipo_billete_id')"
min="0" class="form-control m-input"
@change="_setValueForm('caja_tipo_billete_id', $v.model.attributes.caja_tipo_billete_id.$model)"
v-focus-select
>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.caja_tipo_billete_id.$error">
      <span v-if="!$v.model.attributes.caja_tipo_billete_id.required">
       <?php  echo "{{model.structure.caja_tipo_billete_id.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div> 
</div> 

 </b-col>
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

:class="getClassErrorForm('caja_catalogo_tipo_fraccion_id',$v.model.attributes.caja_catalogo_tipo_fraccion_id)">
<label class="form__label "><?php echo'{{getLabelForm("caja_catalogo_tipo_fraccion_id")}}'?></label> 
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.caja_catalogo_tipo_fraccion_id.$model"
type="number"
v-bind:id="getNameAttribute('caja_catalogo_tipo_fraccion_id')"
v-bind:name="getNameAttribute('caja_catalogo_tipo_fraccion_id')"
min="0" class="form-control m-input"
@change="_setValueForm('caja_catalogo_tipo_fraccion_id', $v.model.attributes.caja_catalogo_tipo_fraccion_id.$model)"
v-focus-select
>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.caja_catalogo_tipo_fraccion_id.$error">
      <span v-if="!$v.model.attributes.caja_catalogo_tipo_fraccion_id.required">
       <?php  echo "{{model.structure.caja_catalogo_tipo_fraccion_id.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div> 
</div> 

 </b-col>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('valor',$v.model.attributes.valor)">
<label class="form__label "><?php echo'{{getLabelForm("valor")}}'?></label> 
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.valor.$model"
type="number"
v-bind:id="getNameAttribute('valor')"
v-bind:name="getNameAttribute('valor')"
min="0" class="form-control m-input"
@change="_setValueForm('valor', $v.model.attributes.valor.$model)"
v-focus-select
>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.valor.$error">
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

