<script type="text/x-template" id="customer-template">
    <div>


        <b-container class="bv-example-row">
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
        <div class="content-manager-grid">

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

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >

                <b-container>
                    <b-row>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('people_type_identification_id_data',$v.model.attributes.people_type_identification_id_data)">
                                <label class="form__label " v-html='getLabelForm("people_type_identification_id_data")' ></label>
                                <div class="content">

                                    <select

                                            v-bind:id="getNameAttribute('people_type_identification_id_data')"
                                            v-bind:name="getNameAttribute('people_type_identification_id_data')"
                                            class="form-control m-input"
                                            @change="_setValueForm('people_type_identification_id_data',$v.model.attributes.people_type_identification_id_data.$model)"
                                            v-model.trim="$v.model.attributes.people_type_identification_id_data.$model"


                                    >
                                        <option v-for="(row,index) in peopleTypeIdentificationData"
                                                v-bind:value="row.value"><?php echo '{{row.text}}' ?></option>
                                    </select>

                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.people_type_identification_id_data.$error">
                                            <span v-if="!$v.model.attributes.people_type_identification_id_data.required">
                                <?php  echo "{{model.structure.people_type_identification_id_data.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('ruc_type_id_data',$v.model.attributes.ruc_type_id_data)">
                                <label class="form__label " v-html='getLabelForm("ruc_type_id_data")' ></label>
                                <div class="content">

                                    <select

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
                    </b-row>
                    <b-row v-if="model.attributes.people_type_identification_id_data == typeIdentificationRuc">
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
                                <?php  echo "{{model.structure.business_name.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('business_reason',$v.model.attributes.business_reason)">
                                <label class="form__label " v-html='getLabelForm("business_reason")' ></label>
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
                                <label class="form__label " v-html='getLabelForm("people_nationality_id_data")' ></label>
                                <div class="content">

                                    <select

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
                                <label class="form__label " v-html='getLabelForm("people_profession_id_data")' ></label>
                                <div class="content">

                                    <select

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
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('name',$v.model.attributes.name)">
                                <label class="form__label "><?php echo '{{model.attributes.people_type_identification_id_data == typeIdentificationRuc?"Nombres Contacto *":getLabelForm("name")}}' ?></label>
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
                                <?php  echo "{{model.structure.name.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('last_name',$v.model.attributes.last_name)">
                                <label class="form__label "><?php echo '{{model.attributes.people_type_identification_id_data == typeIdentificationRuc?"Apellidos Contacto *":getLabelForm("last_name")}}' ?></label>
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
                                <?php  echo "{{model.structure.last_name.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('identification_document',$v.model.attributes.identification_document)">
                                <label class="form__label " v-html='getLabelForm("identification_document")' ></label>
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
                                <?php  echo "{{model.structure.identification_document.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('birthdate',$v.model.attributes.birthdate)">
                                <label class="form__label " v-html='getLabelForm("birthdate")' ></label>
                                <div class="content">
                                    <date-time-picker
                                            v-model.trim="$v.model.attributes.birthdate.$model"
                                            v-bind:id="getNameAttribute('birthdate')"
                                            v-bind:name="getNameAttribute('birthdate')"
                                            @change="_setValueForm('birthdate', $v.model.attributes.birthdate.$model)"
                                            v-model.trim="$v.model.attributes.birthdate.$model"
                                            format="dd-LL-yyyy"
                                            :hour-time="12"
                                            locale="es"
                                    ></date-time-picker>

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

                </b-container>

            </b-form>

        </div>


    </div>

</script>
