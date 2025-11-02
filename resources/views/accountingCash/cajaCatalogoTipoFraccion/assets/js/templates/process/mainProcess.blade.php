<script type='text/x-template' id='caja-catalogo-tipo-fraccion-template'>
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
        <table id="caja-catalogo-tipo-fraccion-grid"
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
    <b-form id="cajaCatalogoTipoFraccionForm" v-on:submit.prevent="_submitForm">


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

:class="getClassErrorForm('descripcion',$v.model.attributes.descripcion)">
<label class="form__label "><?php echo'{{getLabelForm("descripcion")}}'?></label> 
<div class="content-element-form">
<textarea
rows="2" class="form-control"
v-model.trim="$v.model.attributes.descripcion.$model"
v-bind:id="getNameAttribute('descripcion')"
v-bind:name="getNameAttribute('descripcion')"
@change="_setValueForm('descripcion', $v.model.attributes.descripcion.$model)"
v-focus-select
></textarea>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.descripcion.$error">
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

