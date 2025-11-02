<script type="text/x-template" id="lodging-by-arrived-template">
    <div>
        <b-modal
                hide-footer
                id="modal-lodging-by-arrived"
                ref="refLodgingByArrivedModal"
                size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>

            <?php echo '@ok="_saveModal"' ?>
        >
            <template slot="modal-title">


                <label v-html="labelsConfig.title"></label>
            </template>
            <div class="d-block ">
                <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">

                    <b-row v-if="hasSocialNetworks">
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('way_to_contact',$v.model.attributes.way_to_contact)">

                                <b-form-group v-bind:label="getLabelForm('way_to_contact')">
                                    <b-form-radio-group
                                            v-model="$v.model.attributes.way_to_contact.$model"
                                            v-bind:id="getNameAttribute('way_to_contact')"
                                            v-bind:name="getNameAttribute('way_to_contact')"
                                            :options="wayToContactOptions"
                                            :disabled="arrived_made"
                                            v-on:change="_setValueForm('way_to_contact',$v.model.attributes.way_to_contact.$model)"
                                    ></b-form-radio-group>
                                </b-form-group>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.way_to_contact.$error">
                                            <span v-if="!$v.model.attributes.way_to_contact.required">
                                <?php  echo "{{model.structure.way_to_contact.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row v-if="hasSocialNetworks && getViewTypeSocialNetworks(hasSocialNetworks , $v.model.attributes.way_to_contact)">
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('type_social_networks',$v.model.attributes.type_social_networks)">

                                <b-form-group v-bind:label="getLabelForm('type_social_networks')">
                                    <b-form-radio-group
                                            v-model="$v.model.attributes.type_social_networks.$model"
                                            v-bind:id="getNameAttribute('type_social_networks')"
                                            v-bind:name="getNameAttribute('type_social_networks')"
                                            :options="typeSocialNetworksOptions"
                                            :disabled="arrived_made"

                                            v-on:change="_setValueForm('type_social_networks',$v.model.attributes.type_social_networks.$model)"
                                    ></b-form-radio-group>
                                </b-form-group>

                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_social_networks.$error">
                                            <span v-if="!$v.model.attributes.type_social_networks.required">
                                <?php  echo "{{model.structure.type_social_networks.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                    </b-row>
                    <b-row>
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('type_reasons',$v.model.attributes.type_reasons)">

                                <b-form-group v-bind:label="getLabelForm('type_reasons')">
                                    <b-form-radio-group
                                            v-model="$v.model.attributes.type_reasons.$model"
                                            v-bind:id="getNameAttribute('type_reasons')"
                                            v-bind:name="getNameAttribute('type_reasons')"
                                            :options="typeReasonsArrivedData"
                                            :disabled="arrived_made"

                                            v-on:change="_setValueForm('type_reasons',$v.model.attributes.type_reasons.$model)"
                                    ></b-form-radio-group>
                                </b-form-group>

                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_reasons.$error">
                                            <span v-if="!$v.model.attributes.type_reasons.required">
                                <?php  echo "{{model.structure.type_reasons.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                    </b-row>
                </b-form>


                <button type="button"
                        class="btn btn-danger "
                        v-on:click="_cancel()"
                >
                    <?php echo "{{labelsConfig.buttons.cancel}}"?>
                </button>


                <button v-if="!arrived_made" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo "{{labelsConfig.buttons.save}}"?>
                </button>
            </div>

        </b-modal>


    </div>

</script>