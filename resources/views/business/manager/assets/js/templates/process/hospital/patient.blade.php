<!--TREATMENT-->
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.treatment.treatmentByIndebtedness";
?>
@include($wizards_route)
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.treatment.treatmentByPayment";
?>
@include($wizards_route)
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.treatment.treatmentByPatient";
?>
@include($wizards_route)
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.medicalConsultationByPatient";
?>
@include($wizards_route)

<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.antecedents.antecedentByHistoryClinic";
?>
@include($wizards_route)

<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.hospital.odontogramByPatient";
?>
@include($wizards_route)
<script type='text/x-template' id='certificate-template'>
    <div>

        <div class='content-component management-all' v-if="allowAll">
            <b-row>
                <b-col lg="4" v-show="validateForm()">

                    <div class="form-group"
                    >
                        <label class="form__label"
                               for="preview"><?php echo '{{model.labels.preview.name}}' ?></label>
                        <div class="toggle">
                            <input
                                v-model="$v.model.attributes.preview.$model"
                                type="checkbox"
                                id="preview"
                                name="preview"
                                @change="_setValueFormPreview($v.model.attributes.preview.$model)"

                            >
                            <label for="preview">
                                <div class="toggle__switch"></div>
                            </label>
                        </div>
                        <div class="content-message-errors col-md-12">

                        </div>
                    </div>
                </b-col>

            </b-row>

            <div class="certificate" v-show="$v.model.attributes.preview.$model==false">
                <b-row>
                    <b-col md="4">
                        <div class="form-group"

                             :class="getClassErrorForm('type',$v.model.attributes.type)">
                            <label class="form__label "><?php echo '{{model.labels.type.name}}'?></label>
                            <div class="content-element-form">
                                <select v-model.trim="$v.model.attributes.type.$model"
                                        id="type"
                                        name="type"
                                        class="form-control m-input"

                                >
                                    <option v-for="(row,index) in model.labels.type.options"
                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.type.$error">
      <span v-if="!$v.model.attributes.type.required">
       <?php  echo "Seleccione una opcion"?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>
                <div class="management-documents-form" v-show="$v.model.attributes.type.$model==0 || $v.model.attributes.type.$model==1">
                    <span class="certificate__date"><?php echo '{{configDataCertificate.header.title}}'?>   </span>
                    <input
                        v-model="$v.model.attributes.date.$model"
                        id="date"
                        name="date"
                        type="text" v-bind:placeholder="model.labels.date.name">
                    <h1 class="certificate__title"><?php echo '{{configDataCertificate.title}}'?>  </h1>
                    <span class="certificate__intro-one-init"> <?php echo '{{configDataCertificate.body.one}}'?></span>
                    <input v-model="$v.model.attributes.full_name.$model"
                           id="full_name"
                           name="full_name"
                           type="text" v-bind:placeholder="model.labels.full_name.name">
                    <span class="certificate__intro-one-middle"> <?php echo '{{configDataCertificate.body.two}}'?></span>
                    <br>
                    <span class="certificate__intro-one-end"> <?php echo '{{configDataCertificate.body.three}}'?></span>
                    <input v-model="$v.model.attributes.document.$model"
                           id="document"
                           name="document"
                           type="text" v-bind:placeholder="model.labels.document.name">
                    <textarea cols="50" row="4" v-model="$v.model.attributes.description.$model"
                              id="description"
                              name="description"
                              type="text" v-bind:placeholder="model.labels.description.name"></textarea>
                    <br>
                    <br>
                    <div v-if="$v.model.attributes.type.$model==0" class="diagonisis">
                        <span class="certificate__diagnosis"> <?php echo '{{configDataCertificate.body.five}}'?></span>
                        <textarea cols="50" row="4" v-model="$v.model.attributes.diagnosis.$model"
                                  id="diagnosis"
                                  name="diagnosis"
                                  type="text" v-bind:placeholder="model.labels.diagnosis.name"></textarea>
                        <br>
                        <br>
                    </div>

                    <span class="certificate__recommendation"> <?php echo '{{configDataCertificate.body.six}}'?></span>
                    <textarea cols="50" row="4" v-model="$v.model.attributes.recommendations.$model"
                              id="recommendations"
                              name="recommendations"
                              type="text" v-bind:placeholder="model.labels.recommendations.name"></textarea>
                    <br>
                    <br>
                    <span> <?php echo '{{configDataCertificate.body.seven}}'?></span>
                    <div class="content-management-provider">
                        <span>Atentamente,</span>
                        <br>
                        <br>
                        <input v-model="$v.model.attributes.full_name_doctor.$model"
                               id="full_name_doctor"
                               name="full_name_doctor"
                               type="text" v-bind:placeholder="model.labels.full_name_doctor.name">
                        <br>
                        <input v-model="$v.model.attributes.name_profession.$model"
                               id="name_profession"
                               name="name_profession"
                               type="text" v-bind:placeholder="model.labels.name_profession.name">
                    </div>
                </div>



            </div>

            <iframe id="iframe-pdf" class="preview-pane" type="application/pdf" width="100%" v-show="$v.model.attributes.preview.$model==true"
                    height="650" frameborder="0">

            </iframe>
        </div>
    </div>
</script>

<script type='text/x-template' id='patient-template'>
    <div>

        <div class='content-component management-all'>


            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':managerViews.admin,'btn-danger':managerViews.createUpdate}"
                        v-on:click="_viewManager(managerViews.createUpdate?2:1)">
                        <?php  echo "{{managerViews.createUpdate?'Regresar':'Nuevo'}}" ?></button>
                    <button v-if="managerViews.createUpdate" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?></button>

                    <div v-if="managerViews.admin">
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

                <div class="custom-scroll-admin-grid table-responsive" v-show="managerViews.admin">
                    <table id="patient-grid"
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
            <div class="content-form" v-if="managerViews.createUpdate">
                <b-form id="patientForm" v-on:submit.prevent="_submitForm">
                    <b-container>
                        <br>
                        <br>
                        <br>
                        <br>

                        @include('partials.crm.customer.mintonPatient',array('type'=>1))


                    </b-container>
                </b-form>

            </div>
            <div class="management-current-process" v-if="managerViews.management">
                <div class="header-process">
                    <div class="row">
                        <div class="col-md-4">
                            <i class="fas fa-arrow-left header-process__return" @click="_viewManager(2)"></i>
                        </div>
                        <div class="col-md-8">
                            <a class="header-process__title" @click="_updatePatient()" v-html="patientData.header">

                            </a>

                        </div>

                    </div>
                </div>
                <b-card no-body>
                    <b-tabs pills card>
                        <b-tab active @click="_managementProcess(0)">
                            <template v-slot:title>
                                <i class="fas fa-heartbeat"></i>
                                <strong>Paciente</strong>
                            </template>
                            <div class="manager-current" v-if="configDataPatient.viewAllow">

                                <certificate-component
                                    ref="refCertificate"
                                    :params="configDataPatient"

                                ></certificate-component>

                            </div>
                        </b-tab>
                        <b-tab @click="_managementProcess(1)">
                            <template v-slot:title>
                                <span aria-hidden="true" class="fa fa-medkit"></span>
                                <strong>Antecedentes</strong>
                            </template>
                            <div class="manager-current">

                                <div v-if="configDataAntecedentByHistoryClinic.viewAllow">

                                    <antecedent-by-history-clinic-component
                                        ref="refAntecedentByHistoryClinic"
                                        :params="configDataAntecedentByHistoryClinic"

                                    ></antecedent-by-history-clinic-component>
                                </div>

                            </div>

                        </b-tab>
                        <b-tab @click="_managementProcess(2)">
                            <template v-slot:title>
                                <span aria-hidden="true" class="fas fa-notes-medical"></span>
                                <strong>Consulta</strong>
                            </template>

                            <div class="manager-current">
                                <div v-if="configDataMedicalConsultationByPatient.viewAllow">
                                    <medical-consultation-by-patient-component
                                        ref='refMedicalConsultationByPatient'
                                        :params='configDataMedicalConsultationByPatient'
                                        v-on:_medicalConsultationByPatient-emit="_updateParentByChildren($event)"
                                    >

                                    </medical-consultation-by-patient-component>
                                </div>
                            </div>

                        </b-tab>
                        <b-tab @click="_managementProcess(3)">
                            <template v-slot:title>
                                <span aria-hidden="true" class="fas fa-book-medical"></span>
                                <strong>Tratamientos</strong>
                            </template>

                            <div class="manager-current">
                                <div v-if="configDataTreatmentByPatient.viewAllow">
                                    <treatment-by-patient-component
                                        ref='refTreatmentByPatient'
                                        :params='configDataTreatmentByPatient'
                                        v-on:_treatmentByPatient-emit="_updateParentByChildren($event)"
                                    >

                                    </treatment-by-patient-component>
                                </div>
                            </div>

                        </b-tab>
                        <b-tab @click="_managementProcess(4)">
                            <template v-slot:title>
                                <span aria-hidden="true" class="fas fa-tooth"></span>
                                <strong>Odontograma</strong>
                            </template>

                            <div class="manager-current">
                                <div v-if="configDataOdontogramByPatient.viewAllow">
                                    <odontogram-by-patient-component
                                        ref='refOdontogramByPatient'
                                        :params='configDataOdontogramByPatient'
                                        v-on:_odontogramByPatient-emit="_updateParentByChildren($event)"
                                    >

                                    </odontogram-by-patient-component>
                                </div>
                            </div>

                        </b-tab>
                    </b-tabs>
                </b-card>
            </div>

        </div>
    </div>
</script>

