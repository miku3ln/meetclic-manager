<script type="text/x-template" id="register-form-template">
    <div>
        <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">
            <h1 class="title-main">
                <span v-form-text="{key:'actions.register','addTitle':'Hola'}"
                      v-if="!$v.model.attributes.id.$model"></span>
                <span v-form-text="'actions.update'" v-if="$v.model.attributes.id.$model"></span>

            </h1>

            <b-container>
                <input v-model="model.attributes.id" type="hidden"
                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')">
                <b-row>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('status',$v.model.attributes.status)">
                            <label class="form__label " v-html='getLabelForm("status")'></label>
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
       <?php echo "{{model.structure.status.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('dictionary_grammatical_class_data_id',$v.model.attributes.dictionary_grammatical_class_data_id)">
                            <label
                                class="form__label "
                                v-html='getLabelForm("dictionary_grammatical_class_data_id")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.dictionary_grammatical_class_data_id.model"
                                    type="hidden"
                                    v-bind:id="getNameAttribute('dictionary_grammatical_class_data_id')"
                                    v-bind:name="getNameAttribute('dictionary_grammatical_class_data_id')"
                                    @change="_setValueForm('dictionary_grammatical_class_data_id', $v.model.attributes.dictionary_grammatical_class_data_id.$model)"
                                    v-reset-field="{form:$v.model.attributes,fieldName:'dictionary_grammatical_class_data_id'}"

                                >
                                <select
                                    class="form-control m-select2"
                                    v-init-s2-manager="{  _initS2Manager:initS2GramaticalClass }"
                                ></select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.dictionary_grammatical_class_data_id.$error">
      <span v-if="!$v.model.attributes.dictionary_grammatical_class_data_id.required">
       <?php echo "{{model.structure.dictionary_grammatical_class_data_id.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>

                </b-row>

                <legend class="h6 mb-2 legend--section">INFORMACION PALABRA</legend>

                <b-row>
                    <b-col md="6">
                        <div class="form-group"

                             :class="getClassErrorForm('name',$v.model.attributes.value)">
                            <label
                                class="form__label " v-html='getLabelForm("value")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model.trim="$v.model.attributes.value.$model"
                                    type="text"
                                    v-bind:id="getNameAttribute('name')"
                                    v-bind:name="getNameAttribute('name')"
                                    class="form-control m-input"
                                    @change="_setValueForm('value', $v.model.attributes.value.$model)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.value.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="6">
                        <div class="form-group"

                             :class="getClassErrorForm('translation_value',$v.model.attributes.translation_value)">
                            <label
                                class="form__label " v-html='getLabelForm("translation_value")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model.trim="$v.model.attributes.translation_value.$model"

                                    v-bind:id="getNameAttribute('translation_value')"
                                    v-bind:name="getNameAttribute('translation_value')"
                                    class="form-control m-input"
                                    @change="_setValueForm('translation_value', $v.model.attributes.translation_value.$model)"
                                    v-focus-select
                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.translation_value.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>
                <legend class="h6 mb-2 legend--section">DATOS TECNICOS PALABRA</legend>

                <b-row>

                    <b-col md="6">
                        <div class="form-group"
                             :class="getClassErrorForm('usage_context', $v.model.attributes.usage_context)">
                            <label class="form__label" v-html="getLabelForm('usage_context')"></label>

                            <div class="content-element-form">
    <textarea
        v-model.trim="$v.model.attributes.usage_context.$model"
        :id="getNameAttribute('usage_context')"
        :name="getNameAttribute('usage_context')"
        class="form-control m-input"
        rows="3"
        @change="_setValueForm('usage_context', $v.model.attributes.usage_context.$model)"
        v-focus-select
    ></textarea>
                            </div>

                            <div class="content-message-errors">
                                <b-form-invalid-feedback :state="!$v.model.attributes.usage_context.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="6">
                        <div class="form-group"

                             :class="getClassErrorForm('description',$v.model.attributes.description)">
                            <label
                                class="form__label " v-html='getLabelForm("description")'></label>
                            <div class="content-element-form">

                                <textarea
                                    v-model.trim="$v.model.attributes.description.$model"
                                    :id="getNameAttribute('description')"
                                    :name="getNameAttribute('description')"
                                    class="form-control m-input"
                                    rows="3"
                                    @change="_setValueForm('description', $v.model.attributes.description.$model)"
                                    v-focus-select
                                ></textarea>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.description.$error">
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>


                </b-row>
                <div v-if="$v.model.attributes.id.$model">
                    <legend class="h6 mb-2 legend--section">DATOS ADICIONALES</legend>

                    <b-row>
                        <b-col md="6">

                            <div
                                v-uploadManager="uploadConfigPronunciation"
                                class="upm"
                            >

                            </div>
                        </b-col>

                    </b-row>
                </div>

            </b-container>


            <!-- ✅ Acciones fijas (abajo derecha) -->
            <div class="embark-actions" role="group" aria-label="Acciones de embarque">

                <button type="button"
                        class="btn btn-success btn--manager-process"
                        :disabled="!validateForm()"
                        v-on:click="_saveModel()"

                >
                    <i class="fa fa-floppy-o embark-actions__icon" aria-hidden="true"></i>
                    <span class="embark-actions__text" v-form-text="'actions.register'"></span>
                </button>
                <button type="button"
                        class="embark-actions__btn btn btn-warning btn--manager-process"

                        v-on:click="onReturnMain()"

                >
                    <i class="fa fa-arrow-left embark-actions__icon" aria-hidden="true"></i>
                    <span class="embark-actions__text" v-form-text="'actions.back'"></span>
                </button>
            </div>

        </b-form>

    </div>

</script>

