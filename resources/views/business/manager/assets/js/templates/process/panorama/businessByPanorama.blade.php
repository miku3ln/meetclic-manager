<script type="text/x-template" id="panorama-template">
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
                <button  v-if="showManager" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_savePanorama()">
                    <?php echo "{{lblBtnSave}}"?>
                </button>
                <div class="content-manager-buttons-grid" v-if="managerMenuConfig.view && !showManager">

                    <a
                            v-init-tool-tip
                            v-for="(menu, key) in managerMenuConfig.menuCurrent"
                            @click="_managerMenuGrid(key, menu)"
                            class="content-manager-buttons-grid__a "
                            data-toggle="tooltip"
                            data-placement="top"
                            v-bind:id="'a-menu-'+menu.rowId"
                            v-bind:data-original-title="<?php echo "menu['title']" ?>">
                        <i
                                v-bind:class="<?php echo "menu['icon']" ?>"></i>
                    </a>
                </div>
            </div>
        </b-container>
        <div class="custom-scroll-admin-grid table-responsive"  v-show="!showManager">
            <table id="panorama-grid"
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
        <div class="content-form" v-if="showManager">

            <b-form id="panoramaForm" v-on:submit.prevent="_submitForm">


                <b-container class="bv-example-row">

                    <div class="manager-panorama">

                        <input v-model="modelPanorama.attributes.id" type="hidden" name="Panorama[id]">
                        <input v-model="modelPanorama.attributes.business_id" type="hidden"
                               name="Panorama[business_id]">
                        <b-row>
                            <b-col lg="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('status',$v.modelPanorama.attributes.status)">
                                    <label class="form__label col-md-4" v-html='getLabelForm("status")' ></label>
                                    <div class="content col-md-8">
                                        <input
                                                v-model.trim="$v.modelPanorama.attributes.status.$model"
                                                type="checkbox"
                                                name="Panorama[status]"
                                                class="form-control m-input"
                                                @change="_setValueForm('status', $event.target.value)"
                                        >
                                    </div>
                                    <div class="message col-md-12">

                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('routes_map_by_routes_drawing_id_data',$v.modelPanorama.attributes.routes_map_by_routes_drawing_id_data)">
                                    <label class="form__label " v-html='getLabelForm("routes_map_by_routes_drawing_id_data")' ></label>
                                    <div class="content">
                                        <input type="hidden"
                                               v-model.trim="$v.modelPanorama.attributes.routes_map_by_routes_drawing_id_data.$model"
                                               v-bind:id="getNameAttribute('routes_map_by_routes_drawing_id_data')"
                                               v-bind:name="getNameAttribute('routes_map_by_routes_drawing_id_data')"
                                               @change="_setValueForm('routes_map_by_routes_drawing_id_data', $event.target.value)"
                                        >
                                        <select
                                                id="routes_map_by_routes_drawing_id_data"
                                                class="form-control m-select2 routes_map_by_routes_drawing_id_data"
                                                v-routesPointsS2="{id:modelPanorama.attributes.id,routesPointsS2:_routesPointsS2}"
                                        >
                                        </select>


                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelPanorama.attributes.routes_map_by_routes_drawing_id_data.$error">
                                            <span v-if="!$v.modelPanorama.attributes.routes_map_by_routes_drawing_id_data.required">
                                <?php  echo "{{modelPanorama.structure.routes_map_by_routes_drawing_id_data.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>

                        <b-row>

                            <b-col lg="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('title',$v.modelPanorama.attributes.title)">
                                    <label class="form__label col-md-12" v-html='getLabelForm("title")' ></label>

                                    <div class="content col-md-12">

                                        <input
                                                v-model.trim="$v.modelPanorama.attributes.title.$model"
                                                type="text"
                                                class="form-control m-input"
                                                name="Panorama[title]"
                                                @change="_setValueForm('title', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="message col-md-12">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelPanorama.attributes.title.$error">
                                            <span v-if="!$v.modelPanorama.attributes.title.required">
                                <?php  echo "{{modelPanorama.structure.title.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col lg="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('subtitle',$v.modelPanorama.attributes.subtitle)">
                                    <label class="form__label col-md-12" v-html='getLabelForm("subtitle")' ></label>

                                    <div class="content col-md-12">

                                        <input
                                                v-model.trim="$v.modelPanorama.attributes.subtitle.$model"
                                                type="text"
                                                class="form-control m-input"
                                                name="Panorama[subtitle]"
                                                @change="_setValueForm('subtitle', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="message col-md-12">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelPanorama.attributes.subtitle.$error">
                                            <span v-if="!$v.modelPanorama.attributes.subtitle.required">
                                <?php  echo "{{modelPanorama.structure.subtitle.required.msj}}"?>
                            </span>
                                            <span v-if="!$v.modelPanorama.attributes.subtitle.minLength">
                                <?php  echo "Valor minimo debe de ser 4"?>
                            </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>


                        <b-row>
                            <b-col lg="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('description',$v.modelPanorama.attributes.description)"
                                >
                                    <div class="form__label " v-html='getLabelForm("description")' ></div>
                                    <div class="col-md-12">

                                        <textarea
                                                v-model.trim="$v.modelPanorama.attributes.description.$model"
                                                name="Panorama[description]"
                                                class="form-control m-input"
                                               @change="_setValueForm('description', $event.target.value)"
                                                v-focus-select
                                        ></textarea>
                                    </div>
                                    <div class="message col-md-12">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelPanorama.attributes.description.$error">
                                            <span v-if="!$v.modelPanorama.attributes.description.required">
                                <?php  echo "{{modelPanorama.structure.description.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>

                        <div class="row">

                            <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="content-box-image content-box-preview" >
                                    <img class="content-box-image__preview" id="preview-src">


                                    <input

                                        v-initEventUploadSource="{initMethod:_managerEventsUpload,modelCurrent: this.modelPanorama,paramsInit:getAttributesManagerUpload({nameField:'src',modelCurrent: this.modelPanorama})}"
                                        type="file"
                                            id="file-src"
                                            name="Information[file_upload_panorama]"
                                    >

                                </div>
                                <div class="progress-panorama-image not-view">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                            </div>
                        </div>
                        <div v-if="$v.modelPanorama.attributes.type_panorama.$model==1" class="container-data" nx-geometry id="container-data">


                        </div>
                    </div>


                </b-container>


            </b-form>
        </div>


    </div>

</script>
