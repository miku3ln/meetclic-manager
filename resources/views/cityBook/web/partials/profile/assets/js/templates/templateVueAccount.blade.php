<script type="text/x-template" id="grid-management-template">
    <div>


        <b-container class="bv-example-row">
            <div class="content-row-manager-buttons">
                <div v-if="!showManager">
                    <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                        <div v-for="(menu, key) in managerMenuConfig.menuCurrent" class="inline-data">
                            <a v-if="menu.isUrl==true"
                               v-bind:href="menu.url+'/managerDashboard'"
                               target="_blank"
                               v-init-tool-tip
                               v-bind:id="'a-menu-'+menu.rowId"
                               class="btn--xs content-manager-buttons-grid__a " data-toggle="tooltip"
                               data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                            </a>
                            <a v-else
                               v-init-tool-tip
                               v-bind:id="'a-menu-'+menu.rowId"
                               v-on:click="_managerMenuGrid(key, menu)"
                               class=" btn--xs content-manager-buttons-grid__a " data-toggle="tooltip"
                               data-placement="top" v-bind:data-original-title="<?php echo 'menu.title' ?>">
                                <i v-bind:class="<?php echo 'menu.icon' ?>"></i>
                            </a>
                        </div>


                    </div>
                </div>

            </div>
        </b-container>
        <?php ?>
        <div class="content-manager-grid">

            <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                <div class="search-manager">
                    <div class="row">
                        <div class="col-md-12 search-manager__actions">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="search-manager__needle">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <input v-init-grid-filters="{initMethod:_search}" type="text"
                                               placeholder="Buscar ....."
                                               v-model="search.needle"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="search-manager__sort header-search-select-item ">
                                        <select name="sort-by" id="sort-by" class="chosen-select">
                                            <option value="-1" id="allSort"
                                                    title="{{__('account.filters.sort.one')}}"
                                                    order="asc">{{__('account.filters.sort.one')}}</option>
                                            <option value="0" id="input_movement"
                                                    title="{{__('account.filters.sort.two')}}"
                                                    order="asc">{{__('account.filters.sort.two')}}</option>
                                            <option value="1" id="description"
                                                    title="{{__('account.filters.sort.three')}}"
                                                    order="asc">{{__('account.filters.sort.three')}}</option>



                                        </select>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>
                </div>
                <table id="account_gamification_by_movement-grid"
                       class=""

                >
                    <thead>
                    <tr>
                        <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                        <th data-column-id="description" data-formatter="description">Actividades recientes</th>

                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="content-form profile-edit-container" v-if="showManager">

            <b-form id="businessForm" v-on:submit.prevent="_submitForm"
            >

                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >
                <input v-model="model.attributes.id" type="hidden"

                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >
                <input v-model="model.attributes.street_lat" type="hidden"

                       v-bind:id="getNameAttribute('street_lat')"
                       v-bind:name="getNameAttribute('street_lat')"
                >
                <input v-model="model.attributes.street_lng" type="hidden"

                       v-bind:id="getNameAttribute('street_lng')"
                       v-bind:name="getNameAttribute('street_lng')"
                >


                <div class="custom-form custom-form--opacity-placeholder-50">


                    <div class="profile-edit-container add-list-container">
                        <div class="profile-edit-header fl-wrap">
                            <h4> {{__('frontend.account.menu.my-business.one')}}</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="manager-content-upload upload-demo">
                                    <div class="upload-msg">
                                        {{__('frontend.account.menu.my-business.field.one')}}
                                    </div>
                                    <div class="upload-demo-wrap">
                                        <div id="upload-demo"></div>
                                    </div>
                                    <input
                                        v-init-crop="{initMethod:initCropBusiness}"
                                        type="file"
                                        id="file-upload-business"
                                        accept="image/*"
                                        name="Information[file_upload_img]"
                                    >
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-4">
                                <div class=""
                                     :class="getClassErrorForm('business_subcategories_id',$v.model.attributes.business_subcategories_id)">
                                    <label v-html='getLabelForm("business_subcategories_id")'></label>
                                    <select

                                        v-bind:id="getNameAttribute('business_subcategories_id')"
                                        v-bind:name="getNameAttribute('business_subcategories_id')"
                                        class="form-control m-input"
                                        @change="_setValueForm('business_subcategories_id',$v.model.attributes.business_subcategories_id.$model)"
                                        v-model.trim="$v.model.attributes.business_subcategories_id.$model"


                                    >
                                        <optgroup v-for="(row,index) in businessSubcategoriesData"
                                                  v-bind:label="index">
                                            <option v-for="(rowInfo,indexInfo) in row"
                                                    v-bind:value="indexInfo">
                                                <?php echo '{{rowInfo}}' ?>

                                            </option>

                                        </optgroup>
                                    </select>

                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.business_subcategories_id.$error">
                                            <span v-if="!$v.model.attributes.business_subcategories_id.required">
                                <?php echo "{{model.structure.business_subcategories_id.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class=""
                                     :class="getClassErrorForm('type_business',$v.model.attributes.type_business)">
                                    <label v-html='getLabelForm("type_business")'></label>
                                    <select

                                        v-bind:id="getNameAttribute('type_business')"
                                        v-bind:name="getNameAttribute('type_business')"
                                        class="form-control m-input"
                                        @change="_setValueForm('type_business',$v.model.attributes.type_business.$model)"
                                        v-model.trim="$v.model.attributes.type_business.$model"


                                    >
                                        <option v-for="(row,index) in typeBusinessData"
                                                v-bind:value="row.id"><?php echo '{{row.value}}' ?></option>
                                    </select>

                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.business_subcategories_id.$error">
                                            <span v-if="!$v.model.attributes.business_subcategories_id.required">
                                <?php echo "{{model.structure.business_subcategories_id.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="" :class="getClassErrorForm('title',$v.model.attributes.title)">
                                    <label v-html='getLabelForm("title")'><i
                                            class="fa fa-briefcase"></i></label>
                                    <input
                                        v-model.trim="$v.model.attributes.title.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('title')"
                                        v-bind:name="getNameAttribute('title')"
                                        placeholder="Tukuykuna"
                                        @change="_setValueForm('title', $event.target.value)"
                                        v-focus-select
                                    >
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.title.$error">
                                            <span v-if="!$v.model.attributes.title.required">
                                <?php echo "{{model.structure.title.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <b-row>
                            <b-col md="4" v-if="$v.model.attributes.business_subcategories_id.$model>0">
                                <div class="form-group"
                                     :class="getClassErrorForm('business_by_amenities_data',$v.model.attributes.business_by_amenities_data)">
                                    <label
                                        class="form__label "
                                        v-html='getLabelForm("business_by_amenities_data")'></label>
                                    <div class="content-element-form">

                                        <select id="business_by_amenities_data"
                                                class="form-control m-select2 "
                                                v-initS2Plugin="{rowId:model.attributes.id,nameMethod:_managerS2Amenities}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.business_by_amenities_data.$error">
      <span v-if="!$v.model.attributes.business_by_amenities_data.required">
       <?php echo "{{model.structure.business_by_amenities_data.required.msj}}" ?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>

                    </div>

                    <div class="profile-edit-container add-list-container">
                        <div class="profile-edit-header fl-wrap">
                            <h4> {{__('frontend.account.menu.my-business.two')}}</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class=""
                                     :class="getClassErrorForm('countries_id',$v.model.attributes.countries_id)">
                                    <label v-html='getLabelForm("countries_id")'></label>
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
                            </div>
                            <div class="col-md-3"
                                 v-if="$v.model.attributes.countries_id.$model">
                                <div class=""
                                     :class="getClassErrorForm('provinces_id',$v.model.attributes.provinces_id)">
                                    <label v-html='getLabelForm("provinces_id")'></label>
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
                            </div>
                            <div class="col-md-3" v-if="$v.model.attributes.provinces_id.$model ">
                                <div class=""
                                     :class="getClassErrorForm('cities_id',$v.model.attributes.cities_id)">
                                    <label v-html='getLabelForm("cities_id")'></label>
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
                            </div>
                            <div class="col-md-3" v-if="$v.model.attributes.cities_id.$model ">
                                <div class=""
                                     :class="getClassErrorForm('zones_id',$v.model.attributes.zones_id)">
                                    <label v-html='getLabelForm("zones_id")'></label>
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
                                <div id="map" class="map-information"
                                     v-init-map="{initMapCurrent:initMapCurrent,modelBusiness:$v.model.attributes}">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="" :class="getClassErrorForm('street_1',$v.model.attributes.street_1)">
                                    <label v-html='getLabelForm("street_1")'><i
                                            class="fa fa-map-marker"></i></label>
                                    <input
                                        v-model.trim="$v.model.attributes.street_1.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('street_1')"
                                        v-bind:name="getNameAttribute('street_1')"
                                        placeholder="Piedrahita"
                                        @change="_setValueForm('street_1', $event.target.value)"
                                        v-focus-select
                                    >
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.street_1.$error">
                                            <span v-if="!$v.model.attributes.street_1.required">
                                <?php echo "{{model.structure.street_1.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="" :class="getClassErrorForm('street_2',$v.model.attributes.street_2)">
                                    <label v-html='getLabelForm("street_2")'><i
                                            class="fa fa-map-marker"></i></label>
                                    <input
                                        v-model.trim="$v.model.attributes.street_2.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('street_2')"
                                        v-bind:name="getNameAttribute('street_2')"
                                        placeholder="Buenos Aires"
                                        @change="_setValueForm('street_2', $event.target.value)"
                                        v-focus-select
                                    >
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.street_2.$error">
                                            <span v-if="!$v.model.attributes.street_2.required">
                                <?php echo "{{model.structure.street_2.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="profile-edit-container add-list-container">
                        <div class="profile-edit-header fl-wrap">
                            <h4> {{__('frontend.account.menu.my-business.three')}}</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="" :class="getClassErrorForm('phone_value',$v.model.attributes.phone_value)">
                                    <label v-html='getLabelForm("phone_value")'><i
                                            class="fa fa-phone"></i></label>
                                    <input
                                        v-model.trim="$v.model.attributes.phone_value.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('phone_value')"
                                        v-bind:name="getNameAttribute('phone_value')"
                                        placeholder="+593995607584"
                                        @change="_setValueForm('phone_value', $event.target.value)"
                                        v-focus-select
                                    >
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.phone_value.$error">
                                            <span v-if="!$v.model.attributes.phone_value.required">
                                <?php echo "{{model.structure.phone_value.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="" :class="getClassErrorForm('email',$v.model.attributes.email)">
                                    <label v-html='getLabelForm("email")'><i
                                            class="fa fa-envelope-o"></i></label>
                                    <input
                                        v-model.trim="$v.model.attributes.email.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('email')"
                                        v-bind:name="getNameAttribute('email')"
                                        placeholder="tukuykuna.bee@.com"
                                        @change="_setValueForm('email', $event.target.value)"
                                        v-focus-select
                                    >
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.email.$error">
                                            <span v-if="!$v.model.attributes.email.required">
                                <?php echo "{{model.structure.email.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="" :class="getClassErrorForm('page_url',$v.model.attributes.page_url)">
                                    <label v-html='getLabelForm("page_url")'><i
                                            class="fa fa-globe"></i></label>
                                    <input
                                        v-model.trim="$v.model.attributes.page_url.$model"
                                        type="text"
                                        v-bind:id="getNameAttribute('page_url')"
                                        v-bind:name="getNameAttribute('page_url')"
                                        placeholder="www.tukuykuna.com"
                                        @change="_setValueForm('page_url', $event.target.value)"
                                        v-focus-select
                                    >
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.page_url.$error">
                                            <span v-if="!$v.model.attributes.page_url.required">
                                <?php echo "{{model.structure.page_url.required.msj}}" ?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <b-row>
                        <b-col md="12">
                            <div class=""
                                 :class="getClassErrorForm('description',$v.model.attributes.description)">
                                <label class="form__label " v-html='getLabelForm("description")'></label>
                                <textarea
                                    rows="2"
                                    v-model.trim="$v.model.attributes.description.$model"
                                    type="text"
                                    v-bind:id="getNameAttribute('description')"
                                    v-bind:name="getNameAttribute('description')"
                                    class="form-control m-input"
                                    @change="_setValueForm('description', $event.target.value)"
                                    v-focus-select

                                ></textarea>

                                <div class="content-message-errors ">
                                    <b-form-invalid-feedback
                                        :state="!$v.model.attributes.description.$error">
                                            <span v-if="!$v.model.attributes.description.required">
                                <?php echo "{{model.structure.description.required.msj}}" ?>
                            </span>

                                    </b-form-invalid-feedback>
                                </div>
                            </div>
                        </b-col>


                    </b-row>
                    @if(env('allowAllInOne'))
                        <div class="profile-edit-container add-list-container">
                            <div class="profile-edit-header fl-wrap">
                                <h4> {{__('frontend.account.menu.my-business.five')}}</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class=""
                                         :class="getClassErrorForm('type_account',$v.model.attributes.type_account)">
                                        <label v-html='getLabelForm("type_account")'></label>
                                        <select

                                            v-bind:id="getNameAttribute('type_account')"
                                            v-bind:name="getNameAttribute('type_account')"
                                            class="form-control m-input"
                                            @change="_setValueForm('type_account',$v.model.attributes.type_account.$model)"
                                            v-model.trim="$v.model.attributes.type_account.$model"


                                        >
                                            <option v-for="(row,index) in typeAccount"
                                                    v-bind:value="row.id"><?php echo '{{row.value}}' ?></option>
                                        </select>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.type_account.$error">
                                            <span v-if="!$v.model.attributes.type_account.required">
                                <?php echo "{{model.structure.type_account.required.msj}}" ?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="" :class="getClassErrorForm('bank_id',$v.model.attributes.bank_id)">
                                        <label v-html='getLabelForm("bank_id")'></label>
                                        <select

                                            v-bind:id="getNameAttribute('bank_id')"
                                            v-bind:name="getNameAttribute('bank_id')"
                                            class="form-control m-input"
                                            @change="_setValueForm('bank_id',$v.model.attributes.bank_id.$model)"
                                            v-model.trim="$v.model.attributes.bank_id.$model"


                                        >
                                            <option v-for="(row,index) in bankData"
                                                    v-bind:value="row.id"><?php echo '{{row.value}}' ?></option>
                                        </select>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.bank_id.$error">
                                            <span v-if="!$v.model.attributes.bank_id.required">
                                <?php echo "{{model.structure.bank_id.required.msj}}" ?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class=""
                                         :class="getClassErrorForm('account_number',$v.model.attributes.account_number)">
                                        <label v-html='getLabelForm("account_number")'><i
                                                class="fa fa-globe"></i></label>
                                        <input
                                            v-model.trim="$v.model.attributes.account_number.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('account_number')"
                                            v-bind:name="getNameAttribute('account_number')"
                                            placeholder="2201497612"
                                            @change="_setValueForm('account_number', $event.target.value)"
                                            v-focus-select
                                        >
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!$v.model.attributes.account_number.$error">
                                            <span v-if="!$v.model.attributes.account_number.required">
                                <?php echo "{{model.structure.account_number.required.msj}}" ?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                @endif

            </b-form>

        </div>


    </div>

</script>
