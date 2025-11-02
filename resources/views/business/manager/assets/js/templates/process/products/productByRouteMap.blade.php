<script type='text/x-template' id='product-by-route-map-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-product-by-route-map"
                ref="refProductByRouteMapModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>

                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <div v-if="!initLoadAll" class="loading">Cargando...</div>
                <div v-if="initLoadAll" class="data-management">


                    <b-container class="container-manager-buttons">

                        <div class="content-row-manager-buttons">
                            <button
                                v-if="managerType!=1"
                                type="button"
                                class="btn btn-danger"
                                v-on:click="_delete()">
                                <?php  echo "{{labelsConfig.buttons.delete}}" ?></button>
                            <button v-if="showManager" type="button"
                                    :disabled="!validateForm()"
                                    class="btn btn-success "
                                    v-on:click="_saveModel()">
                                <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?>    </button>


                        </div>
                    </b-container>

                    <div class="content-form" v-if="showManager">
                        <div class="d-block ">
                            <b-form id="productByRouteMapForm" v-on:submit.prevent="_submitForm">


                                <b-container>
                                    <input v-model="model.attributes.id" type="hidden"
                                           v-bind:id="getNameAttribute('id')"
                                           v-bind:name="getNameAttribute('id')"
                                    >
                                    <b-row>

                                        <b-col md="12">
                                            <div class="form-group"

                                                 :class="getClassErrorForm('routes_map_id_data',$v.model.attributes.routes_map_id_data)">
                                                <label
                                                    class="form__label " v-html='getLabelForm("routes_map_id_data")'></label>
                                                <div class="content-element-form">
                                                    <input v-model="$v.model.attributes.routes_map_id_data.model"
                                                           type="hidden"
                                                           v-bind:id="getNameAttribute('routes_map_id_data')"
                                                           v-bind:name="getNameAttribute('routes_map_id_data')"
                                                           @change="_setValueForm('routes_map_id_data', $v.model.attributes.routes_map_id_data.$model)"
                                                    >
                                                    <select multiple="multiple" id="routes_map_id_data"
                                                            class="form-control m-select2 "
                                                            v-initS2RoutesMap="{rowId:model.attributes.id,_managerS2RoutesMap:_managerS2RoutesMap}"
                                                    >
                                                    </select>
                                                </div>
                                                <div class="content-message-errors">
                                                    <b-form-invalid-feedback
                                                        :state="!$v.model.attributes.routes_map_id_data.$error">
      <span v-if="!$v.model.attributes.routes_map_id_data.required">
       <?php  echo "{{model.structure.routes_map_id_data.required.msj}}"?>
      </span>
                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </b-col>
                                    </b-row>
                                    <b-row v-if="mapManagement.view">
                                        <b-col md="6" class="container-priority" >
                                            <div v-if="!mapManagement.managementMultimedia.view"  v-html="mapManagement.managementMultimedia.empty">

                                            </div>
                                            <div id="container-slick" v-if="mapManagement.managementMultimedia.view">
                                                <section v-init-slick-map-preview="{data:[],method:initSlickMapPreview}" class="lazy slider" data-sizes="50vw"  v-html="mapManagement.managementMultimedia.htmlCurrent">

                                                </section>
                                            </div>
                                        </b-col>
                                        <b-col md="6" class="container-priority">


                                            <div class="map-preview" id="map-preview"
                                                 v-init-map-preview="{data:mapManagement,method:initMapCurrent}">

                                            </div>
                                        </b-col>
                                    </b-row>

                                </b-container>


                            </b-form>
                        </div>

                    </div>


                </div>
            </b-modal>

        </div>
    </div>
</script>

