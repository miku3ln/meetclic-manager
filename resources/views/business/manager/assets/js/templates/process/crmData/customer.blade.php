<script type="text/x-template" id="customer-template">
    <div>
        {{--
        ---COMPONENTS ENTITY--}}
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
        <div v-if="configModalMailingByDataSend.viewAllow">
            <mailing-by-data-send-component
                ref="refMailingByDataSend"
                :params="configModalMailingByDataSend"
            >
            </mailing-by-data-send-component>
        </div>
        <div v-if="configModalEventByAssistance.viewAllow">
            <event-by-assistance-component
                ref="refEventByAssistance"
                :params="configModalEventByAssistance"
            >
            </event-by-assistance-component>
        </div>
        <b-container class="bv-example-row" v-if="managerCustomerSearch.view==false">
            <div class="content-row-manager-buttons">

                <button
                    v-if="!managerMenuConfig.view"
                    type="button"
                    class="btn "
                    :class="{'btn-success':!showManager,'btn-danger':showManager}"
                    v-on:click="_viewManager(showManager?2:1)">
                    <?php echo "{{showManager?'Regresar':'Nuevo'}}"?>
                </button>
                <button v-if="showManager" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo "{{lblBtnSave}}"?>
                </button>
                <button

                    type="button"
                    class="btn btn-info"
                    v-on:click="_managementSenMail(1)">
                    Gestion de Envios
                </button>
                <button

                    type="button"
                    class="btn btn-info"
                    v-on:click="_managementEventAssistance(1)">
                    Gestion de Asistencia
                </button>
                <div v-if="!showManager">
                    <div class="content-manager-buttons-grid ready" ng-if="managerMenuConfig.view">

                        <a
                            v-init-tool-tip
                            v-for="(menu, key) in managerMenuConfig.menuCurrent"
                            v-bind:id="'a-menu-'+menu.rowId"
                            v-on:click="_managerMenuGrid(key, menu)"
                            class="content-manager-buttons-grid__a " data-toggle="tooltip"
                            data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                            <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                        </a>
                    </div>
                </div>

            </div>
        </b-container>
        <div class="content-manager-grid" v-show="!managerCustomerSearch.view">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <table id="customer-grid"
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

            <b-form id="customerForm" v-on:submit.prevent="_submitForm">


                <b-container>
                    <div class="row">
                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm(-1,'count_add',$v.model.attributes.count_add)">
                                <label class="form__label " v-html='getLabelForm("count_add")' ></label>
                                <div class="content">
                                    <input
                                        v-model.trim="$v.model.attributes.count_add.$model"
                                        type="number"
                                        min="1"
                                        class="form-control m-input"
                                        @change="_setValueForm('count_add',$v.model.attributes.count_add.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.count_add.$error">
                                            <span v-if="!$v.model.attributes.count_add.required">
                                <?php  echo "{{model.structure.count_add.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </div>
                    <div class="alert alert-danger" v-if="!$v.model.attributes.customer.required">

                        Debe Existir por lo menos un Registro!
                    </div>
                    <div class="wrapper-customer" v-for="(v, index) in $v.model.attributes.customer.$each.$iter">
                        <div class="wrapper-customer__item">
                            <h1><?php echo "{{getLabelTitleRegister(index,v)}}" ?> </h1>
                            <div class="row">
                                <b-col md="4">
                                    <div class="form-group"
                                         :class="getClassErrorForm(index,'main',v.main)">
                                        <label
                                            class="form__label " v-html='getLabelForm("main")' ></label>
                                        <div class="toggle">
                                            <input
                                                v-model.trim="v.main.$model"
                                                v-bind:id="getNameAttributePeople(index,'payment_made')"
                                                type="checkbox"
                                                class=" m-input"
                                                @change="_setValueFormPeople(index,'main',$event.target.value,v.main)"
                                                v-focus-select
                                            >
                                            <label v-bind:for="getNameAttributePeople(index,'payment_made')">
                                                <div class="toggle__switch"></div>
                                            </label>
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!v.main.$error">
                                            <span v-if="!v.main.required">
                                <?php  echo "{{model.structure.customer.main.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                            </div>
                            <b-row>
                                <b-col md="4">
                                    <div class="form-group"
                                         :class="getClassErrorForm(index,'identification_document',v.identification_document)">
                                        <label
                                            class="form__label " v-html='getLabelForm("identification_document")' ></label>
                                        <div class="content">
                                            <input
                                                v-model.trim="v.identification_document.$model"
                                                type="text"
                                                class="form-control m-input"
                                                @change="_setValueFormPeople(index,'identification_document',$event.target.value,v.identification_document)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!v.identification_document.$error">
                                            <span v-if="!v.identification_document.required">
                                <?php  echo "{{model.structure.customer.identification_document.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="4">
                                    <div class="form-group"
                                         :class="getClassErrorForm(index,'name',v.name)">
                                        <label
                                            class="form__label " v-html='getLabelForm("name")' ></label>
                                        <div class="content">
                                            <input

                                                v-model.trim="v.name.$model"
                                                type="text"

                                                class="form-control m-input"
                                                @change="_setValueFormPeople(index,'name',$event.target.value,v.name)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!v.name.$error">
                                            <span v-if="!v.name.required">
                                <?php  echo "{{model.structure.customer.name.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="4">
                                    <div class="form-group"
                                         :class="getClassErrorForm(index,'last_name',v.last_name)">
                                        <label
                                            class="form__label " v-html='getLabelForm("last_name")' ></label>
                                        <div class="content">
                                            <input
                                                v-model.trim="v.last_name.$model"
                                                type="text"

                                                class="form-control m-input"
                                                @change="_setValueFormPeople(index,'last_name',$event.target.value,v.last_name)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!v.last_name.$error">
                                            <span v-if="!v.last_name.required">
                                <?php  echo "{{model.structure.customer.last_name.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>
                            <b-row>
                                <b-col md="4">
                                    <div class="form-group"
                                         :class="getClassErrorForm(index,'information_phone_value',v.information_phone_value)">
                                        <label
                                            class="form__label " v-html='getLabelForm("information_phone_value")' ></label>
                                        <div class="content">
                                            <input

                                                v-model.trim="v.information_phone_value.$model"
                                                type="text"
                                                class="form-control m-input"
                                                @change="_setValueFormPeople(index,'information_phone_value',$event.target.value,v.information_phone_value)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!v.information_phone_value.$error">
                                            <span v-if="!v.information_phone_value.required">
                                <?php  echo "{{model.structure.customer.information_phone_value.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="4">
                                    <div class="form-group"
                                         :class="getClassErrorForm(index,'information_mail_value',v.information_mail_value)">
                                        <label
                                            class="form__label " v-html='getLabelForm("information_mail_value")' ></label>
                                        <div class="content">
                                            <input

                                                v-model.trim="v.information_mail_value.$model"
                                                v-bind:id="getNameAttributePeople(index,'information_mail_value')"
                                                v-bind:name="getNameAttributePeople(index,'information_mail_value')"
                                                type="text"

                                                class="form-control m-input"
                                                @change="_setValueFormPeople(index,'information_mail_value',$event.target.value,v.information_mail_value)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!v.information_mail_value.$error">
                                            <span v-if="!v.information_mail_value.required">
                                <?php  echo "{{model.structure.customer.information_mail_value.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>

                            </b-row>
                        </div>
                    </div>

                </b-container>


            </b-form>

        </div>


    </div>

</script>
