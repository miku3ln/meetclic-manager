<script type='text/x-template' id='allow-processes-threads-template'>
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
        <table id="allow-processes-threads-grid"
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
    <b-form id="allowProcessesThreadsForm" v-on:submit.prevent="_submitForm">


        <b-container>
<input v-model="model.attributes.id" type="hidden"
v-bind:id="getNameAttribute('id')"
v-bind:name="getNameAttribute('id')"
>
<b-row>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('name_process',$v.model.attributes.name_process)">
<label class="form__label "><?php echo'{{getLabelForm("name_process")}}'?></label> 
<div class="content-element-form">
<textarea
rows="2" class="form-control"
v-model.trim="$v.model.attributes.name_process.$model"
v-bind:id="getNameAttribute('name_process')"
v-bind:name="getNameAttribute('name_process')"
@change="_setValueForm('name_process', $v.model.attributes.name_process.$model)"
v-focus-select
></textarea>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.name_process.$error">
      <span v-if="!$v.model.attributes.name_process.required">
       <?php  echo "{{model.structure.name_process.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div> 
</div> 

 </b-col>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('thread_name',$v.model.attributes.thread_name)">
<label class="form__label "><?php echo'{{getLabelForm("thread_name")}}'?></label> 
<div class="content-element-form">
<textarea
rows="2" class="form-control"
v-model.trim="$v.model.attributes.thread_name.$model"
v-bind:id="getNameAttribute('thread_name')"
v-bind:name="getNameAttribute('thread_name')"
@change="_setValueForm('thread_name', $v.model.attributes.thread_name.$model)"
v-focus-select
></textarea>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.thread_name.$error">
      <span v-if="!$v.model.attributes.thread_name.required">
       <?php  echo "{{model.structure.thread_name.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div> 
</div> 

 </b-col>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('allow',$v.model.attributes.allow)">
<label class="form__label "><?php echo'{{getLabelForm("allow")}}'?></label> 
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.allow.$model"
type="number"
v-bind:id="getNameAttribute('allow')"
v-bind:name="getNameAttribute('allow')"
min="0" class="form-control m-input"
@change="_setValueForm('allow', $v.model.attributes.allow.$model)"
v-focus-select
>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.allow.$error">
      <span v-if="!$v.model.attributes.allow.required">
       <?php  echo "{{model.structure.allow.required.msj}}"?>
      </span>
     </b-form-invalid-feedback>
   </div> 
</div> 

 </b-col>
<b-col md="12">
 <div class="form-group"

:class="getClassErrorForm('entity_plans_id',$v.model.attributes.entity_plans_id)">
<label class="form__label "><?php echo'{{getLabelForm("entity_plans_id")}}'?></label> 
<div class="content-element-form">
<input
v-model.trim="$v.model.attributes.entity_plans_id.$model"
type="number"
v-bind:id="getNameAttribute('entity_plans_id')"
v-bind:name="getNameAttribute('entity_plans_id')"
min="0" class="form-control m-input"
@change="_setValueForm('entity_plans_id', $v.model.attributes.entity_plans_id.$model)"
v-focus-select
>
  </div> 
<div class="content-message-errors">
      <b-form-invalid-feedback
      :state="!$v.model.attributes.entity_plans_id.$error">
      <span v-if="!$v.model.attributes.entity_plans_id.required">
       <?php  echo "{{model.structure.entity_plans_id.required.msj}}"?>
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

