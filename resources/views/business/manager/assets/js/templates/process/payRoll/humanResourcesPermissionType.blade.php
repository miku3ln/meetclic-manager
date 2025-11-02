
@php
$nameElement='human-resources-permission-type';
$nameProcess='HumanResourcesPermissionType';

@endphp
<script type="text/x-template" id="human-resources-permission-type-template">
    <div>

        <b-container class="bv-example-row">
            <div class="content-row-manager-buttons">

                <button
                    v-if="!managerMenuConfig.view"
                    type="button"
                    class="btn "
                    :class="{'btn-success':!showManager,'btn-danger':showManager}"
                    v-on:click="_viewManager(showManager?2:1)">
                    <?php echo "{{showManager?'Regresar':'Nuevo'}}" ?>
                </button>


                <button v-if="showManager" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo "{{lblBtnSave}}" ?>
                </button>
                <div v-if="!showManager">
                    <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">

                        <menu-admin-grid
                            @input="_managerRowGrid($event)"
                            :manager-menu-config="managerMenuConfig">

                        </menu-admin-grid>
                    </div>
                </div>

            </div>
        </b-container>
        <?php ?>
        <div class="content-manager-grid">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <table id="human-resources-permission-type-grid"
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

            <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >
                <input v-model="model.attributes.business_id" type="hidden"

                       v-bind:id="getNameAttribute('business_id')"
                       v-bind:name="getNameAttribute('business_id')">
                <b-container>
                    <b-row>
                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('status',$v.model.attributes.status)">
                                <label
                                    class="form__label "v-html='getLabelForm("status")' ></label>
                                <div class="content-element-form">
                                    <select v-model.trim="$v.model.attributes.status.$model"
                                            v-bind:id="getNameAttribute('status')"
                                            v-bind:name="getNameAttribute('status')"
                                            class="form-control m-input"
                                            @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                    >
                                        <option v-for="(row,index) in statusData"
                                                v-bind:value="row.id"><?php echo '{{row.value}}' ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.status.$error">
      <span v-if="!$v.model.attributes.status.required">
       <?php echo "{{model.structure.status.required.msj}}" ?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('recoverable_permit',$v.model.attributes.recoverable_permit)">
                                <label class="form__label "v-html='getLabelForm("recoverable_permit")' ></label>
                                <div class="content">
                                    <switch-button
                                        v-bind:id="getNameAttribute('recoverable_permit')"
                                        v-bind:name="getNameAttribute('recoverable_permit')"

                                        v-model="$v.model.attributes.recoverable_permit.$model"
                                        color="#34bfa3">
                                    </switch-button>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.recoverable_permit.$error">
                                            <span v-if="!$v.model.attributes.recoverable_permit.required">
                                <?php  echo "{{model.structure.recoverable_permit.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('control_by_hours',$v.model.attributes.control_by_hours)">
                                <label class="form__label "v-html='getLabelForm("control_by_hours")' ></label>
                                <div class="content">
                                    <switch-button
                                        v-bind:id="getNameAttribute('control_by_hours')"
                                        v-bind:name="getNameAttribute('control_by_hours')"

                                        v-model="$v.model.attributes.control_by_hours.$model"
                                        color="#34bfa3">
                                    </switch-button>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.control_by_hours.$error">
                                            <span v-if="!$v.model.attributes.control_by_hours.required">
                                <?php  echo "{{model.structure.control_by_hours.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('code',$v.model.attributes.code)">
                                <label class="form__label "v-html='getLabelForm("code")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.code.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('code')"
                                        v-bind:name="getNameAttribute('code')"
                                        class="form-control m-input"
                                        @change="_setValueForm('code', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.code.$error">
                                            <span v-if="!$v.model.attributes.code.required">
                                <?php echo "{{model.structure.code.required.msj}}" ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('name',$v.model.attributes.name)">
                                <label class="form__label "v-html='getLabelForm("name")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.name.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('name')"
                                        v-bind:name="getNameAttribute('name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('name', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.name.$error">
                                            <span v-if="!$v.model.attributes.name.required">
                                <?php echo "{{model.structure.name.required.msj}}" ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>


                        <b-col md="3" v-if="$v.model.attributes.control_by_hours.$model">
                            <div class="form-group"
                                 :class="getClassErrorForm('control_by_hours_duration',$v.model.attributes.control_by_hours_duration)">
                                <label class="form__label "v-html='getLabelForm("control_by_hours_duration")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.control_by_hours_duration.$model"
                                        type="number"
                                        v-bind:id="getNameAttribute('control_by_hours_duration')"
                                        v-bind:name="getNameAttribute('control_by_hours_duration')"
                                        class="form-control m-input"
                                        @change="_setValueForm('control_by_hours_duration', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.control_by_hours_duration.$error">
                                            <span v-if="!$v.model.attributes.control_by_hours_duration.required">
                                <?php echo "{{model.structure.control_by_hours_duration.required.msj}}" ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>

                    </b-row>
                    <b-row>
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('description',$v.model.attributes.description)"
                            >

                                <label class="form__label "v-html='getLabelForm("description")' ></label>

                                <div class="content ">

                                        <textarea
                                            rows="10" cols="50"
                                            v-model.trim="$v.model.attributes.description.$model"
                                            name="Lodging[description]"
                                            class="form-control m-input"
                                            @change="_setValueForm('description', $event.target.value)"
                                            v-focus-select

                                        ></textarea>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.description.$error">
                                            <span v-if="!$v.model.attributes.description.required">
                                <?php echo "{{model.structure.description.required.msj}}" ?>
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
