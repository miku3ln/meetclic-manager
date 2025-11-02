<script type="text/x-template" id="lodging-statistical-data-template">
    <div>
        <b-container class="bv-example-row">
            <div class="content-row-manager-reports">

                <b-row>

                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('date_init',$v.model.attributes.date_init)">
                            <label class="form__label col-md-12" v-html='getLabelForm("date_init")' ></label>
                            <div class="content ">
                                <input
                                    v-model.trim="$v.model.attributes.date_init.$model"
                                    type="date"
                                    v-bind:id="getNameAttribute('date_init')"
                                    v-bind:name="getNameAttribute('date_init')"
                                    class="form-control m-input"
                                    @change="_setValueForm('date_init', $event.target.value)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.date_init.$error">
                                            <span v-if="!$v.model.attributes.date_init.required">
                                <?php  echo "{{model.structure.date_init.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('date_end',$v.model.attributes.date_end)">
                            <label class="form__label col-md-12" v-html='getLabelForm("date_end")' ></label>
                            <div class="content ">
                                <input
                                    v-model.trim="$v.model.attributes.date_end.$model"
                                    type="date"
                                    v-bind:id="getNameAttribute('date_end')"
                                    v-bind:name="getNameAttribute('date_end')"
                                    class="form-control m-input"
                                    @change="_setValueForm('date_end', $event.target.value)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.date_end.$error">
                                            <span v-if="!$v.model.attributes.date_end.required">
                                <?php  echo "{{model.structure.date_end.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="4">
                        <button
                            id="btn-manager"
                            type="button"
                            class="btn btn-success "
                            :disabled="!validateForm()"
                            v-on:click="_viewReport()">
                            Generar Reporte
                        </button>
                    </b-col>
                </b-row>


            </div>
        </b-container>

        <div class="content-form">
            <div class="content-manager-buttons" v-if="configDownLoad.allow">

                <button v-on:click="_generatePdf()" v-if="configDownLoad.pdf.allow">
                    Download Pdf
                </button>
            </div>
            <iframe init-pdfelement id="iframe-pdf" class="preview-pane not-view" type="application/pdf" width="100%"
                    height="650" frameborder="0"></iframe>
            <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">

                <b-container>
                    <b-row>

                        <b-col md="12">

                            <div v-show="reportsConfig.income.view" id="container-income-data-lodging"
                                 style="min-width: 310px; height: 400px; margin: 0 auto">

                            </div>
                            <b-alert show variant="success" :show="!reportsConfig.income.view">
                                <h4 class="alert-heading">  <?php  echo "{{reportsConfig.income.msjEmpty.title}}"?></h4>
                                <p>
                                    <?php  echo "{{reportsConfig.income.msjEmpty.msj}}"?>
                                </p>
                            </b-alert>
                        </b-col>
                        <b-col md="12">

                            <div v-show="reportsConfig.incomeTypesPayment.view"
                                 id="container-income-types-payment-data-lodging"
                                 style="min-width: 310px; height: 400px; margin: 0 auto">

                            </div>

                            <b-alert show variant="success" :show="!reportsConfig.incomeTypesPayment.view">
                                <h4 class="alert-heading">  <?php  echo "{{reportsConfig.incomeTypesPayment.msjEmpty.title}}"?></h4>
                                <p>
                                    <?php  echo "{{reportsConfig.incomeTypesPayment.msjEmpty.msj}}"?>
                                </p>

                            </b-alert>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="12">
                            <div v-show="reportsConfig.incomePeople.view" id="container-income-people-data-lodging"
                                 style="min-width: 310px; height: 400px; margin: 0 auto">

                            </div>

                            <b-alert show variant="success" :show="!reportsConfig.incomePeople.view">
                                <h4 class="alert-heading">  <?php  echo "{{reportsConfig.incomePeople.msjEmpty.title}}"?></h4>
                                <p>
                                    <?php  echo "{{reportsConfig.incomePeople.msjEmpty.msj}}"?>
                                </p>

                            </b-alert>
                        </b-col>
                        <b-col lg="12">
                            <div v-show="reportsConfig.incomePeopleArrived.view"
                                 id="container-income-people-arrived-data-lodging"
                                 style="min-width: 310px; height: 400px; margin: 0 auto">

                            </div>

                            <b-alert show variant="success" :show="!reportsConfig.incomePeopleArrived.view">
                                <h4 class="alert-heading">  <?php  echo "{{reportsConfig.incomePeopleArrived.msjEmpty.title}}"?></h4>
                                <p>
                                    <?php  echo "{{reportsConfig.incomePeopleArrived.msjEmpty.msj}}"?>
                                </p>

                            </b-alert>
                        </b-col>
                        <b-col lg="12">
                            <div v-show="reportsConfig.incomePeopleArrivedReasons.view"
                                 id="container-income-people-arrived-reasons-data-lodging"
                                 style="min-width: 310px; height: 400px; margin: 0 auto">

                            </div>

                            <b-alert show variant="success" :show="!reportsConfig.incomePeopleArrivedReasons.view">
                                <h4 class="alert-heading">  <?php  echo "{{reportsConfig.incomePeopleArrivedReasons.msjEmpty.title}}"?></h4>
                                <p>
                                    <?php  echo "{{reportsConfig.incomePeopleArrivedReasons.msjEmpty.msj}}"?>
                                </p>

                            </b-alert>
                        </b-col>
                        <b-col lg="12">
                            <div v-show="reportsConfig.incomePeopleCountriesArrived.view"
                                 id="container-income-people-countries-arrived-data-lodging"
                                 style="min-width: 310px; height: 400px; margin: 0 auto">

                            </div>

                            <b-alert show variant="success" :show="!reportsConfig.incomePeopleCountriesArrived.view">
                                <h4 class="alert-heading">  <?php  echo "{{reportsConfig.incomePeopleCountriesArrived.msjEmpty.title}}"?></h4>
                                <p>
                                    <?php  echo "{{reportsConfig.incomePeopleCountriesArrived.msjEmpty.msj}}"?>
                                </p>

                            </b-alert>
                        </b-col>

                    </b-row>

                </b-container>

            </b-form>

        </div>


    </div>

</script>
