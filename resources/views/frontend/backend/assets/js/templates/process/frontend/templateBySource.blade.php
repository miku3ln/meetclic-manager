<script type='text/x-template' id='source-favicon-template'>
    <div>
        <div class='content-component' id="source-favicon-manager">

            <b-form id="source-favicon-form" v-on:submit.prevent="_submitForm">


                <b-container>
                    <input v-model="model.attributes.id" type="hidden"
                           v-bind:id="getNameAttribute('id')"
                           v-bind:name="getNameAttribute('id')"
                    >
                    <b-row>

                        <b-col md="12">
                            <label class="form__label " v-html='getLabelForm("source")' ></label>
                            <div class=" content-box-image content-box-preview"
                                 @click="_uploadDataImage" id="manager-source"
                                 :class="getClassErrorForm('source',$v.model.attributes.source)">
                                <img class="content-box-image__preview preview-manager preview-manager--ico"
                                     v-bind:id="getIdManagerUploads(0)" name-source="source">
                                <div class="content-element-form">
                                    <input
                                        v-initEventUpload="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                        type="file"
                                        v-bind:id="getIdManagerUploads(1)"
                                        class="hidden"
                                        v-bind:name="getNameAttribute('source')">
                                </div>
                                <div class="progress-gallery-image not-view"
                                     v-bind:id="getIdManagerUploads(2)">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.source.$error">
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

<script type='text/x-template' id='source-logo-main-template'>
    <div>
        <div class='content-component' id="source-logo-main-manager">

            <b-form id="source-logo-main-form" v-on:submit.prevent="_submitForm">


                <b-container>
                    <input v-model="model.attributes.id" type="hidden"
                           v-bind:id="getNameAttribute('id')"
                           v-bind:name="getNameAttribute('id')"
                    >
                    <b-row>

                        <b-col md="12">
                            <label class="form__label " v-html='getLabelForm("source")' ></label>
                            <div class=" content-box-image content-box-preview"
                                 @click="_uploadDataImage" id="manager-source"
                                 :class="getClassErrorForm('source',$v.model.attributes.source)">
                                <img class="content-box-image__preview preview-manager"
                                     v-bind:id="getIdManagerUploads(0)" name-source="source">
                                <div class="content-element-form">
                                    <input
                                        v-initEventUpload="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                        type="file"
                                        v-bind:id="getIdManagerUploads(1)"
                                        class="hidden"
                                        v-bind:name="getNameAttribute('source')">
                                </div>
                                <div class="progress-gallery-image not-view"
                                     v-bind:id="getIdManagerUploads(2)">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.source.$error">
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
<script type='text/x-template' id='template-by-source-template'>
    <div>


        <div class='content-component'>

            <b-container class="container-template-by-source" v-if="initManager">
                <b-row>

                    <b-col md="4">

                        <source-logo-main-component
                            ref="refSourceLogoMain"
                            :params="sourcesConfig"
                        >
                        </source-logo-main-component>
                    </b-col>

                </b-row>
                <b-row>
                    <b-col md="4">

                        <source-favicon-component
                            ref="refSourceFavicon"
                            :params="sourcesConfig"
                        >
                        </source-favicon-component>
                    </b-col>
                </b-row>
            </b-container>
            <b-container v-if="!initManager">
                <b-row>
                    Cargando....
                </b-row>
            </b-container>
        </div>
    </div>
</script>

