<script type='text/x-template' id='business-categories-template'>
    <div>

        <div class='content-component'>

            <div v-if="configModalBusinessSubcategories.viewAllow">
                <business-subcategories-component
                    ref="refBusinessSubcategories"
                    :params="configModalBusinessSubcategories"
                >
                </business-subcategories-component>
            </div>

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
                    <table id="business-categories-grid"
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
                <b-form id="businessCategoriesForm" v-on:submit.prevent="_submitForm">


                    <b-container>


                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('name',$v.model.attributes.name)">
                                    <label class="form__label " v-html='getLabelForm("name")' ></label>
                                    <div class="content-element-form">
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
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.name.$error">
      <span v-if="!$v.model.attributes.name.required">
       <?php  echo "{{model.structure.name.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.name.maxLength">
       <?php  echo "{{model.structure.name.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
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
                            <b-col md="12">
                                <div class=" content-box-image content-box-preview"
                                     @click="_uploadDataImage" id="manager-src"
                                     :class="getClassErrorForm('src',$v.model.attributes.src)">
                                    <img class="content-box-image__preview" id="preview-src">
                                    <div class="content-element-form">
                                        <input
                                            v-initEventUploadSrc="{initMethod:_managerEventsUpload,modelCurrent: model,paramsInit:getAttributesManagerUpload({nameField:'src',modelCurrent: model})}"
                                            type="file" id="file-src" class="hidden"
                                            v-bind:name="getNameAttribute('src')">
                                    </div>
                                    <div class="progress-gallery-image not-view" id="progress-src">
                                        <div class="progress__bar"></div>
                                        <div class="progress__percent">0%</div>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.src.$error">
      <span v-if="!$v.model.attributes.src.required">
       <?php  echo "{{model.structure.src.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('has_icon',$v.model.attributes.has_icon)">
                                    <label class="form__label " v-html='getLabelForm("has_icon")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.has_icon.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('has_icon')"
                                            v-bind:name="getNameAttribute('has_icon')"
                                            class="form-control m-input"
                                            @change="_setValueForm('has_icon', $v.model.attributes.has_icon.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.has_icon.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('icon_class',$v.model.attributes.icon_class)">
                                    <label class="form__label " v-html='getLabelForm("icon_class")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.icon_class.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('icon_class')"
                                            v-bind:name="getNameAttribute('icon_class')"
                                            class="form-control m-input"
                                            @change="_setValueForm('icon_class', $v.model.attributes.icon_class.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.icon_class.$error">
      <span v-if="!$v.model.attributes.icon_class.required">
       <?php  echo "{{model.structure.icon_class.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.icon_class.maxLength">
       <?php  echo "{{model.structure.icon_class.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('description',$v.model.attributes.description)">
                                    <label class="form__label " v-html='getLabelForm("description")' ></label>
                                    <div class="content-element-form">
<textarea
    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
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

