<!-- CMS-TEMPLATE-MY-PROFILE-TEMPLATE  -->
<?php
$user = Auth::user();
$authorSingleLink=route('authorSingle', app()->getLocale()).'/'.$user->id;
?>

<div class="row">

    <div class="col-md-12">
        <div class="profile-edit-container">
            <div class="profile-edit-header fl-wrap">
                <h4 style="text-align: right;">  <a target="_blank" href="{{$authorSingleLink}}">{{__('frontend.account.menu.profile.title.one')}}</a></h4>
            </div>
            <div class="manager-buttons-cms">
                <button class="btn  big-btn  color-bg flat-btn"
                        type="button"
                        :disabled="!validateForm()"
                        class="btn btn--manager btn-success" v-on:click="_saveModel()"
                >
                    {{__('frontend.buttons.save-changes')}}
                    <i class="fa fa-angle-right"></i>
                </button>
            </div>
            <div class="row">
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
            <div class="custom-form custom-form--opacity-placeholder-50">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form__label "
                               v-html='getLabelForm("people_type_identification_id_data")'> </label>
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
                    <div class="col-md-4"
                         v-if="$v.model.attributes.people_type_identification_id_data.$model==typeIdentificationRuc">
                        <label class="form__label " v-html='getLabelForm("ruc_type_id_data")'></label>
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
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("identification_document")'>
                        </label>
                        <input
                            placeholder="1002954881"
                            v-model.trim="$v.model.attributes.identification_document.$model"
                            type="text"
                            v-bind:id="getNameAttribute('identification_document')"
                            v-bind:name="getNameAttribute('identification_document')"
                            @change="_setValueForm('identification_document',$v.model.attributes.identification_document.$model)"
                            v-focus-select
                        >
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.identification_document.$error">
                                            <span v-if="!$v.model.attributes.identification_document.required">
                                <?php echo "{{model.structure.identification_document.required.msj}}" ?>
                            </span>
                            </b-form-invalid-feedback>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("people_nationality_id_data")'></label>
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
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.people_nationality_id_data.$error">
                                            <span v-if="!$v.model.attributes.people_nationality_id_data.required">
                                <?php echo "{{model.structure.people_nationality_id_data.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("people_profession_id_data")'> </label>
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
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.people_profession_id_data.$error">
                                            <span v-if="!$v.model.attributes.people_profession_id_data.required">
                                <?php echo "{{model.structure.people_profession_id_data.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("gender_data")'>
                        </label>
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
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.gender_data.$error">
                                            <span v-if="!$v.model.attributes.gender_data.required">
                                <?php echo "{{model.structure.gender_data.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>

                </div>

                <div class="row" style="margin-top:30px">
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("name")'>

                        </label>
                        <input
                            v-model.trim="$v.model.attributes.name.$model"
                            type="text"
                            v-bind:id="getNameAttribute('name')"
                            v-bind:name="getNameAttribute('name')"
                            @change="_setValueForm('name', $v.model.attributes.name.$model)"
                            v-focus-select
                        />
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.name.$error">
                                            <span v-if="!$v.model.attributes.name.required">
                                <?php echo "{{model.structure.name.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("last_name")'>

                        </label>
                        <input
                            v-model.trim="$v.model.attributes.last_name.$model"
                            type="text"
                            v-bind:id="getNameAttribute('last_name')"
                            v-bind:name="getNameAttribute('last_name')"

                            @change="_setValueForm('last_name',$v.model.attributes.last_name.$model)"
                            v-focus-select

                        />
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.last_name.$error">
                                            <span v-if="!$v.model.attributes.last_name.required">
                                <?php echo "{{model.structure.last_name.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("birthdate")'>

                        </label>
                        <input

                            v-model.trim="$v.model.attributes.birthdate.$model"
                            type="date"
                            v-bind:id="getNameAttribute('birthdate')"
                            v-bind:name="getNameAttribute('birthdate')"
                            @change="_setValueForm('birthdate', $v.model.attributes.birthdate.$model)"
                            v-focus-select
                        />

                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.birthdate.$error">
                                            <span v-if="!$v.model.attributes.birthdate.required">
                                <?php echo "{{model.structure.birthdate.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                </div>
                <div class="row"
                     v-if="$v.model.attributes.people_type_identification_id_data.$model==typeIdentificationRuc">
                    <div class="col-md-6">
                        <label class="form__label " v-html='getLabelForm("business_reason")'>

                        </label>
                        <input
                            v-model.trim="$v.model.attributes.business_reason.$model"
                            type="text"
                            v-bind:id="getNameAttribute('business_reason')"
                            v-bind:name="getNameAttribute('business_reason')"
                            @change="_setValueForm('business_reason', $v.model.attributes.business_reason.$model)"
                            v-focus-select
                        />
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.business_reason.$error">
                                            <span v-if="!$v.model.attributes.business_reason.required">
                                <?php echo "{{model.structure.business_reason.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form__label " v-html='getLabelForm("business_name")'>

                        </label>
                        <input
                            v-model.trim="$v.model.attributes.business_name.$model"
                            type="text"
                            v-bind:id="getNameAttribute('business_name')"
                            v-bind:name="getNameAttribute('business_name')"

                            @change="_setValueForm('business_name',$v.model.attributes.business_name.$model)"
                            v-focus-select

                        />
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.business_name.$error">
                                            <span v-if="!$v.model.attributes.business_name.required">
                                <?php echo "{{model.structure.business_name.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>

                </div>
            </div>
            <div class="profile-edit-container add-list-container">
                <div class="profile-edit-header fl-wrap" style="margin-top:30px">
                    <h4> {{__('frontend.account.menu.profile.title.four')}}</h4>
                </div>
                <div class="custom-form custom-form--opacity-placeholder-50">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form__label " v-html='getLabelForm("countries_id")'>
                            </label>
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
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.countries_id.$error">
                                            <span v-if="!$v.model.attributes.countries_id.required">
                                <?php echo "{{model.structure.countries_id.required.msj}}" ?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-3" v-if="$v.model.attributes.countries_id.$model">
                            <label class="form__label " v-html='getLabelForm("provinces_id")'>
                            </label>
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
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.provinces_id.$error">
                                            <span v-if="!$v.model.attributes.provinces_id.required">
                                <?php echo "{{model.structure.provinces_id.required.msj}}" ?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-3" v-if="$v.model.attributes.provinces_id.$model">
                            <label class="form__label " v-html='getLabelForm("cities_id")'>
                            </label>
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
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.cities_id.$error">
                                            <span v-if="!$v.model.attributes.cities_id.required">
                                <?php echo "{{model.structure.cities_id.required.msj}}" ?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-3" v-if="$v.model.attributes.cities_id.$model">
                            <label class="form__label " v-html='getLabelForm("zones_id")'>
                            </label>
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
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.zones_id.$error">
                                            <span v-if="!$v.model.attributes.zones_id.required">
                                <?php echo "{{model.structure.zones_id.required.msj}}" ?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-md-6">
                            <label class="form__label " v-html='getLabelForm("street_one")'>

                            </label>
                            <input
                                v-model.trim="$v.model.attributes.street_one.$model"
                                type="text"
                                v-bind:id="getNameAttribute('street_one')"
                                v-bind:name="getNameAttribute('street_one')"

                                @change="_setValueForm('street_one', $v.model.attributes.street_one.$model)"
                                v-focus-select
                            >
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.street_one.$error">
      <span v-if="!$v.model.attributes.street_one.required">
       <?php echo "{{model.structure.street_one.required.msj}}" ?>
      </span>
                                    <span v-if="!$v.model.attributes.street_one.maxLength">
       <?php echo "{{model.structure.street_one.maxLength.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form__label " v-html='getLabelForm("street_two")'>
                            </label>
                            <input
                                v-model.trim="$v.model.attributes.street_two.$model"
                                type="text"
                                v-bind:id="getNameAttribute('street_two')"
                                v-bind:name="getNameAttribute('street_two')"

                                @change="_setValueForm('street_two', $v.model.attributes.street_two.$model)"
                                v-focus-select
                            >
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.street_two.$error">
      <span v-if="!$v.model.attributes.street_two.required">
       <?php echo "{{model.structure.street_two.required.msj}}" ?>
      </span>
                                    <span v-if="!$v.model.attributes.street_two.maxLength">
       <?php echo "{{model.structure.street_two.maxLength.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
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
                            <div class="map-guests"
                                 v-init-map-plugin="{model:$v.model.attributes,methodInit:_initMap,elementSelector: '.map-guests'}"
                                 id="manager-map">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form__label " v-html='getLabelForm("reference")'> </label>
                            <textarea
                                class="custom-form--auto-height-text-area"
                                cols="40" rows="3" placeholder=""
                                v-model.trim="$v.model.attributes.reference.$model"
                                v-bind:id="getNameAttribute('reference')"
                                v-bind:name="getNameAttribute('reference')"
                                @change="_setValueForm('reference', $v.model.attributes.reference.$model)"
                                v-focus-select

                            ></textarea>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.reference.$error">
                                            <span v-if="!$v.model.attributes.reference.required">
                                <?php echo "{{model.structure.reference.required.msj}}" ?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="profile-edit-container add-list-container">
                <div class="profile-edit-header fl-wrap" style="margin-top:30px">
                    <h4>{{__('frontend.account.menu.profile.title.five')}}</h4>
                </div>
                <div class="custom-form custom-form--opacity-placeholder-50">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form__label " v-html='getLabelForm("information_phone_value")'>

                            </label>
                            <input
                                v-model.trim="$v.model.attributes.information_phone_value.$model"
                                type="text"
                                v-bind:id="getNameAttribute('information_phone_value')"
                                v-bind:name="getNameAttribute('information_phone_value')"
                                @change="_setValueForm('information_phone_value', $v.model.attributes.information_phone_value.$model)"
                                v-focus-select
                            />
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.information_phone_value.$error">
                                            <span v-if="!$v.model.attributes.information_phone_value.required">
                                <?php echo "{{model.structure.information_phone_value.required.msj}}" ?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form__label " v-html='getLabelForm("user_by_about_us_web")'>
                            </label>
                            <input
                                v-model.trim="$v.model.attributes.user_by_about_us_web.$model"
                                type="text"
                                v-bind:id="getNameAttribute('user_by_about_us_web')"
                                v-bind:name="getNameAttribute('user_by_about_us_web')"
                                @change="_setValueForm('user_by_about_us_web', $v.model.attributes.user_by_about_us_web.$model)"
                                v-focus-select
                                placeholder="themeforest.net" value=""/>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="profile-edit-container add-list-container not-view">
            <div class="profile-edit-header fl-wrap" style="margin-top:30px">
                <h4>{{__('frontend.account.menu.profile.title.two')}}</h4>
            </div>
            <div class="custom-form custom-form--opacity-placeholder-50">
                <div class="row">

                    <div class="col-md-4">
                        <div class="add-list-media-header">
                            <label class="radio inline">
                                <input type="radio" name="plane" checked>
                                <span>{{__('frontend.menu.home.prices.bee.title')}}  {{__('frontend.menu.home.prices.bee.subtitle')}}</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="add-list-media-header">
                            <label class="radio inline">
                                <input type="radio" name="plane">
                                <span>{{__('frontend.menu.home.prices.worker.title')}}  {{__('frontend.menu.home.prices.worker.subtitle')}}
                                    $</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="add-list-media-header">
                            <label class="radio inline">
                                <input type="radio" name="plane">
                                <span>{{__('frontend.menu.home.prices.queen.title')}}  {{__('frontend.menu.home.prices.queen.subtitle')}}
                                    $</span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="profile-edit-container">
            <div class="profile-edit-header fl-wrap" style="margin-top:30px">
                <h4>{{__('frontend.account.menu.profile.title.three')}}</h4>
            </div>
            <div class="custom-form custom-form--opacity-placeholder-50">
                <div class="row">
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("information_social_network_value_one")'>
                        </label>
                        <input

                            v-model.trim="$v.model.attributes.information_social_network_value_one.$model"
                            type="text"
                            v-bind:id="getNameAttribute('information_social_network_value_one')"
                            v-bind:name="getNameAttribute('information_social_network_value_one')"
                            @change="_setValueForm('information_social_network_value_one', $v.model.attributes.information_social_network_value_one.$model)"
                            v-focus-select
                        />

                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.information_social_network_value_one.$error">
                                            <span
                                                v-if="!$v.model.attributes.information_social_network_value_one.required">
                                <?php echo "{{model.structure.information_social_network_value_one.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("information_social_network_value_two")'> <i
                                class="fa fa-twitter"></i>
                        </label>
                        <input

                            v-model.trim="$v.model.attributes.information_social_network_value_two.$model"
                            type="text"
                            v-bind:id="getNameAttribute('information_social_network_value_two')"
                            v-bind:name="getNameAttribute('information_social_network_value_two')"
                            @change="_setValueForm('information_social_network_value_two', $v.model.attributes.information_social_network_value_two.$model)"
                            v-focus-select
                        />

                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.information_social_network_value_two.$error">
                                            <span
                                                v-if="!$v.model.attributes.information_social_network_value_two.required">
                                <?php echo "{{model.structure.information_social_network_value_two.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("information_social_network_value_three")'> <i
                                class="fa fa-twitter"></i>
                        </label>
                        <input

                            v-model.trim="$v.model.attributes.information_social_network_value_three.$model"
                            type="text"
                            v-bind:id="getNameAttribute('information_social_network_value_three')"
                            v-bind:name="getNameAttribute('information_social_network_value_three')"
                            @change="_setValueForm('information_social_network_value_three', $v.model.attributes.information_social_network_value_three.$model)"
                            v-focus-select
                        />

                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.information_social_network_value_three.$error">
                                            <span
                                                v-if="!$v.model.attributes.information_social_network_value_three.required">
                                <?php echo "{{model.structure.information_social_network_value_three.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("information_social_network_value_four")'>
                        </label>
                        <input

                            v-model.trim="$v.model.attributes.information_social_network_value_four.$model"
                            type="text"
                            v-bind:id="getNameAttribute('information_social_network_value_four')"
                            v-bind:name="getNameAttribute('information_social_network_value_four')"
                            @change="_setValueForm('information_social_network_value_four', $v.model.attributes.information_social_network_value_four.$model)"
                            v-focus-select
                        />

                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.information_social_network_value_four.$error">
                                            <span
                                                v-if="!$v.model.attributes.information_social_network_value_four.required">
                                <?php echo "{{model.structure.information_social_network_value_four.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("information_social_network_value_five")'> <i
                                class="fa fa-twitter"></i>
                        </label>
                        <input

                            v-model.trim="$v.model.attributes.information_social_network_value_five.$model"
                            type="text"
                            v-bind:id="getNameAttribute('information_social_network_value_five')"
                            v-bind:name="getNameAttribute('information_social_network_value_five')"
                            @change="_setValueForm('information_social_network_value_five', $v.model.attributes.information_social_network_value_five.$model)"
                            v-focus-select
                        />

                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.information_social_network_value_five.$error">
                                            <span
                                                v-if="!$v.model.attributes.information_social_network_value_five.required">
                                <?php echo "{{model.structure.information_social_network_value_five.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form__label " v-html='getLabelForm("information_social_network_value_six")'> <i
                                class="fa fa-twitter"></i>
                        </label>
                        <input

                            v-model.trim="$v.model.attributes.information_social_network_value_six.$model"
                            type="text"
                            v-bind:id="getNameAttribute('information_social_network_value_six')"
                            v-bind:name="getNameAttribute('information_social_network_value_six')"
                            @change="_setValueForm('information_social_network_value_six', $v.model.attributes.information_social_network_value_six.$model)"
                            v-focus-select
                        />

                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.information_social_network_value_six.$error">
                                            <span
                                                v-if="!$v.model.attributes.information_social_network_value_six.required">
                                <?php echo "{{model.structure.information_social_network_value_six.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="form__label " v-html='getLabelForm("user_by_about_us_description")'> </label>
                        <textarea
                            class="custom-form--auto-height-text-area"
                            cols="40" rows="3" placeholder="About Me"
                            v-model.trim="$v.model.attributes.user_by_about_us_description.$model"
                            v-bind:id="getNameAttribute('user_by_about_us_description')"
                            v-bind:name="getNameAttribute('user_by_about_us_description')"
                            @change="_setValueForm('user_by_about_us_description', $v.model.attributes.user_by_about_us_description.$model)"
                            v-focus-select

                        ></textarea>
                        <div class="content-message-errors ">
                            <b-form-invalid-feedback
                                :state="!$v.model.attributes.user_by_about_us_description.$error">
                                            <span v-if="!$v.model.attributes.user_by_about_us_description.required">
                                <?php echo "{{model.structure.user_by_about_us_description.required.msj}}" ?>
                            </span>

                            </b-form-invalid-feedback>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</div>
