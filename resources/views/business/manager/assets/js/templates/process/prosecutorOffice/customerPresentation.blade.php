{{--BUSINESS-MANAGER--TEMPLATE-ROOT--CUSTOMER-PRESENTATION--}}
<?php

$utilManagerUser = new \App\Utils\UtilUser;
$user = Auth::user();

$dataManagerActions = array(
    array(
        "title" => "Actualizar",
        "data-placement" => "top",
        "i-class" => "fas fa-pencil-alt",
        "managerType" => "updateEntity",
        "action" => 'business/customer/save'
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
        "action" => 'business/customer/save',
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
<script type='text/x-template' id='add-data-customer-template'>
    <div>

        <div class='content-component' id="add-data-customer-container">

            <b-modal
                hide-footer
                id="modal-add-data-customer"
                ref="refAddDataCustomerModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <div class="manager-save">
                    <button type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success " v-on:click="_saveModel()">
                        <?php echo "{{labelsConfig.buttons.create}}"?>
                    </button>
                </div>
                <div class="content-form">

                    <b-form id="customerForm" v-on:submit.prevent="_submitForm" @validated="onListenValidationForm">

                        <input v-model="model.attributes.id" type="hidden"

                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-container>
                            <b-row>

                                <b-col md="3">
                                    <div class="form-group"
                                         :class="getClassErrorForm('people_type_identification_id_data',$v.model.attributes.people_type_identification_id_data)">
                                        <label
                                            class="form__label "
                                            v-html='getLabelForm("people_type_identification_id_data")'>


                                        </label>
                                        <div class="content">

                                            <select
                                                @click="onListenElementsForm({'element':'people_type_identification_id_data','objectElement':$v.model.attributes.people_type_identification_id_data})"
                                                v-bind:id="getNameAttribute('people_type_identification_id_data')"
                                                v-bind:name="getNameAttribute('people_type_identification_id_data')"
                                                class="form-control m-input"
                                                @change="_setValueForm('people_type_identification_id_data',$v.model.attributes.people_type_identification_id_data.$model)"
                                                v-model.trim="$v.model.attributes.people_type_identification_id_data.$model"


                                            >
                                                <option v-for="(row,index) in peopleTypeIdentificationData"
                                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                </option>
                                            </select>

                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.people_type_identification_id_data.$error">
                                            <span
                                                v-if="!$v.model.attributes.people_type_identification_id_data.required">
                                <?php  echo "{{model.structure.people_type_identification_id_data.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>

                                <b-col md="3"
                                       v-if="model.attributes.people_type_identification_id_data == typeIdentificationRuc">
                                    <div class="form-group"
                                         :class="getClassErrorForm('ruc_type_id_data',$v.model.attributes.ruc_type_id_data)">
                                        <label class="form__label " v-html='getLabelForm("ruc_type_id_data")'>


                                        </label>
                                        <div class="content">

                                            <select
                                                @click="onListenElementsForm({'element':'ruc_type_id_data','objectElement':$v.model.attributes.ruc_type_id_data})"
                                                v-bind:id="getNameAttribute('ruc_type_id_data')"
                                                v-bind:name="getNameAttribute('ruc_type_id_data')"
                                                class="form-control m-input"
                                                v-model.trim="$v.model.attributes.ruc_type_id_data.$model"
                                                @change="_setValueForm('ruc_type_id_data', $v.model.attributes.ruc_type_id_data.$model)"


                                            >
                                                <option v-for="(row,index) in rucTypeData"
                                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?></option>
                                            </select>

                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.ruc_type_id_data.$error">
                                            <span v-if="!$v.model.attributes.ruc_type_id_data.required">
                                <?php  echo "{{model.structure.ruc_type_id_data.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="3">
                                    <div class="form-group"
                                         :class="getClassErrorForm('identification_document',$v.model.attributes.identification_document)">
                                        <label
                                            class="form__label " v-html='getLabelForm("identification_document")'>

                                        </label>
                                        <div class="content">
                                            <input
                                                @click="onListenElementsForm({'element':'identification_document','objectElement':$v.model.attributes.identification_document})"

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
                                <?php  echo "{{model.structure.identification_document.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>
                            <b-row v-if="model.attributes.people_type_identification_id_data == typeIdentificationRuc">
                                <b-col md="6">
                                    <div class="form-group"
                                         :class="getClassErrorForm('business_name',$v.model.attributes.business_name)">
                                        <label class="form__label " v-html='getLabelForm("business_name")'>


                                        </label>
                                        <div class="content">
                                            <input
                                                @click="onListenElementsForm({'element':'business_name','objectElement':$v.model.attributes.business_name})"

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
                                <?php  echo "{{model.structure.business_name.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="6">
                                    <div class="form-group"
                                         :class="getClassErrorForm('business_reason',$v.model.attributes.business_reason)">
                                        <label class="form__label " v-html='getLabelForm("business_reason")'>

                                        </label>
                                        <div class="content">
                                            <input
                                                @click="onListenElementsForm({'element':'business_reason','objectElement':$v.model.attributes.business_reason})"

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
                                <?php  echo "{{model.structure.business_reason.required.msj}}"?>
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
                                            class="form__label "
                                            v-html='getLabelForm("people_nationality_id_data")'></label>
                                        <div class="content">

                                            <select
                                                @click="onListenElementsForm({'element':'people_nationality_id_data','objectElement':$v.model.attributes.people_nationality_id_data})"

                                                v-bind:id="getNameAttribute('people_nationality_id_data')"
                                                v-bind:name="getNameAttribute('people_nationality_id_data')"
                                                class="form-control m-input"
                                                v-model.trim="$v.model.attributes.people_nationality_id_data.$model"


                                            >
                                                <option v-for="(row,index) in peopleNationalityData"
                                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?></option>
                                            </select>

                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.people_nationality_id_data.$error">
                                            <span v-if="!$v.model.attributes.people_nationality_id_data.required">
                                <?php  echo "{{model.structure.people_nationality_id_data.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>

                                <b-col md="3">
                                    <div class="form-group"
                                         :class="getClassErrorForm('people_profession_id_data',$v.model.attributes.people_profession_id_data)">
                                        <label
                                            class="form__label "
                                            v-html='getLabelForm("people_profession_id_data")'></label>
                                        <div class="content">

                                            <select
                                                @click="onListenElementsForm({'element':'people_profession_id_data','objectElement':$v.model.attributes.people_profession_id_data})"

                                                v-bind:id="getNameAttribute('people_profession_id_data')"
                                                v-bind:name="getNameAttribute('people_profession_id_data')"
                                                class="form-control m-input"
                                                @change="_setValueForm('people_profession_id_data', $v.model.attributes.people_profession_id_data.$model)"
                                                v-model.trim="$v.model.attributes.people_profession_id_data.$model"


                                            >
                                                <option v-for="(row,index) in peopleProfessionData"
                                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?></option>
                                            </select>

                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.people_profession_id_data.$error">
                                            <span v-if="!$v.model.attributes.people_profession_id_data.required">
                                <?php  echo "{{model.structure.people_profession_id_data.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="3">
                                    <div class="form-group"
                                         :class="getClassErrorForm('gender_data',$v.model.attributes.gender_data)">
                                        <label class="form__label " v-html='getLabelForm("gender_data")'></label>
                                        <div class="content">

                                            <select
                                                @click="onListenElementsForm({'element':'gender_data','objectElement':$v.model.attributes.gender_data})"

                                                v-bind:id="getNameAttribute('gender_data')"
                                                v-bind:name="getNameAttribute('gender_data')"
                                                class="form-control m-input"
                                                @change="_setValueForm('gender_data',$v.model.attributes.gender_data.$model)"
                                                v-model.trim="$v.model.attributes.gender_data.$model"


                                            >
                                                <option v-for="(row,index) in genderData"
                                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?></option>
                                            </select>

                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.gender_data.$error">
                                            <span v-if="!$v.model.attributes.gender_data.required">
                                <?php  echo "{{model.structure.gender_data.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="3">
                                    <div class="form-group"
                                         :class="getClassErrorForm('birthdate',$v.model.attributes.birthdate)">
                                        <label class="form__label " v-html='getLabelForm("birthdate")'></label>
                                        <div class="content">

                                            <input
                                                @click="onListenElementsForm({'element':'birthdate','objectElement':$v.model.attributes.birthdate})"

                                                v-model.trim="$v.model.attributes.birthdate.$model"
                                                type="date"
                                                v-bind:id="getNameAttribute('birthdate')"
                                                v-bind:name="getNameAttribute('birthdate')"
                                                class="form-control m-input"
                                                @change="_setValueForm('birthdate', $event.target.value)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.birthdate.$error">
                                            <span v-if="!$v.model.attributes.birthdate.required">
                                <?php  echo "{{model.structure.birthdate.required.msj}}"?>
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
                                        <label
                                            class="form__label " v-html='getLabelForm("name")'></label>
                                        <div class="content">
                                            <input
                                                @click="onListenElementsForm({'element':'name','objectElement':$v.model.attributes.name})"

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
                                <?php  echo "{{model.structure.name.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="6">
                                    <div class="form-group"
                                         :class="getClassErrorForm('last_name',$v.model.attributes.last_name)">
                                        <label
                                            class="form__label " v-html='getLabelForm("last_name")'></label>
                                        <div class="content">
                                            <input
                                                @click="onListenElementsForm({'element':'last_name','objectElement':$v.model.attributes.last_name})"

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
                                <?php  echo "{{model.structure.last_name.required.msj}}"?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                            </b-row>


                        </b-container>

                        <b-row class="not-view">
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('main',managerInformationAddress.allow)">
                                    <label
                                        class="form__label ">Dirección <?php echo '{{model.attributes.information_address_id==null?" Creacion ":"-Actualizacion"}}'?></label>
                                    <div class="content-element-form"
                                         v-if="model.attributes.information_address_id==null">
                                        <switch-button
                                            @change="onEmmitOtherData({'type':'address'})"
                                            v-model="managerInformationAddress.allow"
                                            color="#34bfa3">
                                        </switch-button>
                                    </div>

                                </div>
                            </b-col>
                        </b-row>

                        <b-container v-if="managerInformationAddress.allow">
                            <b-row>
                                <b-col md="6">
                                    <div class="form-group"
                                         :class="getClassErrorForm('street_one',$v.model.attributes.street_one)">
                                        <label class="form__label " v-html='getLabelForm("street_one")'></label>
                                        <div class="content-element-form">
                                            <input
                                                @click="onListenElementsForm({'element':'street_one','objectElement':$v.model.attributes.street_one})"

                                                v-model.trim="$v.model.attributes.street_one.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('street_one')"
                                                v-bind:name="getNameAttribute('street_one')"
                                                class="form-control m-input"
                                                @change="_setValueForm('street_one', $v.model.attributes.street_one.$model)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.street_one.$error">
      <span v-if="!$v.model.attributes.street_one.required">
       <?php  echo "{{model.structure.street_one.required.msj}}"?>
      </span>
                                                <span v-if="!$v.model.attributes.street_one.maxLength">
       <?php  echo "{{model.structure.street_one.maxLength.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-col>
                                <b-col md="6">
                                    <div class="form-group"
                                         :class="getClassErrorForm('street_two',$v.model.attributes.street_two)">
                                        <label class="form__label " v-html='getLabelForm("street_two")'></label>
                                        <div class="content-element-form">
                                            <input
                                                @click="onListenElementsForm({'element':'street_two','objectElement':$v.model.attributes.street_two})"

                                                v-model.trim="$v.model.attributes.street_two.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('street_two')"
                                                v-bind:name="getNameAttribute('street_two')"
                                                class="form-control m-input"
                                                @change="_setValueForm('street_two', $v.model.attributes.street_two.$model)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.street_two.$error">
      <span v-if="!$v.model.attributes.street_two.required">
       <?php  echo "{{model.structure.street_two.required.msj}}"?>
      </span>
                                                <span v-if="!$v.model.attributes.street_two.maxLength">
       <?php  echo "{{model.structure.street_two.maxLength.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-col>

                            </b-row>
                            <b-row>
                                <b-col md="12">
                                    <div class="form-group"
                                         :class="getClassErrorForm('reference',$v.model.attributes.reference)">
                                        <label class="form__label " v-html='getLabelForm("reference")'></label>
                                        <div class="content-element-form">
<textarea
    @click="onListenElementsForm({'element':'reference','objectElement':$v.model.attributes.reference})"

    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.reference.$model"
    v-bind:id="getNameAttribute('reference')"
    v-bind:name="getNameAttribute('reference')"
    @change="_setValueForm('reference', $v.model.attributes.reference.$model)"
    v-focus-select
></textarea>
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.reference.$error">
      <span v-if="!$v.model.attributes.reference.required">
       <?php  echo "{{model.structure.reference.required.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-col>

                            </b-row>

                            <b-row>
                                <b-col md="12">
                                    <div class="floating-panel-manager">
                                        <input id="search-map-current"
                                               class="floating-panel-manager__search"
                                               type="textbox"
                                               value="Ecuador"
                                               v-focus-select
                                        >

                                    </div>
                                    <div class="map-guests"
                                         v-initMapCurrent="{model:$v.model.attributes,_initMap:_initMap}"
                                         id="manager-map">

                                    </div>
                                </b-col>
                            </b-row>


                        </b-container>
                        <b-row class="not-view">
                            <b-col md="4">
                                <div class="form-group"
                                >
                                    <label
                                        class="form__label ">Telefono/Cel<?php echo '{{model.attributes.information_phone_id==null?" Creacion ":"-Actualizacion"}}'?></label>
                                    <div class="content-element-form"
                                         v-if="model.attributes.information_phone_id==null">
                                        <switch-button
                                            @change="onEmmitOtherData({'type':'phone'})"
                                            v-model="managerInformationPhone.allow"
                                            color="#34bfa3">
                                        </switch-button>
                                    </div>

                                </div>
                            </b-col>
                        </b-row>


                        <b-container v-if="managerInformationPhone.allow">
                            <b-row>
                                <b-col md="6" class="not-view">
                                    <div class="form-group"
                                         :class="getClassErrorForm('information_phone_operator_id_data',$v.model.attributes.information_phone_operator_id_data)">
                                        <label
                                            class="form__label "
                                            v-html='getLabelForm("information_phone_operator_id_data")'></label>
                                        <div class="content-element-form">
                                            <input

                                                v-model="$v.model.attributes.information_phone_operator_id_data.model"
                                                type="hidden"
                                                v-bind:id="getNameAttribute('information_phone_operator_id_data')"
                                                v-bind:name="getNameAttribute('information_phone_operator_id_data')"
                                                @change="_setValueForm('information_phone_operator_id_data', $v.model.attributes.information_phone_operator_id_data.$model)"
                                            >
                                            <select id="information_phone_operator_id_data"
                                                    @click="onListenElementsForm({'element':'information_phone_operator_id_data','objectElement':$v.model.attributes.information_phone_operator_id_data})"

                                                    class="form-control m-select2 "
                                                    v-initS2InformationPhoneOperator="{rowId:model.attributes.id,_managerS2InformationPhoneOperator:_managerS2InformationPhoneOperator}"
                                            >
                                            </select>
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.information_phone_operator_id_data.$error">
      <span v-if="!$v.model.attributes.information_phone_operator_id_data.required">
       <?php  echo "{{model.structure.information_phone_operator_id_data.required.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="6">
                                    <div class="form-group"
                                         :class="getClassErrorForm('information_phone_type_id_data',$v.model.attributes.information_phone_type_id_data)">
                                        <label
                                            class="form__label "
                                            v-html='getLabelForm("information_phone_type_id_data")'></label>
                                        <div class="content-element-form">
                                            <input v-model="$v.model.attributes.information_phone_type_id_data.model"
                                                   type="hidden"
                                                   v-bind:id="getNameAttribute('information_phone_type_id_data')"
                                                   v-bind:name="getNameAttribute('information_phone_type_id_data')"
                                                   @change="_setValueForm('information_phone_type_id_data', $v.model.attributes.information_phone_type_id_data.$model)"
                                            >
                                            <select id="information_phone_type_id_data"
                                                    @click="onListenElementsForm({'element':'information_phone_type_id_data','objectElement':$v.model.attributes.information_phone_type_id_data})"

                                                    class="form-control m-select2 "
                                                    v-initS2InformationPhoneType="{rowId:model.attributes.id,_managerS2InformationPhoneType:_managerS2InformationPhoneType}"
                                            >
                                            </select>
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.information_phone_type_id_data.$error">
      <span v-if="!$v.model.attributes.information_phone_type_id_data.required">
       <?php  echo "{{model.structure.information_phone_type_id_data.required.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col md="6">
                                    <div class="form-group"
                                         :class="getClassErrorForm('value',$v.model.attributes.information_phone_value)">
                                        <label class="form__label "
                                               v-html='getLabelForm("information_phone_value")'></label>
                                        <div class="content-element-form">
                                            <input
                                                @click="onListenElementsForm({'element':'information_phone_value','objectElement':$v.model.attributes.information_phone_value})"

                                                v-model.trim="$v.model.attributes.information_phone_value.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('information_phone_value')"
                                                v-bind:name="getNameAttribute('information_phone_value')"
                                                class="form-control m-input"
                                                @change="_setValueForm('value', $v.model.attributes.information_phone_value.$model)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.information_phone_value.$error">
      <span v-if="!$v.model.attributes.information_phone_value.required">
       <?php  echo "{{model.structure.information_phone_value.required.msj}}"?>
      </span>
                                                <span v-if="!$v.model.attributes.information_phone_value.maxLength">
       <?php  echo "{{model.structure.information_phone_value.maxLength.msj}}"?>
      </span>
                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>

                                </b-col>
                            </b-row>


                        </b-container>


                    </b-form>

                </div>

            </b-modal>


        </div>
    </div>
</script>


<script id="buttons-manager-admin">
    var $buttonsManagements = <?php echo json_encode($buttonsManagements); ?>;

    var $buttonsProcess = <?php echo json_encode($buttonsProcess); ?>;

</script>
<script type="text/x-template" id="secretary_processes_by_customer_presentation-template">
    <div>
        <div v-if="configModalAddDataCustomer.viewAllow">
            <add-data-customer-component
                ref="refAddDataCustomer"
                :params="configModalAddDataCustomer"
            >
            </add-data-customer-component>
        </div>
        <b-container class="bv-example-row" v-if="managerCustomerSearch.view==false">
            <div class="content-row-manager-buttons">

                <button

                    v-if="!managerMenuConfig.view && viewProcessButton({type:'create'})"
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

        <?php ?>
        <div class="content-manager-grid" v-show="!managerCustomerSearch.view">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <table id="{{$configProcess['entity-process-down']}}-grid"
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

            <b-form id="{{$configProcess['entity-process-down']}}Form" v-on:submit.prevent="_submitForm"
                    @validated="onListenValidationForm">

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >

                <b-container>
                    <b-row>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('state',$v.model.attributes.state)">
                                <label
                                    class="form__label " v-html='getLabelForm("state")'>


                                </label>
                                <div class="content">

                                    <select
                                        @click="onListenElementsForm({'element':'state','objectElement':$v.model.attributes.state})"
                                        v-bind:id="getNameAttribute('state')"
                                        v-bind:name="getNameAttribute('state')"
                                        class="form-control m-input"
                                        @change="_setValueForm('state',$v.model.attributes.state.$model)"
                                        v-model.trim="$v.model.attributes.state.$model"


                                    >
                                        <option v-for="(row,index) in stateData"
                                                v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                        </option>
                                    </select>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.state.$error">
                                            <span
                                                v-if="!$v.model.attributes.state.required">
                                <?php  echo "{{model.structure.state.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('customer_id',$v.model.attributes.customer_id)">
                                <label
                                    class="form__label " v-html='getLabelForm("customer_id")'>


                                </label>
                                <div class="content">

                                    <select
                                        @click="onListenElementsForm({'element':'customer_id','objectElement':$v.model.attributes.customer_id})"
                                        v-bind:id="getNameAttribute('customer_id')"
                                        v-bind:name="getNameAttribute('customer_id')"
                                        class="form-control m-select2 customer_id"
                                        v-initS2CustomerSearch="{_customersList:_customersList}"
                                        @change="_setValueForm('customer_id',$v.model.attributes.customer_id.$model)"
                                        v-model.trim="$v.model.attributes.customer_id.$model"


                                    >

                                    </select>


                                    <a class="btn btn-xs add-data-row"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       data-original-title="Agregar Cliente"
                                       init-tooltip
                                       v-on:click="onAddCustomer()"
                                    >
                                        <span class="fa fa-plus"></span>
                                    </a>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.customer_id.$error">
                                            <span
                                                v-if="!$v.model.attributes.customer_id.required">
                                <?php  echo "{{model.structure.customer_id.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                    </b-row>
                    <b-row>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('prosecution_process_number',$v.model.attributes.prosecution_process_number)">
                                <label
                                    class="form__label " v-html='getLabelForm("prosecution_process_number")'>

                                </label>
                                <div class="content">
                                    <input
                                        @click="onListenElementsForm({'element':'prosecution_process_number','objectElement':$v.model.attributes.prosecution_process_number})"

                                        v-model.trim="$v.model.attributes.prosecution_process_number.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('prosecution_process_number')"
                                        v-bind:name="getNameAttribute('prosecution_process_number')"
                                        class="form-control m-input"
                                        @change="_setValueForm('prosecution_process_number',$v.model.attributes.prosecution_process_number.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.prosecution_process_number.$error">
                                            <span v-if="!$v.model.attributes.prosecution_process_number.required">
                                <?php  echo "{{model.structure.prosecution_process_number.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('judical_process_number',$v.model.attributes.judical_process_number)">
                                <label
                                    class="form__label " v-html='getLabelForm("judical_process_number")'>

                                </label>
                                <div class="content">
                                    <input
                                        @click="onListenElementsForm({'element':'judical_process_number','objectElement':$v.model.attributes.judical_process_number})"

                                        v-model.trim="$v.model.attributes.judical_process_number.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('judical_process_number')"
                                        v-bind:name="getNameAttribute('judical_process_number')"
                                        class="form-control m-input"
                                        @change="_setValueForm('judical_process_number',$v.model.attributes.judical_process_number.$model)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.judical_process_number.$error">
                                            <span v-if="!$v.model.attributes.judical_process_number.required">
                                <?php  echo "{{model.structure.judical_process_number.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('date_of_presentation',$v.model.attributes.date_of_presentation)">
                                <label class="form__label " v-html='getLabelForm("date_of_presentation")'></label>
                                <div class="content">

                                    <input
                                        @click="onListenElementsForm({'element':'date_of_presentation','objectElement':$v.model.attributes.date_of_presentation})"

                                        v-model.trim="$v.model.attributes.date_of_presentation.$model"
                                        type="date"
                                        v-bind:id="getNameAttribute('date_of_presentation')"
                                        v-bind:name="getNameAttribute('date_of_presentation')"
                                        class="form-control m-input"
                                        @change="_setValueForm('date_of_presentation', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.date_of_presentation.$error">
                                            <span v-if="!$v.model.attributes.date_of_presentation.required">
                                <?php  echo "{{model.structure.date_of_presentation.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="2">
                            <div class="form-group"
                                 :class="getClassErrorForm('date_of_presentation_hour',$v.model.attributes.date_of_presentation_hour)">
                                <label class="form__label " v-html='getLabelForm("date_of_presentation_hour")'></label>
                                <div class="content">

                                    <input
                                        @click="onListenElementsForm({'element':'date_of_presentation_hour','objectElement':$v.model.attributes.date_of_presentation_hour})"

                                        v-model.trim="$v.model.attributes.date_of_presentation_hour.$model"
                                        type="time"
                                        v-bind:id="getNameAttribute('date_of_presentation_hour')"
                                        v-bind:name="getNameAttribute('date_of_presentation_hour')"
                                        class="form-control m-input"
                                        @change="_setValueForm('date_of_presentation_hour', $event.target.value)"
                                        v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.date_of_presentation_hour.$error">
                                            <span v-if="!$v.model.attributes.date_of_presentation_hour.required">
                                <?php  echo "{{model.structure.date_of_presentation_hour.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('observation',$v.model.attributes.observation)">
                                <label class="form__label " v-html='getLabelForm("observation")'></label>
                                <div class="content-element-form">
<textarea
    @click="onListenElementsForm({'element':'observation','objectElement':$v.model.attributes.observation})"

    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.observation.$model"
    v-bind:id="getNameAttribute('observation')"
    v-bind:name="getNameAttribute('observation')"
    @change="_setValueForm('observation', $v.model.attributes.observation.$model)"
    v-focus-select
></textarea>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.observation.$error">
      <span v-if="!$v.model.attributes.observation.required">
       <?php  echo "{{model.structure.observation.required.msj}}"?>
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
