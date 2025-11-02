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
                            <b-col lg="5">

                                <div class="form-group"
                                     :class="getClassErrorForm('status',$v.model.attributes.status)">
                                    <label class="form__label"
                                           v-bind:for="getNameAttribute('status')"  v-html='getLabelForm("status")'></label>
                                    <div class="toggle">
                                        <input
                                            v-model="$v.model.attributes.status.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('status')"
                                            v-bind:name="getNameAttribute('status')"
                                            @change="_setValueForm('status',$v.model.attributes.status.$model)"

                                        >
                                        <label v-bind:for="getNameAttribute('status')">
                                            <div class="toggle__switch"></div>
                                        </label>
                                    </div>

                                </div>
                            </b-col>
                        </b-row>
                        <b-row>

                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('role_id_data',$v.model.attributes.role_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("role_id_data")' ></label>
                                    <div class="content">
                                        <input type="hidden"
                                               v-model.trim="$v.model.attributes.role_id_data.$model"
                                               v-bind:id="getNameAttribute('role_id_data')"
                                               v-bind:name="getNameAttribute('role_id_data')"
                                               @change="_setValueForm('role_id_data', $event.target.value)"
                                        >
                                        <select
                                            id="role_id_data"
                                            class="form-control m-select2 role_id_data select2-container-modal"
                                            v-initS2="{model:model.attributes.id,_managerS2Roles:_managerS2Roles}"
                                        >
                                        </select>


                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.role_id_data.$error">
                                            <span v-if="!$v.model.attributes.role_id_data.required">
                                <?php echo '{{ model.structure.role_id_data.required.msj }}'; ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>

                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('username',$v.model.attributes.username)">
                                    <label class="form__label " v-html='getLabelForm("username")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.username.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('username')"
                                            v-bind:name="getNameAttribute('username')"
                                            class="form-control m-input"
                                            @change="_setValueForm('username', $v.model.attributes.username.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.username.$error">
                                            <span v-if="!$v.model.attributes.username.required">
                                <?php echo '{{ model.structure.username.required.msj }}'; ?>
                            </span>
                                            <span v-if="!$v.model.attributes.username.isUnique">
                                <?php echo 'Usuario ya existente.'; ?>
                            </span>


                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>

                        </b-row>


                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('email',$v.model.attributes.email)">
                                    <label class="form__label " v-html='getLabelForm("email")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.email.$model"
                                            v-bind:id="getNameAttribute('email')"
                                            v-bind:name="getNameAttribute('email')"
                                            class="form-control m-input"
                                            @change="_setValueForm('email', $v.model.attributes.email.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.email.$error">
                                            <span v-if="!$v.model.attributes.email.required">
                                <?php echo '{{ model.structure.email.required.msj }}'; ?>
                            </span>
                                            <span v-if="!$v.model.attributes.email.isUnique">
                                <?php echo 'Email ya existente.'; ?>
                            </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="12" v-if="!createUpdate">
                                <div class="form-group"
                                     :class="getClassErrorForm('password',$v.model.attributes.password)">
                                    <label class="form__label " v-html='getLabelForm("password")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.password.$model"
                                            v-bind:id="getNameAttribute('password')"
                                            v-bind:name="getNameAttribute('password')"
                                            class="form-control m-input"
                                            @change="_setValueForm('password', $v.model.attributes.password.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.password.$error">
                                            <span v-if="!$v.model.attributes.password.required">
                                <?php echo '{{ model.structure.email.required.msj }}'; ?>

                            </span>
                                            <span v-if="!$v.model.attributes.password.minLength">
                                <?php echo 'Password debe tener por lo menos 6 caracteres.'; ?>

                            </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="12" v-if="!createUpdate">
                                <div class="form-group"
                                     :class="getClassErrorForm('password_repeat',$v.model.attributes.password_repeat)">
                                    <label
                                        class="form__label " v-html='getLabelForm("password_repeat")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.password_repeat.$model"
                                            v-bind:id="getNameAttribute('password_repeat')"
                                            v-bind:name="getNameAttribute('password_repeat')"
                                            class="form-control m-input"
                                            @change="_setValueForm('password_repeat', $v.model.attributes.password_repeat.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.password_repeat.$error">
                                            <span v-if="!$v.model.attributes.password_repeat.required">
                                <?php echo '{{ !$v.model.attributes.password.sameAsPassword?"No son iguales las contraseñas.": model.structure.email.required.msj }}'; ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>

                        <b-row v-if="createUpdate">
                            <b-col lg="5">

                                <div class="form-group"
                                     :class="getClassErrorForm('change_password',$v.model.attributes.change_password)">
                                    <label class="form__label"
                                           v-bind:for="getNameAttribute('change_password')" v-html='getLabelForm("change_password")' ></label>
                                    <div class="toggle">
                                        <input
                                            v-model="$v.model.attributes.change_password.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('change_password')"
                                            v-bind:name="getNameAttribute('change_password')"
                                            @change="_setValueForm('change_password',$v.model.attributes.change_password.$model)"

                                        >
                                        <label v-bind:for="getNameAttribute('change_password')">
                                            <div class="toggle__switch"></div>
                                        </label>
                                    </div>

                                </div>
                            </b-col>
                        </b-row>

                        <b-row v-if="createUpdate && $v.model.attributes.change_password.$model==true">


                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('password_old',$v.model.attributes.password_old)">
                                    <label
                                        class="form__label " v-html='getLabelForm("password_old")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.password_old.$model"
                                            v-bind:id="getNameAttribute('password_old')"
                                            v-bind:name="getNameAttribute('password_old')"
                                            class="form-control m-input"
                                            @change="_setValueForm('password_old', $v.model.attributes.password_old.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.password_old.$error">
                                            <span v-if="!$v.model.attributes.password_old.required">
                                <?php echo '{{ model.structure.email.required.msj }}'; ?>
                            </span>

                                            <span v-if="!$v.model.attributes.password_old.isUnique">
                                <?php echo 'Password no coincide con la anterior.'; ?>
                            </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('password_new',$v.model.attributes.password_new)">
                                    <label
                                        class="form__label " v-html='getLabelForm("password_new")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.password_new.$model"
                                            v-bind:id="getNameAttribute('password_new')"
                                            v-bind:name="getNameAttribute('password_new')"
                                            class="form-control m-input"
                                            @change="_setValueForm('password_new', $v.model.attributes.password_new.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.password_new.$error">
                                            <span v-if="!$v.model.attributes.password_new.required">
                                <?php echo '{{ model.structure.password_new.required.msj }}'; ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('password_repeat',$v.model.attributes.password_repeat)">
                                    <label
                                        class="form__label " v-html='getLabelForm("password_repeat")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.password_repeat.$model"
                                            v-bind:id="getNameAttribute('password_repeat')"
                                            v-bind:name="getNameAttribute('password_repeat')"
                                            class="form-control m-input"
                                            @change="_setValueForm('password_repeat', $v.model.attributes.password_repeat.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.password_repeat.$error">
                                            <span v-if="!$v.model.attributes.password_repeat.required">
                                                           <?php echo '{{ !$v.model.attributes.password_new.sameAsPassword?"No son iguales las contraseñas.": model.structure.password_new.required.msj }}'; ?>

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


<script type="text/x-template" id="human-resources-employee-profile-template">
    <div>


        <div v-if="configModalInformationMail.viewAllow">
            <information-mail-component
                ref="refInformationMail"
                :params="configModalInformationMail"
            >
            </information-mail-component>
        </div>
        <div v-if="configModalInformationSocialNetwork.viewAllow">
            <information-social-network-component
                ref="refInformationSocialNetwork"
                :params="configModalInformationSocialNetwork"
            >
            </information-social-network-component>
        </div>
        <div v-if="configModalInformationPhone.viewAllow">
            <information-phone-component
                ref="refInformationPhone"
                :params="configModalInformationPhone"
            >
            </information-phone-component>
        </div>
        <div v-if="configModalInformationAddress.viewAllow">
            <information-address-component
                ref="refInformationAddress"
                :params="configModalInformationAddress"
            >
            </information-address-component>
        </div>

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
                    <?php echo "{{ showManager?'Regresar':'Nuevo' }}"; ?>
                </button>


                <button v-if="showManager" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo '{{ lblBtnSave }}'; ?>
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
                <table id="human-resources-employee-profile-grid"
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

            <b-form id="human-resources-employee-profileForm" v-on:submit.prevent="_submitForm">

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >

                <b-container>
                    <b-row>
                        <b-col md="6">
                            <label
                                class="form__label " v-html='getLabelForm("source")' ></label>
                            <div class=" content-box-image content-box-preview"
                                 id="manager-source"
                                 :class="getClassErrorForm('source',$v.model.attributes.source)">
                                <img class="content-box-image__preview" id="preview-source">
                                <div class="content-element-form">
                                    <input
                                        v-initEventUploadSource="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                        type="file" id="file-source"
                                        v-bind:name="getNameAttribute('source')">
                                </div>
                                <div class="progress-gallery-image not-view" id="progress-source">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.source.$error">
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="2" class="not-view">
                            <div class="form-group"
                                 :class="getClassErrorForm('allow_view_page_web',$v.model.attributes.allow_view_page_web)">
                                <label
                                    class="form__label " v-html='getLabelForm("allow_view_page_web")' ></label>
                                <div class="content">

                                    <select

                                        v-bind:id="getNameAttribute('allow_view_page_web')"
                                        v-bind:name="getNameAttribute('allow_view_page_web')"
                                        class="form-control m-input"
                                        @change="_setValueForm('allow_view_page_web',$v.model.attributes.allow_view_page_web.$model)"
                                        v-model.trim="$v.model.attributes.allow_view_page_web.$model"


                                    >
                                        <option v-for="(row,index) in model.structure.allow_view_page_web.options"
                                                v-bind:value="row.value"><?php echo '{{ row.text }}'; ?>
                                        </option>
                                    </select>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.allow_view_page_web.$error">
                                            <span
                                                v-if="!$v.model.attributes.allow_view_page_web.required">
                                <?php echo '{{ model.structure.allow_view_page_web.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('human_resources_organizational_chart_area_id_data',$v.model.attributes.human_resources_organizational_chart_area_id_data)">
                                <label
                                    class="form__label " v-html='getLabelForm("human_resources_organizational_chart_area_id_data")'></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.human_resources_organizational_chart_area_id_data.$model"
                                           v-bind:id="getNameAttribute('human_resources_organizational_chart_area_id_data')"
                                           v-bind:name="getNameAttribute('human_resources_organizational_chart_area_id_data')"
                                           @change="_setValueForm('human_resources_organizational_chart_area_id_data', $event.target.value)"
                                    >
                                    <select
                                        id="human_resources_organizational_chart_area_id_data"
                                        class="form-control m-select2 human_resources_organizational_chart_area_id_data "
                                        v-initS2AreaList2="{model:model.attributes.id,onEvent:onAreaList2}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.human_resources_organizational_chart_area_id_data.$error">
                                            <span
                                                v-if="!$v.model.attributes.human_resources_organizational_chart_area_id_data.required">
                                <?php echo '{{ model.structure.human_resources_organizational_chart_area_id_data.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('human_resources_department_id_data',$v.model.attributes.human_resources_department_id_data)">
                                <label
                                    class="form__label " v-html='getLabelForm("human_resources_department_id_data")'></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.human_resources_department_id_data.$model"
                                           v-bind:id="getNameAttribute('human_resources_department_id_data')"
                                           v-bind:name="getNameAttribute('human_resources_department_id_data')"
                                           @change="_setValueForm('human_resources_department_id_data', $event.target.value)"
                                    >
                                    <select
                                        id="human_resources_department_id_data"
                                        class="form-control m-select2 human_resources_department_id_data "
                                        v-initS2="{model:model.attributes.id,_managerS2Departments:_managerS2Departments}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.human_resources_department_id_data.$error">
                                            <span
                                                v-if="!$v.model.attributes.human_resources_department_id_data.required">
                                <?php echo '{{ model.structure.human_resources_department_id_data.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('human_resources_schedule_type_id_data',$v.model.attributes.human_resources_schedule_type_id_data)">
                                <label
                                    class="form__label " v-html='getLabelForm("human_resources_schedule_type_id_data")'></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.human_resources_schedule_type_id_data.$model"
                                           v-bind:id="getNameAttribute('human_resources_schedule_type_id_data')"
                                           v-bind:name="getNameAttribute('human_resources_schedule_type_id_data')"
                                           @change="_setValueForm('human_resources_schedule_type_id_data', $event.target.value)"
                                    >
                                    <select
                                        id="human_resources_schedule_type_id_data"
                                        class="form-control m-select2 human_resources_schedule_type_id_data "
                                        v-initS2ScheduleList2="{model:model.attributes.id,onEvent:onScheduleList2}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.human_resources_schedule_type_id_data.$error">
                                            <span
                                                v-if="!$v.model.attributes.human_resources_schedule_type_id_data.required">
                                <?php echo '{{ model.structure.human_resources_schedule_type_id_data.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    </b-row>


                    </b-row>


                    <b-row v-if="false">
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('business_name',$v.model.attributes.business_name)">
                                <label class="form__label " v-html='getLabelForm("business_name")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.business_name.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('business_name')"
                                        v-bind:name="getNameAttribute('business_name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('business_name', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.business_name.$error">
                                            <span v-if="!$v.model.attributes.business_name.required">
                                <?php echo '{{ model.structure.business_name.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('business_reason',$v.model.attributes.business_reason)">
                                <label
                                    class="form__label " v-html='getLabelForm("business_reason")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.business_reason.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('business_reason')"
                                        v-bind:name="getNameAttribute('business_reason')"
                                        class="form-control m-input"
                                        @change="_setValueForm('business_reason', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.business_reason.$error">
                                            <span v-if="!$v.model.attributes.business_reason.required">
                                <?php echo '{{ model.structure.business_reason.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('people_nationality_id_data',$v.model.attributes.people_nationality_id_data)">
                                <label
                                    class="form__label " v-html='getLabelForm("people_nationality_id_data")' ></label>
                                <div class="content">

                                    <select

                                        v-bind:id="getNameAttribute('people_nationality_id_data')"
                                        v-bind:name="getNameAttribute('people_nationality_id_data')"
                                        class="form-control m-input"
                                        v-model.trim="$v.model.attributes.people_nationality_id_data.$model"


                                    >
                                        <option v-for="(row,index) in peopleNationalityData"
                                                v-bind:value="row.value"><?php echo '{{ row.text }}'; ?></option>
                                    </select>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.people_nationality_id_data.$error">
                                            <span v-if="!$v.model.attributes.people_nationality_id_data.required">
                                <?php echo '{{ model.structure.people_nationality_id_data.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('people_profession_id',$v.model.attributes.people_profession_id)">
                                <label
                                    class="form__label " v-html='getLabelForm("people_profession_id")' ></label>
                                <div class="content">

                                    <select

                                        v-bind:id="getNameAttribute('people_profession_id')"
                                        v-bind:name="getNameAttribute('people_profession_id')"
                                        class="form-control m-input"
                                        @change="_setValueForm('people_profession_id', $v.model.attributes.people_profession_id.$model)"
                                        v-model.trim="$v.model.attributes.people_profession_id.$model"


                                    >
                                        <option v-for="(row,index) in peopleProfessionData"
                                                v-bind:value="row.value"><?php echo '{{ row.text }}'; ?></option>
                                    </select>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.people_profession_id.$error">
                                            <span v-if="!$v.model.attributes.people_profession_id.required">
                                <?php echo '{{ model.structure.people_profession_id.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('gender_data',$v.model.attributes.gender_data)">
                                <label class="form__label " v-html='getLabelForm("gender_data")' ></label>
                                <div class="content">

                                    <select

                                        v-bind:id="getNameAttribute('gender_data')"
                                        v-bind:name="getNameAttribute('gender_data')"
                                        class="form-control m-input"
                                        @change="_setValueForm('gender_data',$v.model.attributes.gender_data.$model)"
                                        v-model.trim="$v.model.attributes.gender_data.$model"


                                    >
                                        <option v-for="(row,index) in genderData"
                                                v-bind:value="row.value"><?php echo '{{ row.text }}'; ?></option>
                                    </select>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.gender_data.$error">
                                            <span v-if="!$v.model.attributes.gender_data.required">
                                <?php echo '{{ model.structure.gender_data.required.msj }}'; ?>
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
                                <label v-if="model.attributes.allow_view_page_web == typeIdentificationRuc"
                                    class="form__label " v-html='getLabelForm("name")' >

                                </label>
                                <label v-if="model.attributes.allow_view_page_web != typeIdentificationRuc"
                                       class="form__label " v-html='getLabelForm("name")' >

                                </label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.name.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('name')"
                                        v-bind:name="getNameAttribute('name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('name', $v.model.attributes.name.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.name.$error">
                                            <span v-if="!$v.model.attributes.name.required">
                                <?php echo '{{ model.structure.name.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('last_name',$v.model.attributes.last_name)">
                                <label
                                    class="form__label "  v-html='getLabelForm("last_name")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.last_name.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('last_name')"
                                        v-bind:name="getNameAttribute('last_name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('last_name',$v.model.attributes.last_name.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.last_name.$error">
                                            <span v-if="!$v.model.attributes.last_name.required">
                                <?php echo '{{ model.structure.last_name.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('identification_document',$v.model.attributes.identification_document)">
                                <label
                                    class="form__label " v-html='getLabelForm("identification_document")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.identification_document.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('identification_document')"
                                        v-bind:name="getNameAttribute('identification_document')"
                                        class="form-control m-input"
                                        @change="_setValueForm('identification_document',$v.model.attributes.identification_document.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.identification_document.$error">
                                            <span v-if="!$v.model.attributes.identification_document.required">
                                <?php echo '{{ model.structure.identification_document.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('date_of_birth',$v.model.attributes.date_of_birth)">
                                <label class="form__label " v-html='getLabelForm("date_of_birth")' ></label>
                                <div class="content">
                                    <date-time-picker
                                        v-model.trim="$v.model.attributes.date_of_birth.$model"
                                        v-bind:id="getNameAttribute('date_of_birth')"
                                        v-bind:name="getNameAttribute('date_of_birth')"
                                        @change="_setValueForm('date_of_birth', $v.model.attributes.date_of_birth.$model)"
                                        format="dd-LL-yyyy"
                                        locale="es"
                                        :auto-close="true"

                                    ></date-time-picker>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.date_of_birth.$error">
                                            <span v-if="!$v.model.attributes.date_of_birth.required">
                                <?php echo '{{ model.structure.date_of_birth.required.msj }}'; ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="4">
                            <div class="form-group"
                                 :class="getClassErrorForm('contract_date',$v.model.attributes.contract_date)">
                                <label class="form__label " v-html='getLabelForm("contract_date")' ></label>
                                <div class="content">
                                    <date-time-picker
                                        v-model.trim="$v.model.attributes.contract_date.$model"
                                        v-bind:id="getNameAttribute('contract_date')"
                                        v-bind:name="getNameAttribute('contract_date')"
                                        @change="_setValueForm('contract_date', $v.model.attributes.contract_date.$model)"

                                        format="dd-LL-yyyy"
                                        locale="es"
                                        :auto-close="true"

                                    ></date-time-picker>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.contract_date.$error">
                                            <span v-if="!$v.model.attributes.contract_date.required">
                                <?php echo '{{ model.structure.contract_date.required.msj }}'; ?>
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
    style="display: none;"
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
                                    <div class="description" id="description"
                                         v-initSummerNote="{initMethod:_initSummerNote}"></div>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.description.$error">
      <span v-if="!$v.model.attributes.description.required">
       <?php echo '{{ model.structure.description.required.msj }}'; ?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>
                    <b-row v-if="model.attributes.allow_view_page_web">
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('summary_web',$v.model.attributes.summary_web)">
                                <label class="form__label " v-html='getLabelForm("summary_web")' ></label>
                                <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.summary_web.$model"
    v-bind:id="getNameAttribute('summary_web')"
    v-bind:name="getNameAttribute('summary_web')"
    @change="_setValueForm('summary_web', $v.model.attributes.summary_web.$model)"
    v-focus-select
></textarea>

                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.summary_web.$error">
      <span v-if="!$v.model.attributes.summary_web.required">
       <?php echo '{{ model.structure.summary_web.required.msj }}'; ?>
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
