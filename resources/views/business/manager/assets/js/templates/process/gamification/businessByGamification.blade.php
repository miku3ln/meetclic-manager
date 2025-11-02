<script type='text/x-template' id='business-by-gamification-template'>
    <div>

        <div class='content-component'>


            <b-container class="container-manager-buttons">
                <div v-if="configModalGamificationByProcess.viewAllow">
                    <gamification-by-process-component
                        ref="refGamificationByProcess"
                        :params="configModalGamificationByProcess"
                    >
                    </gamification-by-process-component>
                </div>
                <div v-if="configModalGamificationByRewards.viewAllow">
                    <gamification-by-rewards-component
                        ref="refGamificationByRewards"
                        :params="configModalGamificationByRewards"
                    >
                    </gamification-by-rewards-component>
                </div>


                <div class="content-row-manager-buttons">
                    <button

                        type="button"
                        class="btn btn-danger"
                        v-on:click="_viewManager(showManager?2:1)">
                        <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?></button>
                    <button v-if="showManager" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?></button>

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

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="business-by-gamification-grid"
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
                <b-form id="businessByGamificationForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('state',$v.model.attributes.state)">
                                    <label class="form__label "v-html='getLabelForm("state")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.state.$model"
                                                v-bind:id="getNameAttribute('state')"
                                                v-bind:name="getNameAttribute('state')"
                                                class="form-control m-input"
                                                @change="_setValueForm('state', $v.model.attributes.state.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.state.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php  echo "{{model.structure.state.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>

                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('allow_exchange',$v.model.attributes.allow_exchange)">
                                    <label
                                        class="form__label "v-html='getLabelForm("allow_exchange")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.allow_exchange.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('allow_exchange')"
                                            v-bind:name="getNameAttribute('allow_exchange')"
                                            class="form-control m-input"
                                            @change="_setValueForm('allow_exchange', $v.model.attributes.allow_exchange.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.allow_exchange.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('allow_exchange_business',$v.model.attributes.allow_exchange_business)">
                                    <label
                                        class="form__label "v-html='getLabelForm("allow_exchange_business")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.allow_exchange_business.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('allow_exchange_business')"
                                            v-bind:name="getNameAttribute('allow_exchange_business')"
                                            class="form-control m-input"
                                            @change="_setValueForm('allow_exchange_business', $v.model.attributes.allow_exchange_business.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.allow_exchange_business.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label class="form__label "v-html='getLabelForm("value")' ></label>
                                    <div class="content">
                                        <input
                                            v-model.trim="$v.model.attributes.value.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('value')"
                                            v-bind:name="getNameAttribute('value')"
                                            class="form-control m-input"
                                            @change="_setValueForm('value', $event.target.value)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.value.$error">
                                            <span v-if="!$v.model.attributes.value.required">
                                <?php  echo "{{model.structure.value.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col lg="4" v-show="false">
                                <div class="form-group"
                                     :class="getClassErrorForm('value_unit',$v.model.attributes.value_unit)">
                                    <label class="form__label "v-html='getLabelForm("value_unit")' ></label>
                                    <div class="content ">
                                        <input
                                            v-model.trim="$v.model.attributes.value_unit.$model"
                                            type="number"
                                            min="0"
                                            v-bind:id="getNameAttribute('value_unit')"
                                            v-bind:name="getNameAttribute('value_unit')"
                                            class="form-control m-input"
                                            @change="_setValueForm('value_unit', $event.target.value)"

                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.value_unit.$error">
                                            <span v-if="!$v.model.attributes.value_unit.required">
                                <?php  echo "{{model.structure.value_unit.required.msj}}"?>
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
                                    <label class="form__label "v-html='getLabelForm("description")' ></label>

                                    <div class="content ">

                                        <textarea
                                             rows="2" cols="50"
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
                                <?php  echo "{{model.structure.description.required.msj}}"?>
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
    </div>
</script>

