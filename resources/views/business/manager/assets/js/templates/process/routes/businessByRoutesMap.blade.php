<script type="text/x-template" id="routes-template">
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
                        class="btn btn-success" v-on:click="_saveRoutes()">
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
        <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
            <table id="routes-grid"
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
        <div class="content-form" v-show="showManager">

            <b-form id="routesForm" v-on:submit.prevent="_submitForm">
                <input v-model="modelRoutes.attributes.id" type="hidden" name="Routes[id]">
                <input v-model="modelRoutes.attributes.business_id" type="hidden" name="Routes[business_id]">

                <b-container class="bv-example-row">


                    <div class="manager-routes">
                        <br>
                        <b-row>
                            <b-col md="4" id="col-content-gestion-url_img">

                                <div class="form-group">
                                    <div id="container_selector_imagen" @click="_uploadData">
                                        <div id="prev_row_img">
                                            <div id="content-gestion-img">
                                                <div id="select_row_img" class="content-gestion-btns">
                                                    <button class="btn-upload-recursos "
                                                            id="btn-add-url_kml">
                                                        <i class="icon icon-plus"></i>
                                                        <?php echo "{{uploadConfig.labelsButtons.file}}" ?>
                                                    </button>
                                                    <input
                                                            type="file"
                                                            id="file_upload"
                                                            class="hidden"
                                                            name="file_upload"
                                                    >


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="progress_bar">
                                        <div class="percent">0%</div>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col lg="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('status',$v.modelRoutes.attributes.status)">
                                    <label class="form__label " v-html='getLabelForm("status")' ></label>
                                    <div class="content">
                                        <input
                                                v-model.trim="$v.modelRoutes.attributes.status.$model"
                                                type="checkbox"
                                                name="Routes[status]"
                                                class="form-control m-input"
                                                @change="_setValueForm('status', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('type_shortcut',$v.modelRoutes.attributes.type_shortcut)">
                                    <label class="form__label " v-html='getLabelForm("type_shortcut")' ></label>
                                    <div class="content ">
                                        <b-form-select
                                                v-model="$v.modelRoutes.attributes.type_shortcut.$model"
                                                name="Routes[type_shortcut]"
                                                :options="optionsShortcut"
                                                v-on:change="_setValueForm('type_shortcut',$v.modelRoutes.attributes.type_shortcut.$model)"

                                        ></b-form-select>

                                    </div>

                                </div>
                            </b-col>

                        </b-row>
                        <b-row>
                            <div class="col col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="content-box-image content-box-preview" @click="_uploadDataImage">
                                    <img class="content-box-image__preview" id="preview-route-src">
                                    <div>

                                        <input
                                                type="file"
                                                id="file_upload_src"
                                                class="hidden"
                                                name="Information[file_upload_src]"
                                        >
                                    </div>
                                </div>
                                <div class="progress-route-image not-view">
                                    <div class="progress__bar"></div>
                                    <div class="progress__percent">0%</div>
                                </div>
                            </div>

                        </b-row>
                        <b-row>
                            <b-col lg="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('adventure_type',$v.modelRoutes.attributes.adventure_type)">

                                    <b-form-group v-bind:label="getLabelForm('adventure_type')">
                                        <b-form-checkbox-group
                                                v-model="$v.modelRoutes.attributes.adventure_type.$model"
                                                name="Routes[adventure_type]"
                                                :options="optionsAdventureType"
                                                v-on:change="_setValueForm('adventure_type',$v.modelRoutes.attributes.adventure_type.$model)"
                                        ></b-form-checkbox-group>
                                    </b-form-group>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col lg="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('name',$v.modelRoutes.attributes.name)">
                                    <label class="form__label " v-html='getLabelForm("name")' ></label>

                                    <div class="content">

                                        <input
                                                v-model.trim="$v.modelRoutes.attributes.name.$model"
                                                type="text"
                                                class="form-control m-input"
                                                name="Routes[name]"
                                                @change="_setValueForm('name', $event.target.value)"
                                                v-focus-select
                                        >
                                    </div>
                                    <div class="message col-md-12">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelRoutes.attributes.name.$error">
                                            <span v-if="!$v.modelRoutes.attributes.name.required">
                                <?php  echo "{{modelRoutes.structure.name.required.msj}}"?>
                            </span>
                                            <span v-if="!$v.modelRoutes.attributes.name.minLength">
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
                                     :class="getClassErrorForm('description',$v.modelRoutes.attributes.description)"
                                >
                                    <label class="form__label" v-html='getLabelForm("description")' ></label>
                                    <div class="">

                                        <textarea
                                                v-model.trim="$v.modelRoutes.attributes.description.$model"
                                                name="Routes[description]"
                                                class="form-control m-input"
                                                @change="_setValueForm('description', $event.target.value)"
                                                v-focus-select
                                        ></textarea>
                                    </div>
                                    <div class="message col-md-12">
                                        <b-form-invalid-feedback
                                                :state="!$v.modelRoutes.attributes.description.$error">
                                            <span v-if="!$v.modelRoutes.attributes.description.required">
                                <?php  echo "{{modelRoutes.structure.description.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>


                        <?php echo " <h1 v-on:click='_dataChildren()'>{{ configParams.title}}</h1>" ?>
                        <b-row>
                            <b-col lg="12">
                                <input
                                        type="button"
                                        class="not-view"
                                        value="generate polygon from encoded"
                                        @click="_setMapFromEncoded()"
                                />
                                <input
                                        type="button"
                                        v-bind:value="configMap.buttons.clear.title"
                                        @click="_deleteAll()"
                                />
                                <input
                                        v-show="configMap.buttons.edit.view"
                                        type="button"
                                        v-bind:value="configMap.buttons.edit.title"
                                        @click="_toggleEditable()"

                                />

                                <input
                                        type="button" value="Generate Map Text"
                                        @click="_generateMapText()"
                                        class="not-view"
                                />
                            </b-col>
                        </b-row>


                        <b-row>
                            <b-col md="12">
                                <div class="floating-panel-manager-manager-routes">
                                    <input id="search-map-current"
                                           class="floating-panel-manager__search"
                                           type="textbox"
                                           value="Ecuador"
                                           v-focus-select
                                    >

                                </div>
                                <div id="myMap" style="height:400px; width:100%;"
                                >

                                </div>
                            </b-col>
                        </b-row>

                        <input
                                v-model="modelRoutes.attributes.kml_structure"
                                type="hidden"
                                name="Routes[kml_structure]">

                        <b-row>
                            <b-col lg="6">
                                <div class="form-group">

                                    <div class="message col-md-12">
                                        <b-form-invalid-feedback
                                                :state="true">
                                            <?php  echo "{{modelRoutes.structure.kml_structure.required.msj}}"?>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        <div class="not-view">
                            <textarea id="encodedData" style="width:100%; /* height: 100px; */">aq|rFttwdQiizCfl}AqcbFfxv@_jfBff}@silAdfdDl`UzrlCmpp@z~eBgq@rrz`@~_dK?rfBstgK~daE~eBbwDulch@</textarea>

                            <textarea id="mapData" style="width:100%; height:300px">
            {
            "zoom":7,"tilt":0,"mapTypeId":"hybrid","center":{"lat":20.487486793750797,"lng":74.22363281640626},
            "overlays":
            [
            {"type":"polygon","title":"","content":"","fillColor":"#000000","fillOpacity":0.3,"strokeColor":"#000000","strokeOpacity":0.9,"strokeWeight":3,"paths":[[{"lat":"21.329035778926478","lng":"73.46008301171878"},{"lat":"21.40065516914794","lng":"78.30505371484378"},{"lat":"20.106233605369603","lng":"77.37121582421878"},{"lat":"20.14749530904506","lng":"72.65808105859378"}]]}
,{"type":"marker","title":"hol","content":"holatc","label":"hol","position":{"lat":20.487486793750797,"lng": 74.22363281640627}}
            ]
            }
        </textarea>
                            <input type="button"
                                   value="Generate KML"

                                   @click="_generateKML()"
                            />
                            <input
                                    type="button"
                                    value="parse KML to map"
                                    @click="_setMapFromKML()"


                            />
                            <textarea id="kmlString" style="width:100%; height:500px" class="not-view"></textarea>

                        </div>
                    </div>
                </b-container>

            </b-form>
        </div>


    </div>

</script>
