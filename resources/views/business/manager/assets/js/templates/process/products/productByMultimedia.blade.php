<script type='text/x-template' id='product-by-multimedia-template'>
    <div>

        <div class='content-component'>


            <b-modal
                    hide-footer
                    id="modal-product-by-multimedia"
                    ref="refProductByMultimediaModal"
                    size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons">
                        <button
                                v-if="!managerMenuConfig.view"
                                type="button"
                                class="btn "
                                :class="{'btn-success':!showManager,'btn-danger':showManager}"
                                v-on:click="_viewManager(showManager?2:1)">
                            <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?>    </button>
                        <button v-if="showManager" type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?>    </button>

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

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="productByMultimediaForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <div class=" content-box-image content-box-preview"
                                              id="manager-source"
                                             :class="getClassErrorForm('source',$v.model.attributes.source)">
                                            <img class="content-box-image__preview" id="preview-source">
                                            <div class="content-element-form">
                                                <input
                                                        v-initEventUploadSource="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                                        type="file" id="file-source"
                                                        v-bind:name="getNameAttribute('source')">
                                            </div>
                                            <div class="progress-gallery-image not-view" id="progress-source">
                                                <div class="progress__bar"></div>
                                                <div class="progress__percent">0%</div>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.source.$error">
      <span v-if="!$v.model.attributes.source.required">
       <?php  echo "{{model.structure.source.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>

                                    <b-col md="4">
                                        <div class="form-group"

                                             :class="getClassErrorForm('view',$v.model.attributes.view)">
                                            <label class="form__label " v-html='getLabelForm("view")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                        v-model.trim="$v.model.attributes.view.$model"
                                                        type="checkbox"
                                                        v-bind:id="getNameAttribute('view')"
                                                        v-bind:name="getNameAttribute('view')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('view', $v.model.attributes.view.$model)"
                                                        v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.view.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>

                                </b-row>
                                <b-row>
                                    <b-col md="5">
                                        <div class="form-group"

                                             :class="getClassErrorForm('title',$v.model.attributes.title)">
                                            <label class="form__label " v-html='getLabelForm("title")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                        v-model.trim="$v.model.attributes.title.$model"
                                                        type="text"
                                                        v-bind:id="getNameAttribute('title')"
                                                        v-bind:name="getNameAttribute('title')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('title', $v.model.attributes.title.$model)"
                                                        v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.title.$error">
      <span v-if="!$v.model.attributes.title.required">
       <?php  echo "{{model.structure.title.required.msj}}"?>
      </span>
                                                    <span v-if="!$v.model.attributes.title.maxLength">
       <?php  echo "{{model.structure.title.maxLength.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="5">
                                        <div class="form-group"

                                             :class="getClassErrorForm('subtitle',$v.model.attributes.subtitle)">
                                            <label class="form__label " v-html='getLabelForm("subtitle")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                        v-model.trim="$v.model.attributes.subtitle.$model"
                                                        type="text"
                                                        v-bind:id="getNameAttribute('subtitle')"
                                                        v-bind:name="getNameAttribute('subtitle')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('subtitle', $v.model.attributes.subtitle.$model)"
                                                        v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.subtitle.$error">
      <span v-if="!$v.model.attributes.subtitle.maxLength">
       <?php  echo "{{model.structure.subtitle.maxLength.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="2">
                                        <div class="form-group"
                                             :class="getClassErrorForm('priority',$v.model.attributes.priority)">
                                            <label class="form__label " v-html='getLabelForm("priority")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                        v-model.trim="$v.model.attributes.priority.$model"
                                                        type="number"
                                                        v-bind:id="getNameAttribute('priority')"
                                                        v-bind:name="getNameAttribute('priority')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('priority', $v.model.attributes.priority.$model)"
                                                        v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.priority.$error">
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>


                                <b-row>
                                    <b-col md="12">
                                        <div class="form-group"

                                             :class="getClassErrorForm('description',$v.model.attributes.description)">
                                            <label class="form__label " v-html='getLabelForm("description")' ></label>
                                            <div class="content-element-form">
<textarea
        rows="10" class="form-control"
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
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                            </b-container>


                        </b-form>
                    </div>

                </div>

                <div class="content-manager-grid">

                    <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                        <table id="product-by-multimedia-grid"
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
            </b-modal>


        </div>
    </div>
</script>

