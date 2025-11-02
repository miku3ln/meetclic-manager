<script type='text/x-template' id='project-header-by-resources-template'>
    <div>

        <div id='content-component'>
            <b-modal
                hide-footer
                id="modal-project-header-by-resources"
                ref="refProjectHeaderByResourcesModal"
                size="xl"
                <?php echo '@show="_showModal"' ?><?php echo '@hidden="_hideModal"' ?><?php echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons">
                        <button
                            v-if="!managerMenuConfig.view"
                            type="button"
                            class="btn "
                            :class="{'btn-success':!showManager,'btn-danger':showManager}"
                            v-on:click="_viewManager(showManager?2:1)">
                            <?php echo "{{showManager?'Regresar':'Nuevo'}}" ?>    </button>
                        <button v-if="showManager" type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{labelsConfig.buttons.save}}' ?>    </button>

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

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="ProjectHeaderByResourcesForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >

                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('status',$v.model.attributes.status)">
                                            <label
                                                class="form__label " v-html='getLabelForm("status")' ></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.status.$model"
                                                        v-bind:id="getNameAttribute('status')"
                                                        v-bind:name="getNameAttribute('status')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                                >
                                                    <option v-for="(row,index) in statusData"
                                                            v-bind:value="row.id"><?php echo '{{row.text}}' ?>
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

                                </b-row>
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('type_multimedia',$v.model.attributes.type_multimedia)">
                                            <label
                                                class="form__label " v-html='getLabelForm("type_multimedia")' ></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.type_multimedia.$model"
                                                        v-bind:id="getNameAttribute('type_multimedia')"
                                                        v-bind:name="getNameAttribute('type_multimedia')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('type_multimedia', $v.model.attributes.type_multimedia.$model)"
                                                >
                                                    <option v-for="(row,index) in typeMultimediaData"
                                                            v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.type_multimedia.$error">
      <span v-if="!$v.model.attributes.type_multimedia.required">
       <?php echo "{{model.structure.type_multimedia.required.msj}}" ?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="4">
                                        <div class="manager-upload-data" v-if="managerUpload.type!=2">

                                            <input type="file" @change="handleFileUpload" :accept="getParamsUpload()">
                                            <div v-if="managerUpload.type==0 && managerUpload.urlManager"
                                                 class="manager-upload-data__content-img">


                                                <img v-if="managerUpload.type==0"
                                                     :src="getUrlManagerView(managerUpload.urlManager)"
                                                     alt="Uploaded Image"
                                                     class="manager-upload-data__img">

                                            </div>
                                            <div v-if="managerUpload.type==1 && managerUpload.urlManager"
                                                 class="manager-upload-data__content-documents">

                                                <a v-if="managerUpload.type==1"
                                                   :href="getUrlManagerView(managerUpload.urlManager)"
                                                   alt="Uploaded Image" target="_blank"
                                                   class="manager-upload-data__link">Descargar </a>

                                            </div>
                                            <div v-if="managerUpload.type==2 && managerUpload.urlManager"
                                                 class="manager-upload-data__content-documents">

                                                <a v-if="managerUpload.type==2"
                                                   :href="getUrlManagerView(managerUpload.urlManager)"
                                                   alt="Uploaded Image" target="_blank"
                                                   class="manager-upload-data__link">Ir </a>
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>

                                <b-row>

                                    <b-col md="6" v-if='managerUpload.type==2'>
                                        <div class="form-group"
                                             :class="getClassErrorForm('url',$v.model.attributes.url)">
                                            <label class="form__label " v-html='getLabelForm("url")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.url.$model"
                                                    type="text"
                                                    v-bind:id="getNameAttribute('url')"
                                                    v-bind:name="getNameAttribute('url')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('url', $v.model.attributes.url.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.url.$error">
      <span v-if="!$v.model.attributes.url.required">
       <?php echo "{{model.structure.url.required.msj}}" ?>
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
                                            <label
                                                class="form__label " v-html='getLabelForm("description")' ></label>
                                            <div class="content-element-form">

                                                <textarea
                                                    rows="10" cols="50"
                                                    v-focus-select
                                                    v-model.trim="$v.model.attributes.description.$model"
                                                    v-bind:id="getNameAttribute('description')"
                                                    v-bind:name="getNameAttribute('description')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('description', $v.model.attributes.description.$model)"
                                                ></textarea>
                                            </div>
                                            <div class="content-message-errors">
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

                <div class="content-manager-grid">

                    <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                        <table id="project-header-by-resources-grid"
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
            </b-modal>


        </div>
    </div>
</script>


<script type="text/x-template" id="project-header-template">
    <div>
        <div v-if="configModalProjectHeaderByResources.viewAllow">
            <project-header-by-resources-component
                ref="refProjectHeaderByResources"
                :params="configModalProjectHeaderByResources"
            >
            </project-header-by-resources-component>
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
                <table id="project-header-grid"
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
                        <b-col md="2">
                            <div class="form-group"
                                 :class="getClassErrorForm('status',$v.model.attributes.status)">
                                <label class="form__label " v-html='getLabelForm("status")' ></label>
                                <div class="content">


                                    <select v-model.trim="$v.model.attributes.status.$model"

                                            v-bind:id="getNameAttribute('status')"
                                            v-bind:name="getNameAttribute('status')"
                                            class="form-control m-input"
                                            @change="_setValueForm('type', $event.target.value)"

                                    >
                                        <option v-for="(typeRow,index) in dataStatus"
                                                v-bind:value="typeRow.id"><?php echo '{{typeRow.text}}' ?></option>
                                    </select>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.status.$error">
                                            <span v-if="!$v.model.attributes.status.required">
                                <?php echo "{{model.structure.status.required.msj}}" ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                    </b-row>
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
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('help_desk_human_resources_employee_profile_id_data',$v.model.attributes.help_desk_human_resources_employee_profile_id_data)">
                                <label
                                    class="form__label " v-html='getLabelForm("help_desk_human_resources_employee_profile_id_data")'></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.help_desk_human_resources_employee_profile_id_data.$model"
                                           v-bind:id="getNameAttribute('help_desk_human_resources_employee_profile_id_data')"
                                           v-bind:name="getNameAttribute('help_desk_human_resources_employee_profile_id_data')"
                                           @change="_setValueForm('help_desk_human_resources_employee_profile_id_data', $event.target.value)"
                                    >
                                    <select
                                        id="help_desk_human_resources_employee_profile_id_data"
                                        class="form-control m-select2 help_desk_human_resources_employee_profile_id_data select2-container-modal"
                                        v-initS2="{model:model.attributes.id,onInitSelect2:onInitHelpDesk}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.help_desk_human_resources_employee_profile_id_data.$error">
                                            <span
                                                v-if="!$v.model.attributes.help_desk_human_resources_employee_profile_id_data.required">
                                <?php echo '{{ model.structure.help_desk_human_resources_employee_profile_id_data.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('administrator_human_resources_employee_profile_id_data',$v.model.attributes.administrator_human_resources_employee_profile_id_data)">
                                <label
                                    class="form__label " v-html='getLabelForm("administrator_human_resources_employee_profile_id_data")'></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.administrator_human_resources_employee_profile_id_data.$model"
                                           v-bind:id="getNameAttribute('administrator_human_resources_employee_profile_id_data')"
                                           v-bind:name="getNameAttribute('administrator_human_resources_employee_profile_id_data')"
                                           @change="_setValueForm('administrator_human_resources_employee_profile_id_data', $event.target.value)"
                                    >
                                    <select
                                        id="administrator_human_resources_employee_profile_id_data"
                                        class="form-control m-select2 administrator_human_resources_employee_profile_id_data select2-container-modal"
                                        v-initS2="{model:model.attributes.id,onInitSelect2:onInitAdministrator}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.administrator_human_resources_employee_profile_id_data.$error">
                                            <span
                                                v-if="!$v.model.attributes.administrator_human_resources_employee_profile_id_data.required">
                                <?php echo '{{ model.structure.administrator_human_resources_employee_profile_id_data.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('countries_id_data',$v.model.attributes.countries_id_data)">
                                <label
                                    class="form__label "  v-html='getLabelForm("countries_id_data")'></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.countries_id_data.$model"
                                           v-bind:id="getNameAttribute('countries_id_data')"
                                           v-bind:name="getNameAttribute('countries_id_data')"
                                           @change="_setValueForm('countries_id_data', $event.target.value)"
                                    >
                                    <select
                                        id="countries_id_data"
                                        class="form-control m-select2 countries_id_data select2-container-modal"
                                        v-initS2="{model:model.attributes.id,onInitSelect2:onInitCountries}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.countries_id_data.$error">
                                            <span v-if="!$v.model.attributes.countries_id_data.required">
                                <?php echo '{{ model.structure.countries_id_data.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('contractor_company_name',$v.model.attributes.contractor_company_name)">
                                <label
                                    class="form__label " v-html='getLabelForm("contractor_company_name")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.contractor_company_name.$model"

                                        v-bind:id="getNameAttribute('contractor_company_name')"
                                        v-bind:name="getNameAttribute('contractor_company_name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('contractor_company_name', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.contractor_company_name.$error">
                                            <span v-if="!$v.model.attributes.contractor_company_name.required">
                                <?php echo "{{model.structure.contractor_company_name.required.msj}}" ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('responsible_company_name',$v.model.attributes.responsible_company_name)">
                                <label
                                    class="form__label " v-html='getLabelForm("responsible_company_name")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.responsible_company_name.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('responsible_company_name')"
                                        v-bind:name="getNameAttribute('responsible_company_name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('responsible_company_name', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.responsible_company_name.$error">
                                            <span v-if="!$v.model.attributes.responsible_company_name.required">
                                <?php echo "{{model.structure.responsible_company_name.required.msj}}" ?>
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

{{--CPP-005 --}}
