<script type="text/x-template" id="business-by-employee-profile-template">
    <div>
        <b-modal
            hide-footer
            id="modal-business-by-employee-profile"
            ref="refBusinessByEmployeeProfileModal"
            size="md"
            <?php echo '@show="_showModal"'; ?>
            <?php echo '@hidden="_hideModal"'; ?>

            <?php echo '@ok="_saveModal"'; ?>
        >
            <template slot="modal-title">


                <label v-html="labelsConfig.title"></label>
            </template>
            <div class="d-block ">
                <b-form id="BusinessByEmployeeProfileForm" v-on:submit.prevent="_submitForm">

                    <input v-model="model.attributes.id" type="hidden"

                           v-bind:id="getNameAttribute('id')"
                           v-bind:name="getNameAttribute('id')"
                    >
                    <b-container>


                        <b-row>

                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('human_resources_employee_profile_id_data',$v.model.attributes.human_resources_employee_profile_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("human_resources_employee_profile_id_data")'></label>
                                    <div class="content">
                                        <input type="hidden"
                                               v-model.trim="$v.model.attributes.human_resources_employee_profile_id_data.$model"
                                               v-bind:id="getNameAttribute('human_resources_employee_profile_id_data')"
                                               v-bind:name="getNameAttribute('human_resources_employee_profile_id_data')"
                                               @change="_setValueForm('human_resources_employee_profile_id_data', $event.target.value)"
                                        >
                                        <select
                                            id="human_resources_employee_profile_id_data"
                                            class="form-control m-select2 human_resources_employee_profile_id_data select2-container-modal"
                                            v-initS2="{model:model.attributes.id,onInitSelect2:onInitEmployeeProfile}"
                                        >
                                        </select>


                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.human_resources_employee_profile_id_data.$error">
                                            <span
                                                v-if="!$v.model.attributes.human_resources_employee_profile_id_data.required">
                                <?php echo '{{ model.structure.human_resources_employee_profile_id_data.required.msj }}'; ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                    </b-container>

                </b-form>


                <button type="button"
                        class="btn btn-danger "
                        v-on:click="_cancel()"
                >
                    <?php echo '{{ labelsConfig.buttons.cancel }}'; ?>
                </button>


                <button type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo '{{ labelsConfig.buttons.save }}'; ?>
                </button>
            </div>

        </b-modal>


    </div>

</script>

<script type="text/x-template" id="human-resources-department-template">
    <div>
        <div v-if="configModalBusinessByEmployeeProfile.viewAllow">

            <business-by-employee-profile-component

                ref="refBusinessByEmployeeProfile"
                :params="configModalBusinessByEmployeeProfile"


            ></business-by-employee-profile-component>
        </div>
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
                <table id="human-resources-department-grid"
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

                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('name',$v.model.attributes.name)">
                                <label class="form__label " v-html='getLabelForm("name")' ></label>
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
                    </b-row>
                    <b-row>
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('description',$v.model.attributes.description)"
                            >

                                <label class="form__label " v-html='getLabelForm("description")' ></label>

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
