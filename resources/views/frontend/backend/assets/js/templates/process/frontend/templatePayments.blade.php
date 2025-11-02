<script type='text/x-template' id='template-payments-template'>
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
                        <?php echo '{{managerType==1?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?></button>

                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                            <menu-admin-grid
                                @input="_managerRowGrid($event)"
                                :manager-menu-config="managerMenuConfig" >

                            </menu-admin-grid>


                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="template-payments-grid"
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
                <b-form id="templatePaymentsForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('status',$v.model.attributes.status)">
                                    <label class="form__label " v-html='getLabelForm("status")' ></label>
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
                        </b-row>
                        <b-row>
                            <b-col md="4" v-if="$v.model.attributes.id.$model==null">
                                <div class="form-group"

                                     :class="getClassErrorForm('type_payment',$v.model.attributes.type_payment)">
                                    <label class="form__label " v-html='getLabelForm("type_payment")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.type_payment.$model"
                                                v-bind:id="getNameAttribute('type_payment')"
                                                v-bind:name="getNameAttribute('type_payment')"
                                                class="form-control m-input"
                                                @change="_setValueForm('type_payment', $v.model.attributes.type_payment.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.type_payment.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_payment.$error">
      <span v-if="!$v.model.attributes.type_payment.required">
       <?php  echo "{{model.structure.type_payment.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>


                            <b-col md="4" v-if="$v.model.attributes.type_payment.$model!=2">
                                <div class="form-group"

                                     :class="getClassErrorForm('type_manager',$v.model.attributes.type_manager)">
                                    <label class="form__label " v-html='getLabelForm("type_manager")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.type_manager.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('type_manager')"
                                            v-bind:name="getNameAttribute('type_manager')"
                                            class="form-control m-input"
                                            @change="_setValueForm('type_manager', $v.model.attributes.type_manager.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_manager.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4"  v-if="$v.model.attributes.type_payment.$model!=2">
                                <div class="form-group"

                                     :class="getClassErrorForm('manager_type_modal',$v.model.attributes.manager_type_modal)">
                                    <label class="form__label " v-html='getLabelForm("manager_type_modal")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.manager_type_modal.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('manager_type_modal')"
                                            v-bind:name="getNameAttribute('manager_type_modal')"
                                            class="form-control m-input"
                                            @change="_setValueForm('manager_type_modal', $v.model.attributes.manager_type_modal.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.manager_type_modal.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row  v-if="$v.model.attributes.type_payment.$model==2 || $v.model.attributes.type_payment.$model==0">
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('user',$v.model.attributes.user)">
                                    <label class="form__label "><?php echo '{{labelUser}}'?></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.user.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('user')"
                                            v-bind:name="getNameAttribute('user')"
                                            class="form-control m-input"
                                            @change="_setValueForm('user', $v.model.attributes.user.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.user.$error">
      <span v-if="!$v.model.attributes.user.maxLength">
       <?php  echo "{{model.structure.user.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('password',$v.model.attributes.password)">
                                    <label class="form__label "><?php echo '{{labelPassword}}'?></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.password.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('password')"
                                            v-bind:name="getNameAttribute('password')"
                                            class="form-control m-input"
                                            @change="_setValueForm('password', $v.model.attributes.password.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.password.$error">
      <span v-if="!$v.model.attributes.password.maxLength">
       <?php  echo "{{model.structure.password.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6" v-if="$v.model.attributes.type_payment.$model!=2">
                                <div class="form-group"

                                     :class="getClassErrorForm('live_id',$v.model.attributes.live_id)">
                                    <label class="form__label "><?php echo '{{getLabelsKeysApi("live_id")}}'?></label>
                                    <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.live_id.$model"
    v-bind:id="getNameAttribute('live_id')"
    v-bind:name="getNameAttribute('live_id')"
    @change="_setValueForm('live_id', $v.model.attributes.live_id.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.live_id.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6" v-if="$v.model.attributes.type_payment.$model!=2">
                                <div class="form-group"

                                     :class="getClassErrorForm('live_secret',$v.model.attributes.live_secret)">
                                    <label class="form__label "><?php echo '{{getLabelsKeysApi("live_secret")}}'?></label>
                                    <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.live_secret.$model"
    v-bind:id="getNameAttribute('live_secret')"
    v-bind:name="getNameAttribute('live_secret')"
    @change="_setValueForm('live_secret', $v.model.attributes.live_secret.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.live_secret.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>

                        <b-row>


                            <b-col md="6" v-if="$v.model.attributes.type_payment.$model==0 ||$v.model.attributes.type_payment.$model==1 ||$v.model.attributes.type_payment.$model==3 ">
                                <div class="form-group"

                                     :class="getClassErrorForm('test_id',$v.model.attributes.test_id)">
                                    <label class="form__label "><?php echo '{{getLabelsKeysApi("test_id")}}'?></label>
                                    <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.test_id.$model"
    v-bind:id="getNameAttribute('test_id')"
    v-bind:name="getNameAttribute('test_id')"
    @change="_setValueForm('test_id', $v.model.attributes.test_id.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.test_id.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6" v-if="$v.model.attributes.type_payment.$model==0  ||$v.model.attributes.type_payment.$model==1 ||$v.model.attributes.type_payment.$model==3">
                                <div class="form-group"

                                     :class="getClassErrorForm('test_secret',$v.model.attributes.test_secret)">
                                    <label class="form__label "><?php echo '{{getLabelsKeysApi("test_secret")}}'?></label>
                                    <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.test_secret.$model"
    v-bind:id="getNameAttribute('test_secret')"
    v-bind:name="getNameAttribute('test_secret')"
    @change="_setValueForm('test_secret', $v.model.attributes.test_secret.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.test_secret.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('msj_to_customer',$v.model.attributes.msj_to_customer)">
                                    <label class="form__label " v-html='getLabelForm("msj_to_customer")' ></label>
                                    <div class="content-element-form">
<textarea
    style="display: none;"
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.msj_to_customer.$model"
    v-bind:id="getNameAttribute('msj_to_customer')"
    v-bind:name="getNameAttribute('msj_to_customer')"
    @change="_setValueForm('msj_to_customer', $v.model.attributes.msj_to_customer.$model)"
    v-focus-select
></textarea>
                                        <div class="msj_to_customer" id="msj_to_customer"
                                             v-initSummerNote="{initMethod:_initSummerNote}"></div>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.msj_to_customer.$error">
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

