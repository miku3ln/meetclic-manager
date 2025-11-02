<script type='text/x-template' id='events-trails-project-template'>
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
                                :manager-menu-config="managerMenuConfig">

                            </menu-admin-grid>

                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="events-trails-project-grid"
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
                <b-form id="eventsTrailsProjectForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <div class="row">

                            <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12" id="col-content-manager-url_img">
                                <div class="content-box-image content-box-preview" id="container_selector_image"
                                     @click="_uploadData">
                                    <img class="content-box-image__preview">
                                    <div class="content-box-image__manager">
                                        <button @click="_uploadData" class="btn-upload-resources "
                                                id="btn-add-url_img">
                                            <i class="icon icon-plus"></i>
                                            <?php echo "{{lblUploadName}}" ?>
                                        </button>
                                        <input
                                            v-_upload-resource="{_initEventsUpload:_initEventsUpload}"
                                            type="file"
                                            id="file_upload_img"
                                            class="hidden"
                                            name="EventsTrailsProject[file_upload_img]"
                                        >
                                    </div>
                                </div>
                                <div class="progress-business not-view">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                            </div>
                        </div>
                        <b-row>
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('events_trails_types_id_data',$v.model.attributes.events_trails_types_id_data)">
                                    <label class="form__label "
                                           v-html='getLabelForm("events_trails_types_id_data")'></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.events_trails_types_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('events_trails_types_id_data')"
                                               v-bind:name="getNameAttribute('events_trails_types_id_data')"
                                               @change="_setValueForm('events_trails_types_id_data', $v.model.attributes.events_trails_types_id_data.$model)"
                                        >
                                        <select id="events_trails_types_id_data"
                                                class="form-control m-select2 "
                                                v-initS2EventsTrailsTypes="{rowId:model.attributes.id,_managerS2EventsTrailsTypes:_managerS2EventsTrailsTypes}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.events_trails_types_id_data.$error">
      <span v-if="!$v.model.attributes.events_trails_types_id_data.required">
       <?php  echo "{{model.structure.events_trails_types_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label class="form__label " v-html='getLabelForm("value")'></label>
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
                                     :class="getClassErrorForm('status',$v.model.attributes.status)">
                                    <label class="form__label " v-html='getLabelForm("status")'></label>
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
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('date_init_project',$v.model.attributes.date_init_project)">
                                    <label class="form__label " v-html='getLabelForm("date_init_project")'></label>
                                    <div class="content-element-form">
                                        <date-time-picker
                                            v-model.trim="$v.model.attributes.date_init_project.$model"
                                            v-bind:id="getNameAttribute('date_init_project')"
                                            v-bind:name="getNameAttribute('date_init_project')"

                                            @change="_setValueForm('date_init_project', $v.model.attributes.date_init_project.$model)"
                                            format="dd-LL-yyyy"
                                            locale="es"
                                        ></date-time-picker>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.date_init_project.$error">
      <span v-if="!$v.model.attributes.date_init_project.required">
       <?php  echo "{{model.structure.date_init_project.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('date_end_project',$v.model.attributes.date_end_project)">
                                    <label class="form__label " v-html='getLabelForm("date_end_project")'></label>
                                    <div class="content-element-form">
                                        <date-time-picker
                                            v-model.trim="$v.model.attributes.date_end_project.$model"
                                            v-bind:id="getNameAttribute('date_end_project')"
                                            v-bind:name="getNameAttribute('date_end_project')"

                                            @change="_setValueForm('date_end_project', $v.model.attributes.date_end_project.$model)"
                                            format="dd-LL-yyyy"
                                            locale="es"
                                        ></date-time-picker>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.date_end_project.$error">
      <span v-if="!$v.model.attributes.date_end_project.required">
       <?php  echo "{{model.structure.date_end_project.required.msj}}"?>
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
                                    <label class="form__label " v-html='getLabelForm("description")'></label>
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

