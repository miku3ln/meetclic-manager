

<script type='text/x-template' id='template-chat-api-template'>
    <div>
        <div id="template-chat-api-manager">


            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h1>
                            Chat Facebook Configuración - <?php echo '{{labelProcess}}'?>.
                        </h1>
                    </div>

                </div>

                <b-form id="template-chat-api-form" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('allow',$v.model.attributes.allow)">
                                    <label
                                        class="form__label " v-html='getLabelForm("allow")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.allow.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('allow')"
                                            v-bind:name="getNameAttribute('allow')"
                                            class="form-control m-input"
                                            @change="_setValueForm('allow', $v.model.attributes.allow.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.allow.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('theme_color',$v.model.attributes.theme_color)">
                                    <label
                                        class="form__label " v-html='getLabelForm("theme_color")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.theme_color.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('theme_color')"
                                            v-bind:name="getNameAttribute('theme_color')"
                                            class="form-control m-input"
                                            @change="_setValueForm('theme_color', $v.model.attributes.theme_color.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.theme_color.$error">
      <span v-if="!$v.model.attributes.theme_color.required">
       <?php  echo "{{model.structure.theme_color.required.msj}}"?>
      </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('page_id',$v.model.attributes.page_id)">
                                    <label
                                        class="form__label " v-html='getLabelForm("page_id")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.page_id.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('page_id')"
                                            v-bind:name="getNameAttribute('page_id')"
                                            class="form-control m-input"
                                            @change="_setValueForm('page_id', $v.model.attributes.page_id.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.page_id.$error">
      <span v-if="!$v.model.attributes.page_id.required">
       <?php  echo "{{model.structure.page_id.required.msj}}"?>
      </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('logged_in_greeting',$v.model.attributes.logged_in_greeting)">
                                    <label
                                        class="form__label " v-html='getLabelForm("logged_in_greeting")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.logged_in_greeting.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('logged_in_greeting')"
                                            v-bind:name="getNameAttribute('logged_in_greeting')"
                                            class="form-control m-input"
                                            @change="_setValueForm('logged_in_greeting', $v.model.attributes.logged_in_greeting.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.logged_in_greeting.$error">
      <span v-if="!$v.model.attributes.logged_in_greeting.required">
       <?php  echo "{{model.structure.logged_in_greeting.required.msj}}"?>
      </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('logged_out_greeting',$v.model.attributes.logged_out_greeting)">
                                    <label
                                        class="form__label " v-html='getLabelForm("logged_out_greeting")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.logged_out_greeting.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('logged_out_greeting')"
                                            v-bind:name="getNameAttribute('logged_out_greeting')"
                                            class="form-control m-input"
                                            @change="_setValueForm('logged_out_greeting', $v.model.attributes.logged_out_greeting.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.logged_out_greeting.$error">
      <span v-if="!$v.model.attributes.logged_out_greeting.required">
       <?php  echo "{{model.structure.logged_out_greeting.required.msj}}"?>
      </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>

                    </b-container>
                    <div class="row">
                        <div class="col-md-6">

                            <button type="button"
                                    :disabled="!validateForm()"
                                    class="btn btn-success "
                                    v-on:click="_saveModel()">
                                <?php echo '{{labelProcess}}'?></button>
                        </div>
                    </div>
                </b-form>


            </div>
        </div>


    </div>

</script>


<script type='text/x-template' id='template-config-mailing-by-emails-template'>
    <div>
        <div id="information-template-config-mailing-by-emails">
            <b-popover
                id="manager-template-config-mailing-by-emails"
                target="popover-template-config-mailing-by-emails"
                triggers="click"
                :show.sync="popoverShow"
                placement="auto"
                container="template-config-mailing-by-emails"
                ref="refPopoverTemplateConfigMailingByEmails"

            <?php  echo '  @show="onShow"      @shown="onShown"     @hidden="onHidden"'?>
            >
                <template v-slot:title>
                    <b-button @click="onClose" class="close" aria-label="Close">
                        <span class="d-inline-block" aria-hidden="true">&times;</span>
                    </b-button>
                    Correos Contáctanos
                </template>

                <div>

                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('type',$v.model.attributes.type)">
                                <label
                                    class="form__label " v-html='getLabelForm("type")' ></label>
                                <div class="content-element-form">
                                    <select v-model.trim="$v.model.attributes.type.$model"
                                            v-bind:id="getNameAttribute('type')"
                                            v-bind:name="getNameAttribute('type')"
                                            class="form-control m-input"
                                            @change="_setValueForm('type', $v.model.attributes.type.$model)"
                                    >
                                        <option v-for="(row,index) in dataTemplateConfigMailingByEmailsTypes"
                                                v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="content-message-errors">

                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('email',$v.model.attributes.email)">
                                <label class="form__label " v-html='getLabelForm("email")' ></label>
                                <div class="content-element-form">
                                    <input
                                        v-model.trim="$v.model.attributes.email.$model"
                                        type="email"
                                        v-bind:id="getNameAttribute('email')"
                                        v-bind:name="getNameAttribute('email')"
                                        class="form-control m-input"
                                        @change="_setValueForm('email', $v.model.attributes.email.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.email.$error">
      <span v-if="!$v.model.attributes.email.required">
       <?php  echo "{{model.structure.email.required.msj}}"?>
      </span>
                                        <span v-if="!$v.model.attributes.email.maxLength">
       <?php  echo "{{model.structure.email.maxLength.msj}}"?>
      </span>
                                        <span v-if="!$v.model.attributes.email.email">
       <?php  echo "Email no valido.!"?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>

                    <b-button @click="onClose" size="sm" variant="danger">Cancel</b-button>
                    <b-button @click="_saveModel" size="sm"
                              :disabled="!validateForm()"
                              variant="primary"><?php echo "{{model.attributes.id?'Actualizar':'Creacion'}}"?></b-button>
                </div>
            </b-popover>

            <div class="card card-body">
                <div class="row"
                     ref="refPopoverTemplateConfigMailingByEmailsCard">
                    <div class="col-md-12">
                        <h1>Correos Contáctanos
                            <button class="btn btn-icon waves-effect waves-light btn-success"
                                    id="popover-template-config-mailing-by-emails"><i class=" fas fa-plus-square"></i>
                            </button>
                        </h1>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div v-if="!showManager">
                            <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                                <menu-admin-grid
                                    @input="_managerRowGrid($event)"
                                    :manager-menu-config="managerMenuConfig" >

                                </menu-admin-grid>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="content-manager-grid">

                            <div class="custom-scroll-admin-grid table-responsive">
                                <table id="template-config-mailing-by-emails-grid"
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
                    </div>
                </div>
            </div>
        </div>


    </div>

</script>


<script type='text/x-template' id='information-social-network-template'>
    <div>
        <div class="row" id="information-information-social-network">
            <div class="col-md-12">


                <div class="card card-body "
                     ref="refPopoverInformationSocialNetworkCard">
                    <h1>Redes Sociales
                        <button class="btn btn-icon waves-effect waves-light btn-success"
                                id="popover-information-social-network"><i class=" fas fa-plus-square"></i></button>
                    </h1>


                    <div v-if="dataInformationSocialNetwork.lenght==0">
                        No existe ninguna red Social.
                    </div>
                    <div v-else>


                        <table class="content-rows-manager">

                            <tbody>

                            <tr v-for="(socialNetwork, key) in dataInformationSocialNetwork">
                                <th>
                                    <a v-bind:href="socialNetwork.value" target="_blank">
                                        <i
                                            v-bind:class="socialNetwork.icon"></i> <?php echo '{{socialNetwork.value}}'?>
                                    </a>
                                </th>
                                <th>


                                    <button
                                        v-on:click="_editSocialNetwork(socialNetwork)"
                                        class="btn btn-icon waves-effect waves-light btn-info"
                                    ><i class="fas fa-pencil-alt"></i></button>
                                    <button
                                        v-on:click="_deleteSocialNetwork(socialNetwork)"
                                        class="btn btn-icon waves-effect waves-light btn-info"
                                    ><i class=" far fa-trash-alt"></i></button>
                                </th>
                            </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

            <!-- Our popover title and content render container -->
            <!-- We use placement 'auto' so popover fits in the best spot on viewport -->
            <!-- We specify the same container as the trigger button, so that popover is close to button -->
            <b-popover
                id="manager-information-social-network"
                target="popover-information-social-network"
                triggers="click"
                :show.sync="popoverShow"
                placement="auto"
                container="information-social-network"
                ref="refPopoverInformationSocialNetwork"

            <?php  echo '  @show="onShow"      @shown="onShown"     @hidden="onHidden"'?>
            >
                <template v-slot:title>
                    <b-button @click="onClose" class="close" aria-label="Close">
                        <span class="d-inline-block" aria-hidden="true">&times;</span>
                    </b-button>
                    Redes Sociales
                </template>

                <div>

                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('information_social_network_type_id',$v.model.attributes.information_social_network_type_id)">
                                <label
                                    class="form__label " v-html='getLabelForm("information_social_network_type_id")' ></label>
                                <div class="content-element-form">
                                    <select v-model.trim="$v.model.attributes.information_social_network_type_id.$model"
                                            v-bind:id="getNameAttribute('information_social_network_type_id')"
                                            v-bind:name="getNameAttribute('information_social_network_type_id')"
                                            class="form-control m-input"
                                            @change="_setValueForm('information_social_network_type_id', $v.model.attributes.information_social_network_type_id.$model)"
                                    >
                                        <option v-for="(row,index) in dataInformationSocialNetworkTypes"
                                                v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                        </option>
                                    </select>
                                </div>
                                <div class="content-message-errors">

                                </div>
                            </div>

                        </b-col>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('value',$v.model.attributes.value)">
                                <label class="form__label " v-html='getLabelForm("value")' ></label>
                                <div class="content-element-form">
                                    <input
                                        v-model.trim="$v.model.attributes.value.$model"
                                        type="url"
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
                                        <span v-if="!$v.model.attributes.value.url">
       <?php  echo "Url no correcta.!"?>
      </span>
                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>

                    <b-button @click="onClose" size="sm" variant="danger">Cancel</b-button>
                    <b-button @click="_saveModel" size="sm"
                              :disabled="!validateForm()"
                              variant="primary"><?php echo "{{model.attributes.id?'Actualizar':'Creacion'}}"?></b-button>
                </div>
            </b-popover>
        </div>
    </div>

</script>

<script type='text/x-template' id='business-information-template'>
    <div>
        <div class="row" id="information-business">
            <div class="col-md-12">


                <div class="card card-body card-body--manager" id="popover-information-business"
                     ref="refPopoverBusinessInformation">
                    <h5 class="card-title">Dirección <i class="fas fa-map-marker-alt"></i></h5>
                    <p class="card-text"><?php echo '{{modelView.street_1+" y "+modelView.street_2}}'; ?></p>
                    <h5 class="card-title">Telefono <i class=" fas fa-phone"></i></h5>
                    <p class="card-text"><?php echo '{{modelView.phone_value}}'; ?></p>
                    <h5 class="card-title">Email <i class=" remixicon-mail-open-line"></i></h5>
                    <p class="card-text"><?php echo '{{modelView.email}}'; ?></p>
                </div>
            </div>

            <!-- Our popover title and content render container -->
            <!-- We use placement 'auto' so popover fits in the best spot on viewport -->
            <!-- We specify the same container as the trigger button, so that popover is close to button -->
            <b-popover
                id="manager-business-information"
                target="popover-information-business"
                triggers="click"
                :show.sync="popoverShow"
                placement="auto"
                container="information-business"
                ref="refPopoverBusinessInformation"

            <?php  echo '  @show="onShow"      @shown="onShown"     @hidden="onHidden"'?>
            >
                <template v-slot:title>
                    <b-button @click="onClose" class="close" aria-label="Close">
                        <span class="d-inline-block" aria-hidden="true">&times;</span>
                    </b-button>
                    Empresa Información
                </template>

                <div>

                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('email',$v.model.attributes.email)">
                                <label class="form__label " v-html='getLabelForm("email")' ></label>
                                <div class="content-element-form">
                                    <input
                                        v-model.trim="$v.model.attributes.email.$model"
                                        type="email"
                                        v-bind:id="getNameAttribute('email')"
                                        v-bind:name="getNameAttribute('email')"
                                        class="form-control m-input"
                                        @change="_setValueForm('email', $v.model.attributes.email.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.email.$error">
      <span v-if="!$v.model.attributes.email.required">
       <?php  echo "{{model.structure.email.required.msj}}"?>
      </span>


                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('phone_value',$v.model.attributes.phone_value)">
                                <label class="form__label " v-html='getLabelForm("phone_value")' ></label>
                                <div class="content-element-form">
                                    <input
                                        v-model.trim="$v.model.attributes.phone_value.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('phone_value')"
                                        v-bind:name="getNameAttribute('phone_value')"
                                        class="form-control m-input"
                                        @change="_setValueForm('phone_value', $v.model.attributes.phone_value.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.phone_value.$error">
      <span v-if="!$v.model.attributes.phone_value.required">
       <?php  echo "{{model.structure.phone_value.required.msj}}"?>
      </span>


                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>

                    <h1>Dirección</h1>
                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('street_1',$v.model.attributes.street_1)">
                                <label class="form__label " v-html='getLabelForm("street_1")' ></label>
                                <div class="content-element-form">
                                    <input
                                        v-model.trim="$v.model.attributes.street_1.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('street_1')"
                                        v-bind:name="getNameAttribute('street_1')"
                                        class="form-control m-input"
                                        @change="_setValueForm('street_1', $v.model.attributes.street_1.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.street_1.$error">
      <span v-if="!$v.model.attributes.street_1.required">
       <?php  echo "{{model.structure.street_1.required.msj}}"?>
      </span>


                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('street_2',$v.model.attributes.street_2)">
                                <label class="form__label " v-html='getLabelForm("street_2")' ></label>
                                <div class="content-element-form">
                                    <input
                                        v-model.trim="$v.model.attributes.street_2.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('street_2')"
                                        v-bind:name="getNameAttribute('street_2')"
                                        class="form-control m-input"
                                        @change="_setValueForm('street_2', $v.model.attributes.street_2.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.street_2.$error">
      <span v-if="!$v.model.attributes.street_2.required">
       <?php  echo "{{model.structure.street_2.required.msj}}"?>
      </span>


                                    </b-form-invalid-feedback>
                                </div>
                            </div>

                        </b-col>
                    </b-row>

                    <b-button @click="onClose" size="sm" variant="danger">Cancel</b-button>
                    <b-button @click="_saveModel" size="sm"
                              :disabled="!validateForm()"
                              variant="primary"><?php echo "{{model.attributes.id?'Actualizar':'Creacion'}}"?></b-button>
                </div>
            </b-popover>
        </div>
    </div>

</script>

<script type='text/x-template' id='contact-us-template'>
    <div>


        <div class='content-component'>


            <b-container class="container-manager-contact-us" v-if="initManager">


                <map-component ref='refMap'
                               :params='configDataMap'
                               v-on:_map-emit="_updateValuesMap($event)">

                </map-component>

                <business-information-component ref='refBusinessInformation'
                                                :params='configDataBusinessInformation'
                                                v-on:_businessInformation-emit="_updateValuesMap($event)">

                </business-information-component>
                <information-social-network-component ref='refInformationSocialNetwork'
                                                      :params='configDataInformationSocialNetwork'
                                                      v-on:_informationSocialNetwork-emit="_updateValuesMap($event)">

                </information-social-network-component>


                <template-config-mailing-by-emails-component ref='refTemplateConfigMailingByEmails'
                                                             :params='configDataTemplateConfigMailingByEmails'
                                                             v-on:_templateConfigMailingByEmails-emit="_updateValuesMap($event)">

                </template-config-mailing-by-emails-component>


                <template-chat-api-component
                    ref='refTemplateChatApi'
                    :params='configDataTemplateChatApi'
                    v-on:_templateChatApi-emit="_updateValuesMap($event)">

                </template-chat-api-component>

            </b-container>
            <b-container v-if="!initManager">
                <b-row>
                    Cargando....
                </b-row>
            </b-container>
        </div>
    </div>
</script>

