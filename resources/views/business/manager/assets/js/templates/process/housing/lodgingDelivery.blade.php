<script type="text/x-template" id="lodging-delivery-template">
    <div>
        <b-modal
                hide-footer
                id="modal-lodging-delivery"
                ref="refLodgingDeliveryModal"
                size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>

            <?php echo '@ok="_saveModal"' ?>
        >
            <template slot="modal-title">


                <label v-html="labelsConfig.title"></label>
            </template>
            <div class="d-block ">
                <b-form id="LodgingDeliveryForm" v-on:submit.prevent="_submitForm">

                    <b-row v-if="addRooms">
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('lodging_type_of_room_by_price_id',$v.model.attributes.lodging_type_of_room_by_price_id)">

                                <b-form-group v-bind:label="getLabelForm('lodging_type_of_room_by_price_id')">

                                    <b-form-checkbox-group
                                            id="checkbox-group-2"
                                            :disabled="true"
                                            v-model="$v.model.attributes.lodging_type_of_room_by_price_id.$model"
                                            v-on:change="_setValueForm('lodging_type_of_room_by_price_id',$v.model.attributes.lodging_type_of_room_by_price_id,$v.model.attributes.lodging_type_of_room_by_price_id.$model)"
                                    >
                                        <b-form-checkbox v-bind:value="option.value"
                                                         v-for="option in lodgingTypeOfRoomByPriceIdOptions">

                                            <?php echo "{{option.text}}"?>
                                        </b-form-checkbox>

                                    </b-form-checkbox-group>
                                </b-form-group>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.lodging_type_of_room_by_price_id.$error">
                                            <span v-if="!$v.model.attributes.lodging_type_of_room_by_price_id.required">
                                <?php  echo "{{model.structure.lodging_type_of_room_by_price_id.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row v-if="!addRooms">
                        <b-col lg="12">
                            <span> No se han asignado Habitaciones</span>
                        </b-col>
                    </b-row>
                </b-form>


                <button type="button"
                        class="btn btn-danger "
                        v-on:click="_cancel()"
                >
                    <?php echo "{{labelsConfig.buttons.cancel}}"?>
                </button>


                <button v-if="createUpdate && addRooms" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo "{{labelsConfig.buttons.save}}"?>
                </button>
            </div>

        </b-modal>


    </div>

</script>