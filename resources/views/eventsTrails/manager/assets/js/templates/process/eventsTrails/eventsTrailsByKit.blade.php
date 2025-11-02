<script type='text/x-template' id='events-trails-by-kit-template'>
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
                        <?php echo '{{labelsConfig.buttons.create}}'?></button>

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

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="events-trails-by-kit-grid"
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
                <b-form id="eventsTrailsByKitForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
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

                            <b-col md="4" v-if="false">
                                <div class="form-group"
                                     :class="getClassErrorForm('entity_type',$v.model.attributes.entity_type)">
                                    <label class="form__label " v-html='getLabelForm("entity_type")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.entity_type.$model"
                                                v-bind:id="getNameAttribute('entity_type')"
                                                v-bind:name="getNameAttribute('entity_type')"
                                                class="form-control m-input"
                                                @change="_setValueForm('entity_type', $v.model.attributes.entity_type.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.entity_type.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                                :state="!$v.model.attributes.entity_type.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="8">
                                <div class="form-group"
                                     :class="getClassErrorForm('entity_id_data',$v.model.attributes.entity_id_data)">
                                    <label class="form__label " v-html='getLabelForm("entity_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.entity_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('entity_id_data')"
                                               v-bind:name="getNameAttribute('entity_id_data')"
                                               @change="_setValueForm('entity_id_data', $v.model.attributes.entity_id_data.$model)"
                                        >
                                        <select id="entity_id_data"
                                                class="form-control m-select2 "
                                                v-initS2PiecesClothes="{rowId:model.attributes.id,_initS2PiecesClothes:_initS2PiecesClothes}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.entity_id_data.$error">
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

