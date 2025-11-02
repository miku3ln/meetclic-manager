<script type='text/x-template' id='events-trails-distances-template'>
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

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="events-trails-distances-grid"
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
                <b-form id="eventsTrailsDistancesForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >

                        <b-row>
                            <b-col md="3">
                                <div class="form-group"
                                     :class="getClassErrorForm('status',$v.model.attributes.status)">
                                    <label class="form__label " v-html='getLabelForm("status")' ></label>
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
                            <b-col md="4" v-if="false">
                                <div class="form-group"
                                     :class="getClassErrorForm('type',$v.model.attributes.type)">
                                    <label class="form__label " v-html='getLabelForm("type")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.type.$model"
                                                v-bind:id="getNameAttribute('type')"
                                                v-bind:name="getNameAttribute('type')"
                                                class="form-control m-input"
                                                @change="_setValueForm('type', $v.model.attributes.type.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.type.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
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
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('events_trails_type_teams_id_data',$v.model.attributes.events_trails_type_teams_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("events_trails_type_teams_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.events_trails_type_teams_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('events_trails_type_teams_id_data')"
                                               v-bind:name="getNameAttribute('events_trails_type_teams_id_data')"
                                               @change="_setValueForm('events_trails_type_teams_id_data', $v.model.attributes.events_trails_type_teams_id_data.$model)"
                                        >
                                        <select id="events_trails_type_teams_id_data"
                                                class="form-control m-select2 "
                                                v-initS2EventsTrailsTypeTeams="{rowId:model.attributes.id,_managerS2EventsTrailsTypeTeams:_managerS2EventsTrailsTypeTeams}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.events_trails_type_teams_id_data.$error">
      <span v-if="!$v.model.attributes.events_trails_type_teams_id_data.required">
       <?php  echo "{{model.structure.events_trails_type_teams_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label class="form__label " v-html='getLabelForm("value")' ></label>
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
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('value_distance',$v.model.attributes.value_distance)">
                                    <label
                                        class="form__label " v-html='getLabelForm("value_distance")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.value_distance.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('value_distance')"
                                            v-bind:name="getNameAttribute('value_distance')"
                                            min="0" class="form-control m-input"
                                            @change="_setValueForm('value_distance', $v.model.attributes.value_distance.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.value_distance.$error">
      <span v-if="!$v.model.attributes.value_distance.required">
       <?php  echo "{{model.structure.value_distance.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('price',$v.model.attributes.price)">
                                    <label class="form__label " v-html='getLabelForm("price")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.price.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('price')"
                                            v-bind:name="getNameAttribute('price')"
                                            min="0" class="form-control m-input"
                                            @change="_setValueForm('price', $v.model.attributes.price.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.price.$error">
      <span v-if="!$v.model.attributes.price.required">
       <?php  echo "{{model.structure.price.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </b-row>
                        <b-row>


                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('description',$v.model.attributes.description)">
                                    <label class="form__label " v-html='getLabelForm("description")' ></label>
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


                        </b-row>

                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>

