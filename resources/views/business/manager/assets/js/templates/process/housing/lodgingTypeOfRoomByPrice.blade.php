<script type="text/x-template" id="lodging-type-of-room-by-price-template">
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

                        <a
                                v-init-tool-tip
                                v-for="(menu, key) in managerMenuConfig.menuCurrent"
                                v-bind:id="'a-menu-'+menu.rowId"
                                v-on:click="_managerMenuGrid(key, menu)"
                                class="content-manager-buttons-grid__a " data-toggle="tooltip"
                                data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                            <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                        </a>
                    </div>
                </div>

            </div>
        </b-container>
        <?php ?>
        <div class="content-manager-grid">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <table id="lodging-type-of-room-by-price-grid"
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

            <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >
                <input v-model="model.attributes.business_id" type="hidden"

                       v-bind:id="getNameAttribute('business_id')"
                       v-bind:name="getNameAttribute('business_id')">
                <b-container>


                    <b-row>

                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('lodging_type_of_room_id_data',$v.model.attributes.lodging_type_of_room_id_data)">
                                <label class="form__label " v-html='getLabelForm("lodging_type_of_room_id_data")' ></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.lodging_type_of_room_id_data.$model"
                                           v-bind:id="getNameAttribute('lodging_type_of_room_id_data')"
                                           v-bind:name="getNameAttribute('lodging_type_of_room_id_data')"
                                           @change="_setValueForm('lodging_type_of_room_id_data', $event.target.value)"
                                    >
                                    <select
                                            id="lodging_type_of_room_id_data"
                                            class="form-control m-select2 lodging_type_of_room_id_data"
                                            v-initS2="{model:model.attributes.id,_managerS2TypesOfRoom:_managerS2TypesOfRoom}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.lodging_type_of_room_id_data.$error">
                                            <span v-if="!$v.model.attributes.lodging_type_of_room_id_data.required">
                                <?php  echo "{{model.structure.lodging_type_of_room_id_data.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('lodging_room_levels_id_data',$v.model.attributes.lodging_room_levels_id_data)">
                                <label class="form__label " v-html='getLabelForm("lodging_room_levels_id_data")' ></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.lodging_room_levels_id_data.$model"
                                           v-bind:id="getNameAttribute('lodging_room_levels_id_data')"
                                           v-bind:name="getNameAttribute('lodging_room_levels_id_data')"
                                           @change="_setValueForm('lodging_room_levels_id_data', $event.target.value)"
                                    >
                                    <select
                                            id="lodging_room_levels_id_data"
                                            class="form-control m-select2 lodging_room_levels_id_data"
                                            v-initS2Lvl="{model:model.attributes.id,_managerS2Lvl:_managerS2Lvl}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.lodging_room_levels_id_data.$error">
                                            <span v-if="!$v.model.attributes.lodging_room_levels_id_data.required">
                                <?php  echo "{{model.structure.lodging_room_levels_id_data.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('features_id_data',$v.model.attributes.features_id_data)">
                                <label class="form__label " v-html='getLabelForm("features_id_data")' ></label>
                                <div class="content">
                                    <input type="hidden"
                                           v-model.trim="$v.model.attributes.features_id_data.$model"
                                           v-bind:id="getNameAttribute('features_id_data')"
                                           v-bind:name="getNameAttribute('features_id_data')"
                                           @change="_setValueForm('features_id_data', $event.target.value)"
                                    >
                                    <select
                                            id="features_id_data"
                                            class="form-control m-select2 features_id_data"
                                            v-initS2Features="{model:model.attributes.id,_managerS2Features:_managerS2Features}"
                                    >
                                    </select>


                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.features_id_data.$error">
                                            <span v-if="!$v.model.attributes.features_id_data.required">
                                <?php  echo "{{model.structure.features_id_data.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('name',$v.model.attributes.name)">
                                <label class="form__label " v-html='getLabelForm("name")' ></label>
                                <div class="content">
                                    <input
                                            v-model.trim="$v.model.attributes.name.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('name')"
                                            v-bind:name="getNameAttribute('name')"
                                            class="form-control m-input"
                                            @change="_setValueForm('name', $event.target.value)"
                                            v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.name.$error">
                                            <span v-if="!$v.model.attributes.name.required">
                                <?php  echo "{{model.structure.name.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="6">
                            <div class="form-group"
                                 :class="getClassErrorForm('room_number',$v.model.attributes.room_number)">
                                <label class="form__label " v-html='getLabelForm("room_number")' ></label>
                                <div class="content">
                                    <input
                                            v-model.trim="$v.model.attributes.room_number.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('room_number')"
                                            v-bind:name="getNameAttribute('room_number')"
                                            class="form-control m-input"
                                            @change="_setValueForm('room_number', $event.target.value)"
                                            v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.room_number.$error">
                                            <span v-if="!$v.model.attributes.room_number.required">
                                <?php  echo "{{model.structure.room_number.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col md="6" v-if="false">
                            <div class="form-group"
                                 :class="getClassErrorForm('price',$v.model.attributes.price)">
                                <label class="form__label " v-html='getLabelForm("price")' ></label>
                                <div class="content">
                                    <input
                                            v-model.trim="$v.model.attributes.price.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('price')"
                                            v-bind:name="getNameAttribute('price')"
                                            class="form-control m-input"
                                            @change="_setValueForm('price', $event.target.value)"
                                            v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.price.$error">
                                            <span v-if="!$v.model.attributes.price.required">
                                <?php  echo "{{model.structure.price.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('description',$v.model.attributes.description)"
                            >

                                <label class="form__label " v-html='getLabelForm("description")' ></label>

                                <div class="content ">

                                        <textarea
                                                rows="10" cols="50"
                                                v-model.trim="$v.model.attributes.description.$model"
                                                name="Lodging[description]"
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
                    </b-row>

                </b-container>

            </b-form>

        </div>


    </div>

</script>
