<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingByPayment";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "modelDataManager" => $modelDataManager,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingByTypeOfRoom";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "modelDataManager" => $modelDataManager,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)

<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingByArrived";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "modelDataManager" => $modelDataManager,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)

<?php
$wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingDelivery";
$paramsWizard = [
    "model_entity" => $model_entity,
    "pathCurrent" => $pathCurrent,
    "user" => $user,
    "modelDataManager" => $modelDataManager,
    "configPartial" => $configPartial
];
?>
@include($wizards_route,$paramsWizard)
<script type="text/x-template" id="lodging-template">
    <div>
        <div v-if="configModalLodgingRoomsState.viewAllow">

            <lodging-rooms-state-component
                    ref="refLodgingRoomsState"
                    :params="configModalLodgingRoomsState"

            ></lodging-rooms-state-component>
        </div>
        <div v-if="configModalLodgingByPayment.viewAllow">

            <lodging-by-payment-component

                    ref="refLodgingByPayment"
                    :params="configModalLodgingByPayment"


            ></lodging-by-payment-component>
        </div>
        <div v-if="configModalLodgingByArrived.viewAllow">

            <lodging-by-arrived-component

                    ref="refLodgingByArrived"
                    :params="configModalLodgingByArrived"


            ></lodging-by-arrived-component>
        </div>
        <div v-if="configModalLodgingByTypeOfRoom.viewAllow">

            <lodging-by-type-of-room-component

                    ref="refLodgingByTypeOfRoom"
                    :params="configModalLodgingByTypeOfRoom"

            ></lodging-by-type-of-room-component>
        </div>

        <div v-if="configModalLodgingDelivery.viewAllow">

            <lodging-delivery-component

                    ref="refLodgingDelivery"
                    :params="configModalLodgingDelivery"

            ></lodging-delivery-component>
        </div>
        <b-container class="bv-example-row">
            <div class="content-row-manager-buttons">
                <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn btn-warning "

                        v-on:click="_viewRoomsState()">
                    <?php echo "{{labelsConfig.button.viewRoomsState}}"?>
                </button>
                <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                    <?php echo "{{showManager?'Regresar':'Nuevo'}}"?>
                </button>


                <button v-if="showManager && $v.model.attributes['status_delivery'].$model==0" type="button"
                        :disabled="!validateForm()"
                        class="btn btn-success " v-on:click="_saveModel()">
                    <?php echo "{{lblBtnSave}}"?>
                </button>
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
        <?php ?>
        <div class="content-manager-grid">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <table id="lodging-grid"
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
                        <b-col md="12">
                            <label class="title-information"><?php echo '{{labelsConfig.process.information}}' ?></label>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col lg="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('entry_at_data',$v.model.attributes.entry_at_data)">
                                <label class="form__label col-md-12" v-html='getLabelForm("entry_at_data")' ></label>
                                <div class="content ">

                                    <date-time-picker
                                            v-model.trim="$v.model.attributes.entry_at_data.$model"
                                            v-bind:id="getNameAttribute('entry_at_data')"
                                            v-bind:name="getNameAttribute('entry_at_data')"
                                            @change="_setValueForm('entry_at_data', $v.model.attributes.entry_at_data.$model)"
                                            format="dd-LL-yyyy hh:mm a"
                                            :hour-time="12"
                                            locale="es"
                                            :disabled="createUpdate"
                                    ></date-time-picker>
                                </div>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.entry_at_data.$error">
                                            <span v-if="!$v.model.attributes.entry_at_data.required">
                                <?php  echo "{{model.structure.entry_at_data.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col lg="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('output_at_data',$v.model.attributes.output_at_data)">
                                <label class="form__label " v-html='getLabelForm("output_at_data")' ></label>
                                <div class="content ">

                                    <date-time-picker
                                            v-model.trim="$v.model.attributes.output_at_data.$model"
                                            v-bind:id="getNameAttribute('output_at_data')"
                                            v-bind:name="getNameAttribute('output_at_data')"
                                            @change="_setValueForm('output_at_data', $v.model.attributes.output_at_data.$model)"

                                            format="dd-LL-yyyy hh:mm a"
                                            :hour-time="12"
                                            locale="es"
                                            :disabled="$v.model.attributes.output_at_data.$model?true:false"

                                    ></date-time-picker>
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.output_at_data.$error">
                                            <span v-if="!$v.model.attributes.output_at_data.required">
                                <?php  echo "{{model.structure.output_at_data.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                        <b-col md="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('number_rooms',$v.model.attributes.number_rooms)">
                                <label class="form__label " v-html='getLabelForm("number_rooms")' ></label>
                                <div class="content">
                                    <input
                                            v-model.trim="$v.model.attributes.number_rooms.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('number_rooms')"
                                            v-bind:name="getNameAttribute('number_rooms')"
                                            class="form-control m-input"
                                            @change="_setValueForm('number_rooms', $event.target.value)"
                                            v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.number_rooms.$error">
                                            <span v-if="!$v.model.attributes.number_rooms.required">
                                <?php  echo "{{model.structure.number_rooms.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <b-row>

                        <b-col lg="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('number_people',$v.model.attributes.number_people)">
                                <label class="form__label" v-html='getLabelForm("number_people")' ></label>
                                <div class="content">
                                    <input
                                            v-model.trim="$v.model.attributes.number_people.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('number_people')"
                                            v-bind:name="getNameAttribute('number_people')"
                                            class="form-control m-input"
                                            @change="_setValueForm('number_people', $event.target.value)"
                                            v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.number_people.$error">
                                            <span v-if="!$v.model.attributes.number_people.required">
                                <?php  echo "{{model.structure.number_people.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>

                        <b-col lg="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('adults',$v.model.attributes.adults)">
                                <label class="form__label " v-html='getLabelForm("adults")' ></label>
                                <div class="content ">
                                    <input
                                            v-model.trim="$v.model.attributes.adults.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('adults')"
                                            v-bind:name="getNameAttribute('adults')"
                                            class="form-control m-input"
                                            @change="_setValueForm('adults', $v.model.attributes.adults.$model)"
                                            v-focus-select
                                    >
                                </div>
                            </div>
                        </b-col>
                        <b-col lg="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('children',$v.model.attributes.children)">
                                <label class="form__label " v-html='getLabelForm("children")' ></label>
                                <div class="content">
                                    <input
                                            v-model.trim="$v.model.attributes.children.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('children')"
                                            v-bind:name="getNameAttribute('children')"
                                            class="form-control m-input"
                                            @change="_setValueForm('children', $v.model.attributes.children.$model)"
                                            v-focus-select
                                    >
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <label class="title-information"><?php echo '{{labelsConfig.process.payment}}' ?></label>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col lg="2">

                            <div class="form-group"
                                 :class="getClassErrorForm('payment_made',$v.model.attributes.payment_made)">
                                <label class="form__label"
                                       v-bind:for="getNameAttribute('payment_made')" v-html='getLabelForm("payment_made")' ></label>
                                <div class="toggle">
                                    <input
                                            v-model="hasPayment"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('payment_made')"
                                            v-bind:name="getNameAttribute('payment_made')"
                                            @change="_setValueForm('payment_made',hasPayment)"
                                            v-focus-select
                                            :disabled="allowDisabledPaymentMade()"
                                    >
                                    <label v-bind:for="getNameAttribute('payment_made')">
                                        <div class="toggle__switch"></div>
                                    </label>
                                </div>

                            </div>
                        </b-col>
                        <b-col lg="3">
                            <div class="form-group"
                                 :class="getClassErrorForm('total_value',$v.model.attributes.total_value)">
                                <label class="form__label " v-html='getLabelForm("total_value")' ></label>
                                <div class="content ">
                                    <input
                                            v-model.trim="$v.model.attributes.total_value.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('total_value')"
                                            v-bind:name="getNameAttribute('total_value')"
                                            class="form-control m-input"
                                            @change="_setValueForm('total_value', $event.target.value)"
                                            :disabled="allowDisabledPaymentMade()"
                                            v-focus-select
                                    >
                                </div>
                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.total_value.$error">
                                            <span v-if="!$v.model.attributes.total_value.required">
                                <?php  echo "{{model.structure.total_value.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <b-row v-if="hasPayment">
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('way_to_pay',$v.model.attributes.way_to_pay)">

                                <b-form-group v-bind:label="getLabelForm('way_to_pay')">
                                    <b-form-checkbox-group
                                            v-model="$v.model.attributes.way_to_pay.$model"
                                            v-bind:id="getNameAttribute('way_to_pay')"
                                            v-bind:name="getNameAttribute('way_to_pay')"
                                            :options="wayToPayOptions"
                                            :disabled="allowDisabledPaymentMade()"
                                            v-on:change="_setValueForm('way_to_pay',$v.model.attributes.way_to_pay.$model)"
                                    ></b-form-checkbox-group>
                                </b-form-group>
                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.way_to_pay.$error">
                                            <span v-if="!$v.model.attributes.way_to_pay.required">
                                <?php  echo "{{model.structure.way_to_pay.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row v-if="hasPayment && getViewTypeCreditCard(hasPayment , $v.model.attributes.way_to_pay)">
                        <b-col lg="12">
                            <div class="form-group"
                                 :class="getClassErrorForm('type_credit_card',$v.model.attributes.type_credit_card)">

                                <b-form-group v-bind:label="getLabelForm('type_credit_card')">
                                    <b-form-checkbox-group
                                            v-model="$v.model.attributes.type_credit_card.$model"
                                            v-bind:id="getNameAttribute('type_credit_card')"
                                            v-bind:name="getNameAttribute('type_credit_card')"
                                            :options="typeCreditCardOptions"
                                            :disabled="allowDisabledPaymentMade()"
                                            v-on:change="_setValueForm('type_credit_card',$v.model.attributes.type_credit_card.$model)"
                                    ></b-form-checkbox-group>
                                </b-form-group>

                                <div class="content-message-errors">
                                    <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_credit_card.$error">
                                            <span v-if="!$v.model.attributes.type_credit_card.required">
                                <?php  echo "{{model.structure.type_credit_card.required.msj}}"?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col md="12">
                            <label class=" title-information"><?php echo '{{labelsConfig.process.guests}}' ?></label>
                        </b-col>
                    </b-row>
                    <b-row>

                        <b-col md="3" v-if="!$v.model.attributes.mainAddAllow.$model">
                            <div class="form-group"
                                 :class="getClassErrorForm('mainAdd',$v.model.attributes.mainAdd)">
                                <label class="form__label " v-html='getLabelForm("mainAdd")' ></label>
                                <div class="content ">
                                    <input
                                            v-model.trim="$v.model.attributes.mainAdd.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('mainAdd')"
                                            v-bind:name="getNameAttribute('mainAdd')"
                                            class="form-control m-input"
                                            @change="_setValueForm('mainAdd', $event.target.value)"
                                            v-focus-select
                                    >
                                </div>

                            </div>
                        </b-col>
                        <b-col md="3">
                            <div class="form-group">
                                <label class="form__label "><?php echo '{{configAddPeopleS2.label}}' ?></label>
                                <div class="content">

                                    <select
                                            id="customer-add"
                                            class="form-control m-select2"
                                            v-initS2="{filters:{lodging_id:model.attributes.id},_customersList:_customersList}"
                                    >
                                    </select>


                                </div>

                            </div>

                        </b-col>
                        <b-col md="3">
                            <button class="button"
                                    @click="_addPeople()"><?php echo '{{labelsConfig.button.guest}}' ?></button>
                        </b-col>
                    </b-row>

                    <?php
                    $wizards_route = $configPartial["moduleMain"] . "." . $configPartial["moduleFolder"] . ".assets.js.templates.process.housing.lodgingByCustomer";
                    $paramsWizard = [
                        "model_entity" => $model_entity,
                        "pathCurrent" => $pathCurrent,
                        "user" => $user,
                        "modelDataManager" => $modelDataManager,
                        "configPartial" => $configPartial
                    ];
                    ?>
                    @include($wizards_route,$paramsWizard)

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
