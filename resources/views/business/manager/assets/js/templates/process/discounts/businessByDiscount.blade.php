<script type='text/x-template' id='business-by-discount-template'>
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
                                :manager-menu-config="managerMenuConfig">

                            </menu-admin-grid>
                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="business-by-discount-grid"
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
                <b-form id="businessByDiscountForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('state',$v.model.attributes.state)">
                                    <label class="form__label " v-html='getLabelForm("state")'></label>
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
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label
                                        class="form__label "><?php echo '{{($v.model.attributes.type.$model==0?"%":"$")+getLabelForm("value") }}'?></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.value.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('value')"
                                            v-bind:name="getNameAttribute('value')"
                                            min="0" class="form-control m-input"
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
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4" v-if="allowManagerProcess.has_limit">
                                <div class="form-group"

                                     :class="getClassErrorForm('has_limit',$v.model.attributes.has_limit)">
                                    <label class="form__label " v-html='getLabelForm("has_limit")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.has_limit.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('has_limit')"
                                            v-bind:name="getNameAttribute('has_limit')"
                                            class="form-control m-input"
                                            @change="_setValueForm('has_limit', $v.model.attributes.has_limit.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.has_limit.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="4" v-if="$v.model.attributes.has_limit.$model==true">
                                <div class="form-group"
                                     :class="getClassErrorForm('has_limit_end',$v.model.attributes.has_limit_end)">
                                    <label class="form__label " v-html='getLabelForm("has_limit_end")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.has_limit_end.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('has_limit_end')"
                                            v-bind:name="getNameAttribute('has_limit_end')"
                                            class="form-control m-input"
                                            @change="_setValueForm('has_limit_end', $v.model.attributes.has_limit_end.$model)"
                                            v-focus-select
                                            v-reset-field="{form:$v.model.attributes,fieldName:'has_limit_end'}"
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.has_limit_end.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row v-if="$v.model.attributes.has_limit.$model==true">
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('limit_init',$v.model.attributes.limit_init)">
                                    <label class="form__label " v-html='getLabelForm("limit_init")'></label>
                                    <div class="content-element-form">
                                        <data-time-picker
                                            :options-events="{childrenSelector:'#limit_end'}"
                                            @input="_setValueForm('limit_init', $event)"
                                            :id="'limit_init'"
                                            :options="{format:'DD/MM/YYYY - hh:mm a',minValue: new Date(),viewMode:'days'}"
                                        >

                                        </data-time-picker>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.limit_init.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4" v-if="$v.model.attributes.has_limit_end.$model==true">
                                <div class="form-group"
                                     v-if="$v.model.attributes.limit_init.$model!='' && $v.model.attributes.limit_init.$model!=null"

                                     :class="getClassErrorForm('limit_end',$v.model.attributes.limit_end)">
                                    <label class="form__label " v-html='getLabelForm("limit_end")'></label>
                                    <div class="content-element-form">

                                        <data-time-picker
                                            @input="_setValueForm('limit_end', $event)" :id="'limit_end'"
                                            :options="{viewMode:'days',format:'DD/MM/YYYY - hh:mm a',minValue:$v.model.attributes.limit_init.$model}"

                                        >

                                        </data-time-picker>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.limit_end.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                                <div class="form-group" v-else>
                                    <span>Seleccione una fecha Inicial.</span>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4" v-if="allowManagerProcess.fields.code">
                                <div class="form-group"

                                     :class="getClassErrorForm('code',$v.model.attributes.code)">
                                    <label class="form__label " v-html='getLabelForm("code")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.code.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('code')"
                                            v-bind:name="getNameAttribute('code')"
                                            class="form-control m-input"
                                            @change="_setValueForm('code', $v.model.attributes.code.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.code.$error">
      <span v-if="!$v.model.attributes.code.required">
       <?php  echo "{{model.structure.code.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.code.maxLength">
       <?php  echo "{{model.structure.code.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </b-row>
                        <b-row>

                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('name',$v.model.attributes.name)">
                                    <label class="form__label " v-html='getLabelForm("name")'></label>
                                    <div class="content-element-form">
                                        <input
                                            class="form-control"
                                            v-model.trim="$v.model.attributes.name.$model"
                                            v-bind:id="getNameAttribute('name')"
                                            v-bind:name="getNameAttribute('name')"
                                            @change="_setValueForm('name', $v.model.attributes.name.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.name.$error">
      <span v-if="!$v.model.attributes.name.required">
       <?php  echo "{{model.structure.name.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>


                        <discount-by-products-component v-if="configDataDiscountByProducts.view"
                                                        :params="configDataDiscountByProducts"
                        ></discount-by-products-component>


                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>

