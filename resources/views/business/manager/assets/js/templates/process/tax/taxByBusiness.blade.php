
{{--BUSINESS-MANAGER--TEMPLATE-ROOT--TAX--}}
<?php

$utilManagerUser = new \App\Utils\UtilUser;
$user = Auth::user();

$dataManagerActions = array(
    array(
        "title" => "Actualizar",
        "data-placement" => "top",
        "i-class" => "fas fa-pencil-alt",
        "managerType" => "updateEntity",
        "action" => 'taxByBusiness/save'
    ),

);
$buttonsManagements = [


];

foreach ($dataManagerActions as $key => $value) {
    if ($utilManagerUser->allowActionByUser(['actionCurrent' => $value['action'], 'user' => $user])) {
        array_push($buttonsManagements, $value);
    }
}

$dataManagerProcessActions = array(
    array(
        "title" => "Crear",
        "data-placement" => "top",
        "i-class" => "fas fa-pencil-alt",
        "managerType" => "updateEntity",
        "action" => 'taxByBusiness/save',
        'type' => 'create',
    ),
);
$buttonsProcess = [


];
foreach ($dataManagerProcessActions as $key => $value) {
    if ($utilManagerUser->allowActionByUser(['actionCurrent' => $value['action'], 'user' => $user])) {
        array_push($buttonsProcess, $value);
    }
}
?>


<script id="buttons-manager-admin">
    var $buttonsManagements = <?php echo json_encode($buttonsManagements); ?>;

    var $buttonsProcess = <?php echo json_encode($buttonsProcess); ?>;

</script>


<script type='text/x-template' id='tax-by-business-template'>
    <div>
<div class='content-component'>


            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button
                        v-if="!managerMenuConfig.view  && viewProcessButton({type:'create'})"
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
                        <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                            <menu-admin-grid
                                @input="_managerRowGrid($event)"
                                :manager-menu-config="managerMenuConfig" >

                            </menu-admin-grid>


                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="tax-by-business-grid"
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
                <b-form id="taxByBusinessForm" v-on:submit.prevent="_submitForm">


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
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('tax_id_data',$v.model.attributes.tax_id_data)">
                                    <label class="form__label " v-html='getLabelForm("tax_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.tax_id_data.model" type="hidden"
                                               v-bind:id="getNameAttribute('tax_id_data')"
                                               v-bind:name="getNameAttribute('tax_id_data')"
                                               @change="_setValueForm('tax_id_data', $v.model.attributes.tax_id_data.$model)"
                                        >
                                        <select id="tax_id_data"
                                                class="form-control m-select2 "
                                                v-initS2Tax="{rowId:model.attributes.id,_managerS2Tax:_managerS2Tax}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.tax_id_data.$error">
      <span v-if="!$v.model.attributes.tax_id_data.required">
       <?php  echo "{{model.structure.tax_id_data.required.msj}}"?>
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

