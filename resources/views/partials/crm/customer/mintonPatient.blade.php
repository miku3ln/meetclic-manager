<input v-model="model.attributes.id" type="hidden"
       v-bind:id="getNameAttribute('id')"
       v-bind:name="getNameAttribute('id')"
>
<div class="wrap-title-section">
    @if($type==1)

        <h4> <?php echo '{{processName.one}}' ?></h4>
    @else
        <h4> {{__('frontend.account.menu.profile.title.one')}}</h4>
    @endif
</div>
<div class="row not-image">
    <div class="col-md-4">
        <div class="manager-content-upload upload-demo">
            <div class="upload-msg">
                {{__('frontend.account.menu.profile.field.nine')}}*
            </div>
            <div class="upload-demo-wrap">
                <div id="upload-demo"></div>
            </div>
            <input
                v-init-crop="{initMethod:initCropProfileImage}"
                type="file"
                id="file-upload-profile-image"
                accept="image/x-png,image/gif,image/jpeg"
                name="Information[file_upload_img]"
            >
        </div>
    </div>

</div>

<b-row>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('people_type_identification_id_data',$v.model.attributes.people_type_identification_id_data)">
            <label
                class="form__label " v-html='getLabelForm("people_type_identification_id_data")'></label>
            <div class="content-element-form">

                <select

                    v-bind:id="getNameAttribute('people_type_identification_id_data')"
                    v-bind:name="getNameAttribute('people_type_identification_id_data')"
                    class="form-control m-input"
                    @change="_setValueForm('people_type_identification_id_data',$v.model.attributes.people_type_identification_id_data.$model)"
                    v-model.trim="$v.model.attributes.people_type_identification_id_data.$model"
                >
                    <option v-for="(row,index) in peopleTypeIdentificationData"
                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                    </option>
                </select>
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.people_type_identification_id_data.$error">
      <span v-if="!$v.model.attributes.people_type_identification_id_data.required">
       <?php echo "{{model.structure.people_type_identification_id_data.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>

    <b-col md="4"
           v-if="$v.model.attributes.people_type_identification_id_data.$model==typeIdentificationRuc">
        <div class="form-group"
             :class="getClassErrorForm('ruc_type_id_data',$v.model.attributes.ruc_type_id_data)">
            <label
                class="form__label " v-html='getLabelForm("ruc_type_id_data")'></label>
            <div class="content-element-form">
                <select

                    v-bind:id="getNameAttribute('ruc_type_id_data')"
                    v-bind:name="getNameAttribute('ruc_type_id_data')"
                    class="form-control m-input"
                    @change="_setValueForm('ruc_type_id_data',$v.model.attributes.ruc_type_id_data.$model)"
                    v-model.trim="$v.model.attributes.ruc_type_id_data.$model"
                >
                    <option v-for="(row,index) in rucTypeData"
                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                    </option>
                </select>

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.ruc_type_id_data.$error">
      <span v-if="!$v.model.attributes.ruc_type_id_data.required">
       <?php echo "{{model.structure.ruc_type_id_data.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('identification_document',$v.model.attributes.identification_document)">
            <label
                class="form__label " v-html='getLabelForm("identification_document")'></label>
            <div class="content-element-form">

                <input
                    placeholder="1002954881"
                    v-model.trim="$v.model.attributes.identification_document.$model"
                    type="text"
                    v-bind:id="getNameAttribute('identification_document')"
                    v-bind:name="getNameAttribute('identification_document')"
                    @change="_setValueForm('identification_document',$v.model.attributes.identification_document.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.identification_document.$error">
      <span v-if="!$v.model.attributes.identification_document.required">
       <?php echo "{{model.structure.identification_document.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
</b-row>
<b-row>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('people_nationality_id_data',$v.model.attributes.people_nationality_id_data)">
            <label
                class="form__label " v-html='getLabelForm("people_nationality_id_data")'></label>
            <div class="content-element-form">
                <select

                    v-bind:id="getNameAttribute('people_nationality_id_data')"
                    v-bind:name="getNameAttribute('people_nationality_id_data')"
                    class="form-control m-input"
                    @change="_setValueForm('people_nationality_id_data',$v.model.attributes.people_nationality_id_data.$model)"
                    v-model.trim="$v.model.attributes.people_nationality_id_data.$model"
                >
                    <option v-for="(row,index) in peopleNationalityData"
                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                    </option>
                </select>

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.people_nationality_id_data.$error">
      <span v-if="!$v.model.attributes.people_nationality_id_data.required">
       <?php echo "{{model.structure.people_nationality_id_data.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('people_profession_id_data',$v.model.attributes.people_profession_id_data)">
            <label
                class="form__label " v-html='getLabelForm("people_profession_id_data")'></label>
            <div class="content-element-form">
                <select

                    v-bind:id="getNameAttribute('people_profession_id_data')"
                    v-bind:name="getNameAttribute('people_profession_id_data')"
                    class="form-control m-input"
                    @change="_setValueForm('people_profession_id_data',$v.model.attributes.people_profession_id_data.$model)"
                    v-model.trim="$v.model.attributes.people_profession_id_data.$model"
                >
                    <option v-for="(row,index) in peopleProfessionData"
                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                    </option>
                </select>

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.people_profession_id_data.$error">
      <span v-if="!$v.model.attributes.people_profession_id_data.required">
       <?php echo "{{model.structure.people_profession_id_data.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('gender_data',$v.model.attributes.gender_data)">
            <label
                class="form__label " v-html='getLabelForm("gender_data")'></label>
            <div class="content-element-form">
                <select

                    v-bind:id="getNameAttribute('gender_data')"
                    v-bind:name="getNameAttribute('gender_data')"
                    class="form-control m-input"
                    @change="_setValueForm('gender_data',$v.model.attributes.gender_data.$model)"
                    v-model.trim="$v.model.attributes.gender_data.$model"
                >
                    <option v-for="(row,index) in genderData"
                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                    </option>
                </select>

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.gender_data.$error">
      <span v-if="!$v.model.attributes.gender_data.required">
       <?php echo "{{model.structure.gender_data.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
</b-row>

<b-row>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('name',$v.model.attributes.name)">
            <label
                class="form__label " v-html='getLabelForm("name")'></label>
            <div class="content-element-form">

                <input
                    placeholder="Your Name"
                    v-model.trim="$v.model.attributes.name.$model"
                    type="text"
                    v-bind:id="getNameAttribute('name')"
                    v-bind:name="getNameAttribute('name')"
                    @change="_setValueForm('name',$v.model.attributes.name.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.name.$error">
      <span v-if="!$v.model.attributes.name.required">
       <?php echo "{{model.structure.name.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('last_name',$v.model.attributes.last_name)">
            <label
                class="form__label " v-html='getLabelForm("last_name")'></label>
            <div class="content-element-form">

                <input
                    placeholder="Your Lastname"
                    v-model.trim="$v.model.attributes.last_name.$model"
                    type="text"
                    v-bind:id="getNameAttribute('last_name')"
                    v-bind:name="getNameAttribute('last_name')"
                    @change="_setValueForm('last_name',$v.model.attributes.last_name.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.last_name.$error">
      <span v-if="!$v.model.attributes.last_name.required">
       <?php echo "{{model.structure.last_name.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('birthdate',$v.model.attributes.birthdate)">
            <label
                class="form__label " v-html='getLabelForm("birthdate")'></label>
            <div class="content-element-form">
                <span v-if="$v.model.attributes.birthdate.$model"
                      class="birthday-date badge badge--size-large badge-info"> <?php echo '{{model.structure.birthdate.labelText}}' ?></span>
                <input
                    placeholder="24-07-1987"
                    v-model.trim="$v.model.attributes.birthdate.$model"
                    type="date"
                    v-bind:id="getNameAttribute('birthdate')"
                    v-bind:name="getNameAttribute('birthdate')"
                    @change="_setValueForm('birthdate',$v.model.attributes.birthdate.$model)"
                    v-focus-select
                    class="form-control m-input"
                >

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.birthdate.$error">
      <span v-if="!$v.model.attributes.birthdate.required">
       <?php echo "{{model.structure.birthdate.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
</b-row>

<b-row
    v-if="$v.model.attributes.people_type_identification_id_data.$model==typeIdentificationRuc">
    <b-col md="6">
        <div class="form-group"
             :class="getClassErrorForm('business_reason',$v.model.attributes.business_reason)">
            <label
                class="form__label " v-html='getLabelForm("business_reason")'></label>
            <div class="content-element-form">

                <input

                    v-model.trim="$v.model.attributes.business_reason.$model"
                    type="text"
                    v-bind:id="getNameAttribute('business_reason')"
                    v-bind:name="getNameAttribute('business_reason')"
                    @change="_setValueForm('business_reason',$v.model.attributes.business_reason.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.business_reason.$error">
      <span v-if="!$v.model.attributes.business_reason.required">
       <?php echo "{{model.structure.business_reason.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
    <b-col md="6">
        <div class="form-group"
             :class="getClassErrorForm('business_name',$v.model.attributes.business_name)">
            <label
                class="form__label " v-html='getLabelForm("business_name")'></label>
            <div class="content-element-form">

                <input

                    v-model.trim="$v.model.attributes.business_name.$model"
                    type="text"
                    v-bind:id="getNameAttribute('business_name')"
                    v-bind:name="getNameAttribute('business_name')"
                    @change="_setValueForm('business_name',$v.model.attributes.business_name.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.business_name.$error">
      <span v-if="!$v.model.attributes.business_name.required">
       <?php echo "{{model.structure.business_name.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
</b-row>
<b-row>
    <b-form-checkbox
        id="checkbox-1"
        v-model="$v.model.attributes.has_representative.$model"
        name="checkbox-1"
        @change="_setValueForm('has_representative',$v.model.attributes.has_representative.$model)"

    >

        <label
            class="form__label " v-html='getLabelForm("has_representative")'></label>

    </b-form-checkbox>
</b-row>


<div class="wrap-title-section">

    @if($type==1)

        <h4> <?php echo '{{processName.two}}' ?></h4>
    @else
        <h4>{{__('frontend.account.menu.profile.title.five')}}</h4>
    @endif

</div>

<b-row>
    <b-col md="4">
        <div class="form-group"
             :class="getClassErrorForm('information_phone_value',$v.model.attributes.information_phone_value)">
            <label
                class="form__label " v-html='getLabelForm("information_phone_value")'></label>
            <div class="content-element-form">

                <input

                    v-model.trim="$v.model.attributes.information_phone_value.$model"
                    type="text"
                    v-bind:id="getNameAttribute('information_phone_value')"
                    v-bind:name="getNameAttribute('information_phone_value')"
                    @change="_setValueForm('information_phone_value',$v.model.attributes.information_phone_value.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.information_phone_value.$error">
      <span v-if="!$v.model.attributes.information_phone_value.required">
       <?php echo "{{model.structure.information_phone_value.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
    <b-col md="8" v-if="model.attributes.has_representative">
        <div class="form-group"
             :class="getClassErrorForm('representative_fullname',$v.model.attributes.representative_fullname)">
            <label
                class="form__label " v-html='getLabelForm("representative_fullname")'></label>
            <div class="content-element-form">

                <input
                    placeholder="Nombre Completo Representante"
                    v-model.trim="$v.model.attributes.representative_fullname.$model"
                    type="text"
                    v-bind:id="getNameAttribute('representative_fullname')"
                    v-bind:name="getNameAttribute('representative_fullname')"
                    @change="_setValueForm('representative_fullname',$v.model.attributes.representative_fullname.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.representative_fullname.$error">
      <span v-if="!$v.model.attributes.representative_fullname.required">
       <?php echo "{{model.structure.representative_fullname.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
</b-row>
<div class="wrap-title-section">


    @if($type==1)

        <h4> <?php echo '{{processName.three}}' ?></h4>
    @else
        <h4> {{__('frontend.account.menu.profile.title.four')}}</h4>
    @endif
</div>
<b-row>
    <b-col md="3">
        <div class="form-group"
             :class="getClassErrorForm('countries_id',$v.model.attributes.countries_id)">
            <label
                class="form__label " v-html='getLabelForm("countries_id")'></label>
            <div class="content-element-form">
                <select

                    v-bind:id="getNameAttribute('countries_id')"
                    v-bind:name="getNameAttribute('countries_id')"
                    class="form-control m-input"
                    @change="_setValueSelect('countries_id',$v.model.attributes.countries_id.$model)"
                    v-model.trim="$v.model.attributes.countries_id.$model"
                >
                    <option v-for="(row,index) in countriesData"
                            v-bind:value="row.id"><?php echo '{{row.value}}' ?></option>
                </select>

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.countries_id.$error">
      <span v-if="!$v.model.attributes.countries_id.required">
       <?php echo "{{model.structure.countries_id.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
    <b-col md="3" v-if="$v.model.attributes.countries_id.$model">
        <div class="form-group"
             :class="getClassErrorForm('provinces_id',$v.model.attributes.provinces_id)">
            <label
                class="form__label " v-html='getLabelForm("provinces_id")'></label>
            <div class="content-element-form">

                <select

                    v-bind:id="getNameAttribute('provinces_id')"
                    v-bind:name="getNameAttribute('provinces_id')"
                    class="form-control m-input"
                    @change="_setValueSelect('provinces_id',$v.model.attributes.provinces_id.$model)"
                    v-model.trim="$v.model.attributes.provinces_id.$model"

                >
                    <option v-for="(row,index) in provincesData"
                            v-bind:value="row.id"><?php echo '{{row.value}}' ?></option>
                </select>
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.provinces_id.$error">
      <span v-if="!$v.model.attributes.provinces_id.required">
       <?php echo "{{model.structure.provinces_id.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
    <b-col md="3" v-if="$v.model.attributes.provinces_id.$model">
        <div class="form-group"
             :class="getClassErrorForm('cities_id',$v.model.attributes.cities_id)">
            <label
                class="form__label " v-html='getLabelForm("cities_id")'></label>
            <div class="content-element-form">
                <select

                    v-bind:id="getNameAttribute('cities_id')"
                    v-bind:name="getNameAttribute('cities_id')"
                    class="form-control m-input"
                    @change="_setValueSelect('cities_id',$v.model.attributes.cities_id.$model)"
                    v-model.trim="$v.model.attributes.cities_id.$model"
                >
                    <option v-for="(row,index) in citiesData"
                            v-bind:value="row.id"><?php echo '{{row.value}}' ?></option>
                </select>

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.cities_id.$error">
      <span v-if="!$v.model.attributes.cities_id.required">
       <?php echo "{{model.structure.cities_id.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
    <b-col md="3" v-if="$v.model.attributes.cities_id.$model">
        <div class="form-group"
             :class="getClassErrorForm('zones_id',$v.model.attributes.zones_id)">
            <label
                class="form__label " v-html='getLabelForm("zones_id")'></label>
            <div class="content-element-form">
                <select
                    v-bind:id="getNameAttribute('zones_id')"
                    v-bind:name="getNameAttribute('zones_id')"
                    class="form-control m-input"
                    @change="_setValueSelect('zones_id',$v.model.attributes.zones_id.$model)"
                    v-model.trim="$v.model.attributes.zones_id.$model"
                >
                    <option v-for="(row,index) in zonesData"
                            v-bind:value="row.id"><?php echo '{{row.name}}' ?></option>
                </select>

            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.zones_id.$error">
      <span v-if="!$v.model.attributes.zones_id.required">
       <?php echo "{{model.structure.zones_id.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
</b-row>
<b-row>
    <b-col md="6">
        <div class="form-group"
             :class="getClassErrorForm('street_one',$v.model.attributes.street_one)">
            <label
                class="form__label " v-html='getLabelForm("street_one")'></label>
            <div class="content-element-form">

                <input

                    v-model.trim="$v.model.attributes.street_one.$model"
                    type="text"
                    v-bind:id="getNameAttribute('street_one')"
                    v-bind:name="getNameAttribute('street_one')"
                    @change="_setValueForm('street_one',$v.model.attributes.street_one.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.street_one.$error">
      <span v-if="!$v.model.attributes.street_one.required">
       <?php echo "{{model.structure.street_one.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>

    </b-col>
    <b-col md="6">
        <div class="form-group"
             :class="getClassErrorForm('street_two',$v.model.attributes.street_two)">
            <label
                class="form__label " v-html='getLabelForm("street_two")'></label>
            <div class="content-element-form">

                <input

                    v-model.trim="$v.model.attributes.street_two.$model"
                    type="text"
                    v-bind:id="getNameAttribute('street_two')"
                    v-bind:name="getNameAttribute('street_two')"
                    @change="_setValueForm('street_two',$v.model.attributes.street_two.$model)"
                    v-focus-select
                    class="form-control m-input"
                >
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.street_two.$error">
      <span v-if="!$v.model.attributes.street_two.required">
       <?php echo "{{model.structure.street_two.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
</b-row>
<b-row>
    <div class="col-md-12">
        <div class="floating-panel-manager">
            <input id="search-map-current"
                   class="floating-panel-manager__search"
                   type="textbox"
                   value="Ecuador"
                   v-focus-select
            >

        </div>
        <div class="map-guests"
             v-init-map-plugin="{model:$v.model.attributes,methodInit:_initMap,elementSelector: '.map-guests'}"
             id="manager-map">
        </div>
    </div>
    <b-col md="12">
        <div class="form-group"
             :class="getClassErrorForm('reference',$v.model.attributes.reference)">
            <label
                class="form__label " v-html='getLabelForm("reference")'></label>
            <div class="content-element-form">


                <textarea
                    class="form-control custom-form--auto-height-text-area"
                    cols="40" rows="3" placeholder=""
                    v-model.trim="$v.model.attributes.reference.$model"
                    v-bind:id="getNameAttribute('reference')"
                    v-bind:name="getNameAttribute('reference')"
                    @change="_setValueForm('reference', $v.model.attributes.reference.$model)"
                    v-focus-select

                ></textarea>
            </div>
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.reference.$error">
      <span v-if="!$v.model.attributes.reference.required">
       <?php echo "{{model.structure.reference.required.msj}}" ?>
      </span>
                </b-form-invalid-feedback>
            </div>
        </div>
    </b-col>
</b-row>
