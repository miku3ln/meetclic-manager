<div id="billing-form" class="billing-form">
    <div class="row" v-if="model.attributes.type_payment=='bank-deposit'">
        <div class="col-md-6 col-sm-12">
            <div class=" content-box-image content-box-preview"
                 @click="_uploadDataImage" id="manager-deposit"
                 :class="getClassErrorForm('deposit',$v.model.attributes.deposit)">
                <img class="content-box-image__preview preview-manager"
                     v-bind:id="getIdManagerUploads(0)"
                     name-deposit="deposit">
                <div class="content-element-form">
                    <input
                        v-upload-data="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'deposit',modelCurrent: this.model})}"
                        type="file"
                        v-bind:id="getIdManagerUploads(1)"
                        class="hidden"
                        v-reset-field="{form:$v.model.attributes,fieldName:'deposit'}"
                        v-bind:name="getNameAttribute('deposit')">
                </div>
                <div class="progress-gallery-image not-view"
                     v-bind:id="getIdManagerUploads(2)">
                    <div class="progress__bar"></div>
                    <div class="progress__percent">0%</div>
                </div>
                <div class="content-message-errors">

                </div>
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label form-group--float-label--label" :class="getClassErrorForm('first_name',$v.model.attributes.first_name)">

                <input
                    @change="_setValueForm('first_name', $v.model.attributes.first_name.$model)"
                    v-model.trim="$v.model.attributes.first_name.$model"
                    name="OrderBillingCustomer[first_name]" id="first_name"
                    type="text"
                    placeholder="{{__('checkout.form.first_name.place-holder')}}"
                    class="form-group__input"
                    v-focus-select
                    required>
                <label   class='form-group__label '>{{__('checkout.form.first_name')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.first_name.$error">
                                            <span v-if="!$v.model.attributes.first_name.required">
                                <?php  echo "{{model.structure.first_name.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('last_name',$v.model.attributes.last_name)">

                <input
                    @change="_setValueForm('last_name', $v.model.attributes.last_name.$model)"
                    v-model.trim="$v.model.attributes.last_name.$model"
                    type="text"
                    placeholder="{{__('checkout.form.last_name.place-holder')}}"
                    name="OrderBillingCustomer[last_name]" id="last_name"
                    class="form-group__input"
                    v-focus-select
                    required>
                <label   class='form-group__label '>{{__('checkout.form.last_name')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.last_name.$error">
                                            <span v-if="!$v.model.attributes.last_name.required">
                                <?php  echo "{{model.structure.last_name.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('payer_email',$v.model.attributes.payer_email)">


                <input
                    @change="_setValueForm('payer_email', $v.model.attributes.payer_email.$model)"
                    v-model.trim="$v.model.attributes.payer_email.$model"
                    type="email"
                    placeholder="{{__('checkout.form.payer_email.place-holder')}}"
                    name="OrderBillingCustomer[payer_email]" id="payer_email"
                    class="form-group__input"
                    v-focus-select
                    required>
                <label   class='form-group__label '>{{__('checkout.form.payer_email.place-holder')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.payer_email.$error">
                                            <span v-if="!$v.model.attributes.payer_email.required">
                                <?php  echo "{{model.structure.payer_email.required.msj}}"?>
                            </span>
                        <span v-if="!$v.model.attributes.payer_email.email">
                                <?php  echo "{{model.structure.payer_email.email.msj}}"?>
                            </span>
                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('phone',$v.model.attributes.phone)">


                <input
                    @change="_setValueForm('phone', $v.model.attributes.phone.$model)"
                    v-model.trim="$v.model.attributes.phone.$model"
                    type="text"
                    placeholder="{{__('checkout.form.phone.place-holder')}}"
                    class="form-group__input"
                    v-focus-select
                    name="OrderBillingCustomer[phone]" id="phone" required>
                <label   class='form-group__label '>{{__('checkout.form.phone')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.phone.$error">
                                            <span v-if="!$v.model.attributes.phone.required">
                                <?php  echo "{{model.structure.phone.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('document',$v.model.attributes.document)">


                <input type="text"
                       placeholder="{{__('checkout.form.document.place-holder')}}"
                       @change="_setValueForm('document', $v.model.attributes.document.$model)"
                       v-model.trim="$v.model.attributes.document.$model"
                       class="form-group__input"
                       v-focus-select
                       name="OrderBillingCustomer[document]" id="document">
                <label   class='form-group__label '>{{__('checkout.form.document')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.document.$error">
                                            <span v-if="!$v.model.attributes.document.required">
                                <?php  echo "{{model.structure.document.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('company',$v.model.attributes.company)">


                <input type="text"
                       placeholder="{{__('checkout.form.company.place-holder')}}"
                       @change="_setValueForm('company', $v.model.attributes.company.$model)"
                       v-model.trim="$v.model.attributes.company.$model"
                       class="form-group__input"
                       v-focus-select
                       name="OrderBillingCustomer[company]" id="company">
                <label   class='form-group__label '>{{__('checkout.form.company')}}</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.company.$error">
                                            <span v-if="!$v.model.attributes.company.required">
                                <?php  echo "{{model.structure.company.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <label class='title-options'>{{__('checkout.form.address')}}*</label>
        <div class="col-md-12 col-sm-12">
            <div class="form-group"
                 :class="getClassErrorForm('state_province_id',$v.model.attributes.state_province_id)">
                <label class=''>{{__('checkout.form.state_province_id')}}*</label>

                <select
                    @change="_setValueForm('state_province_id', $v.model.attributes.state_province_id.$model)"
                    v-model.trim="$v.model.attributes.state_province_id.$model"
                    class="form-control"
                    name="OrderBillingCustomer[state_province_id]" id="state_province_id">
                    <option v-for="row in model.structure.state_province_id.data" v-bind:value="row.id">
                        <?php  echo "{{row.name}}"?>
                    </option>
                </select>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.state_province_id.$error">
                                            <span v-if="!$v.model.attributes.state_province_id.required">
                                <?php  echo "{{model.structure.state_province_id.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('city',$v.model.attributes.city)">

                <input type="text"
                       placeholder="{{__('checkout.form.city.place-holder')}}"
                       id="city"
                       @change="_setValueForm('city', $v.model.attributes.city.$model)"
                       v-model.trim="$v.model.attributes.city.$model"
                       class="form-group__input"
                       v-focus-select
                       name="OrderBillingCustomer[city]" required>

                <label   class='form-group__label '>{{__('checkout.form.city')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.city.$error">
                                            <span v-if="!$v.model.attributes.city.required">
                                <?php  echo "{{model.structure.city.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-12">

            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('address_main',$v.model.attributes.address_main)">
                <input
                    @change="_setValueForm('address_main', $v.model.attributes.address_main.$model)"
                    v-model.trim="$v.model.attributes.address_main.$model"
                    type="text"
                    placeholder="{{__('checkout.form.address_main.place-holder')}}"
                    name="OrderBillingCustomer[address_main]" id="address_main"
                    class="form-group__input"
                    v-focus-select
                    v-reset-field="{form:$v.model.attributes,fieldName:'address_main'}"

                    required>
                <label   class='form-group__label '>{{__('checkout.form.address_main.place-holder')}}</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.address_main.$error">
                                            <span v-if="!$v.model.attributes.address_main.required">
                                <?php  echo "{{model.structure.address_main.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('address_main',$v.model.attributes.address_secondary)">

                <input type="text"
                       placeholder="{{__('checkout.form.address_secondary.place-holder')}}"
                       @change="_setValueForm('address_secondary', $v.model.attributes.address_secondary.$model)"
                       v-model.trim="$v.model.attributes.address_secondary.$model"
                       name="OrderBillingCustomer[address_secondary]"
                       class="form-group__input"
                       v-focus-select
                       v-reset-field="{form:$v.model.attributes,fieldName:'address_secondary'}"

                       id="address_secondary" required>
                <label   class='form-group__label '>{{__('checkout.form.address_secondary.place-holder')}}</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.address_secondary.$error">
                                            <span v-if="!$v.model.attributes.address_secondary.required">
                                <?php  echo "{{model.structure.address_secondary.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('zipcode',$v.model.attributes.zipcode)">

                <input type="text"
                       placeholder="{{__('checkout.form.zipcode.place-holder')}}"
                       id="zipcode"
                       @change="_setValueForm('zipcode', $v.model.attributes.zipcode.$model)"
                       v-model.trim="$v.model.attributes.zipcode.$model"
                       class="form-group__input"
                       v-focus-select
                       name="OrderBillingCustomer[zipcode]" required>

                <label   class='form-group__label '>{{__('checkout.form.zipcode')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.zipcode.$error">
                                            <span v-if="!$v.model.attributes.zipcode.required">
                                <?php  echo "{{model.structure.zipcode.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>

    </div>
</div>
