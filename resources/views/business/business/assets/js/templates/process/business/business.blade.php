<script type="text/x-template" id="business-template">
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
                        <div v-for="(menu, key) in managerMenuConfig.menuCurrent" class="inline-data">
                            <a v-if="menu.isUrl==true"
                               v-bind:href="menu.url"
                                   v-init-tool-tip
                                   v-bind:id="'a-menu-'+menu.rowId"
                                   class="content-manager-buttons-grid__a " data-toggle="tooltip"
                                   data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                            </a>
                            <a v-else
                               v-init-tool-tip
                               v-bind:id="'a-menu-'+menu.rowId"
                               v-on:click="_managerMenuGrid(key, menu)"
                               class="content-manager-buttons-grid__a " data-toggle="tooltip"
                               data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </b-container>
        <?php ?>
        <div class="content-manager-grid">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <table id="business-grid"
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

            <b-form id="businessForm" v-on:submit.prevent="_submitForm">

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >

                <b-container>


                    <div class="content-form">

                        <div class="row">

                            <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12" id="col-content-manager-url_img">
                                <div class="content-box-image content-box-preview" id="container_selector_image"
                                     @click="_uploadData">
                                    <img class="content-box-image__preview"
                                         v-init-img="{url:$v.model.attributes.source.$model}">
                                    <div class="content-box-image__manager">
                                        <button @click="_uploadData" class="btn-upload-resources "
                                                id="btn-add-url_img">
                                            <i class="icon icon-plus"></i>
                                            <?php echo "{{lblUploadName}}" ?>
                                        </button>
                                        <input
                                                v-_upload-resource="{_initEventsUpload:_initEventsUpload}"
                                                type="file"
                                                id="file_upload_img"
                                                class="hidden"
                                                name="Information[file_upload_img]"
                                        >
                                    </div>
                                </div>
                                <div class="progress-business not-view">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                            </div>
                        </div>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('title',$v.model.attributes.title)">
                                    <label class="form__label " v-html='getLabelForm("title")' ></label>
                                    <div class="content">
                                        <input
                                                v-model.trim="$v.model.attributes.title.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('title')"
                                                v-bind:name="getNameAttribute('title')"
                                                class="form-control m-input"
                                                @change="_setValueForm('title', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.title.$error">
                                            <span v-if="!$v.model.attributes.title.required">
                                <?php  echo "{{model.structure.title.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <input v-model="model.attributes.id" type="hidden"

                                   v-bind:id="getNameAttribute('id')"
                                   v-bind:name="getNameAttribute('id')"
                            >
                            <input v-model="model.attributes.street_lat" type="hidden"

                                   v-bind:id="getNameAttribute('street_lat')"
                                   v-bind:name="getNameAttribute('street_lat')"
                            >
                            <input v-model="model.attributes.street_lng" type="hidden"

                                   v-bind:id="getNameAttribute('street_lng')"
                                   v-bind:name="getNameAttribute('street_lng')"
                            >
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('countries_id',$v.model.attributes.countries_id)">
                                    <label class="form__label " v-html='getLabelForm("countries_id")' ></label>
                                    <div class="content">

                                        <select

                                                v-bind:id="getNameAttribute('countries_id')"
                                                v-bind:name="getNameAttribute('countries_id')"
                                                class="form-control m-input"
                                                @change="_setValueForm('countries_id',$v.model.attributes.countries_id.$model)"
                                                v-model.trim="$v.model.attributes.countries_id.$model"


                                        >
                                            <option v-for="(row,index) in countriesData"
                                                    v-bind:value="index"><?php echo '{{row}}' ?></option>
                                        </select>

                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.countries_id.$error">
                                            <span v-if="!$v.model.attributes.countries_id.required">
                                <?php  echo "{{model.structure.countries_id.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>

                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('business_subcategories_id',$v.model.attributes.business_subcategories_id)">
                                    <label class="form__label " v-html='getLabelForm("business_subcategories_id")' ></label>
                                    <div class="content">

                                        <select

                                                v-bind:id="getNameAttribute('business_subcategories_id')"
                                                v-bind:name="getNameAttribute('business_subcategories_id')"
                                                class="form-control m-input"
                                                v-model.trim="$v.model.attributes.business_subcategories_id.$model"
                                                @change="_setValueForm('business_subcategories_id', $v.model.attributes.business_subcategories_id.$model)"


                                        >
                                            <optgroup v-for="(row,index) in businessSubcategoriesData"
                                                      v-bind:label="index">
                                                <option v-for="(rowInfo,indexInfo) in row"
                                                        v-bind:value="indexInfo">
                                                    <?php echo '{{rowInfo}}' ?>

                                                </option>


                                            </optgroup>
                                        </select>

                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.business_subcategories_id.$error">
                                            <span v-if="!$v.model.attributes.business_subcategories_id.required">
                                <?php  echo "{{model.structure.business_subcategories_id.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="floating-panel-manager">
                                    <input id="search-map-current"
                                           class="floating-panel-manager__search"
                                           type="textbox"
                                           value="Ecuador"
                                           v-focus-select
                                    >

                                </div>
                                <div id="map" class="map-information"
                                     v-init-map="{initMapCurrent:initMapCurrent,modelBusiness:$v.model.attributes}">

                                </div>
                            </div>
                        </div>
                        <b-row>
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('street_1',$v.model.attributes.street_1)">
                                    <label class="form__label " v-html='getLabelForm("street_1")' ></label>
                                    <div class="content">
                                        <input
                                                v-model.trim="$v.model.attributes.street_1.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('street_1')"
                                                v-bind:name="getNameAttribute('street_1')"
                                                class="form-control m-input"
                                                @change="_setValueForm('street_1', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.street_1.$error">
                                            <span v-if="!$v.model.attributes.street_1.required">
                                <?php  echo "{{model.structure.street_1.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>

                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('street_2',$v.model.attributes.street_2)">
                                    <label class="form__label " v-html='getLabelForm("street_2")' ></label>
                                    <div class="content">
                                        <input
                                                v-model.trim="$v.model.attributes.street_2.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('street_2')"
                                                v-bind:name="getNameAttribute('street_2')"
                                                class="form-control m-input"
                                                @change="_setValueForm('street_2', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.street_2.$error">
                                            <span v-if="!$v.model.attributes.street_2.required">
                                <?php  echo "{{model.structure.street_2.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('phone_value',$v.model.attributes.phone_value)">
                                    <label class="form__label " v-html='getLabelForm("phone_value")' ></label>
                                    <div class="content">
                                        <input
                                                v-model.trim="$v.model.attributes.phone_value.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('phone_value')"
                                                v-bind:name="getNameAttribute('phone_value')"
                                                class="form-control m-input"
                                                @change="_setValueForm('phone_value', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.phone_value.$error">
                                            <span v-if="!$v.model.attributes.phone_value.required">
                                <?php  echo "{{model.structure.phone_value.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>

                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('email',$v.model.attributes.email)">
                                    <label class="form__label " v-html='getLabelForm("email")' ></label>
                                    <div class="content">
                                        <input
                                                v-model.trim="$v.model.attributes.email.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('email')"
                                                v-bind:name="getNameAttribute('email')"
                                                class="form-control m-input"
                                                @change="_setValueForm('email', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.email.$error">
                                            <span v-if="!$v.model.attributes.email.required">
                                <?php  echo "{{model.structure.email.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('description',$v.model.attributes.description)">
                                    <label class="form__label " v-html='getLabelForm("description")' ></label>
                                    <div class="content">

                                        <textarea
                                                rows="10" cols="50"
                                                v-model.trim="$v.model.attributes.description.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('description')"
                                                v-bind:name="getNameAttribute('description')"
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

                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('page_url',$v.model.attributes.page_url)">
                                    <label class="form__label " v-html='getLabelForm("page_url")' ></label>
                                    <div class="content">
                                        <input
                                                v-model.trim="$v.model.attributes.page_url.$model"
                                                type="text"
                                                v-bind:id="getNameAttribute('page_url')"
                                                v-bind:name="getNameAttribute('page_url')"
                                                class="form-control m-input"
                                                @change="_setValueForm('page_url', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.page_url.$error">
                                            <span v-if="!$v.model.attributes.page_url.required">
                                <?php  echo "{{model.structure.page_url.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                    </div>


                </b-container>

            </b-form>

        </div>


    </div>

</script>
