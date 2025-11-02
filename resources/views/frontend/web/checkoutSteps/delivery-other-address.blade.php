<div id="billing_billing-other-form" class="billing-other-form"
     v-if="$v.model.attributes.same_billing_address.$model==false">
    <div class="row">

        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_first_name',$v.model.attributes.billing_first_name)">

                <input
                    @change="_setValueForm('billing_first_name', $v.model.attributes.billing_first_name.$model)"
                    v-model.trim="$v.model.attributes.billing_first_name.$model"
                    name="OrderBillingCustomer[billing_first_name]" id="billing_first_name"
                    type="text"
                    placeholder="{{__('checkout.form.billing_first_name.place-holder')}}"
                    class="form-group__input"
                    v-focus-select
                    v-reset-field="{form:$v.model.attributes,fieldName:'billing_first_name'}"

                    required>
                <label class='form-group__label'>{{__('checkout.form.billing_first_name')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_first_name.$error">
                                            <span v-if="!$v.model.attributes.billing_first_name.required">
                                <?php  echo "{{model.structure.billing_first_name.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_last_name',$v.model.attributes.billing_last_name)">


                <input
                    @change="_setValueForm('billing_last_name', $v.model.attributes.billing_last_name.$model)"
                    v-model.trim="$v.model.attributes.billing_last_name.$model"
                    type="text"
                    placeholder="{{__('checkout.form.billing_last_name.place-holder')}}"
                    name="OrderBillingCustomer[billing_last_name]" id="billing_last_name"
                    class="form-group__input"
                    v-focus-select
                    v-reset-field="{form:$v.model.attributes,fieldName:'billing_last_name'}"

                    required>
                <label class='form-group__label'>{{__('checkout.form.billing_last_name')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_last_name.$error">
                                            <span v-if="!$v.model.attributes.billing_last_name.required">
                                <?php  echo "{{model.structure.billing_last_name.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_payer_email',$v.model.attributes.billing_payer_email)">


                <input
                    @change="_setValueForm('billing_payer_email', $v.model.attributes.billing_payer_email.$model)"
                    v-model.trim="$v.model.attributes.billing_payer_email.$model"
                    type="email"
                    placeholder="{{__('checkout.form.billing_payer_email.place-holder')}}"
                    name="OrderBillingCustomer[billing_payer_email]" id="billing_payer_email"
                    class="form-group__input"
                    v-focus-select
                    v-reset-field="{form:$v.model.attributes,fieldName:'billing_payer_email'}"

                    required>
                <label class='form-group__label'>{{__('checkout.form.billing_payer_email.place-holder')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_payer_email.$error">
                                            <span v-if="!$v.model.attributes.billing_payer_email.required">
                                <?php  echo "{{model.structure.billing_payer_email.required.msj}}"?>
                            </span>
                        <span v-if="!$v.model.attributes.billing_payer_email.email">
                                <?php  echo "{{model.structure.billing_payer_email.email.msj}}"?>
                            </span>
                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_phone',$v.model.attributes.billing_phone)">


                <input
                    @change="_setValueForm('billing_phone', $v.model.attributes.billing_phone.$model)"
                    v-model.trim="$v.model.attributes.billing_phone.$model"
                    type="text"
                    placeholder="{{__('checkout.form.billing_phone.place-holder')}}"
                    class="form-group__input"
                    v-focus-select
                    v-reset-field="{form:$v.model.attributes,fieldName:'billing_phone'}"

                    name="OrderBillingCustomer[billing_phone]" id="billing_phone" required>
                <label class='form-group__label'>{{__('checkout.form.billing_phone')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_phone.$error">
                                            <span v-if="!$v.model.attributes.billing_phone.required">
                                <?php  echo "{{model.structure.billing_phone.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_document',$v.model.attributes.billing_document)">


                <input type="text"
                       placeholder="{{__('checkout.form.billing_document.place-holder')}}"
                       @change="_setValueForm('billing_document', $v.model.attributes.billing_document.$model)"
                       v-model.trim="$v.model.attributes.billing_document.$model"
                       class="form-group__input"
                       v-focus-select
                       v-reset-field="{form:$v.model.attributes,fieldName:'billing_document'}"

                       name="OrderBillingCustomer[billing_document]" id="billing_document">
                <label class='form-group__label'>{{__('checkout.form.billing_document')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_document.$error">
                                            <span v-if="!$v.model.attributes.billing_document.required">
                                <?php  echo "{{model.structure.billing_document.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_company',$v.model.attributes.billing_company)">


                <input type="text"
                       placeholder="{{__('checkout.form.billing_company.place-holder')}}"
                       @change="_setValueForm('billing_company', $v.model.attributes.billing_company.$model)"
                       v-model.trim="$v.model.attributes.billing_company.$model"
                       class="form-group__input"
                       v-focus-select
                       v-reset-field="{form:$v.model.attributes,fieldName:'billing_company'}"

                       name="OrderBillingCustomer[billing_company]" id="billing_company">
                <label class='form-group__label'>{{__('checkout.form.billing_company')}}</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_company.$error">
                                            <span v-if="!$v.model.attributes.billing_company.required">
                                <?php  echo "{{model.structure.billing_company.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <label class='title-options'>{{__('checkout.form.billing_address')}}*</label>
        <div class="col-md-12 col-sm-12">
            <div class="form-group"
                 :class="getClassErrorForm('billing_state_province_id',$v.model.attributes.billing_state_province_id)">
                <label class=''>{{__('checkout.form.billing_state_province_id')}}*</label>

                <select
                    @change="_setValueForm('billing_state_province_id', $v.model.attributes.billing_state_province_id.$model)"
                    v-model.trim="$v.model.attributes.billing_state_province_id.$model"
                    class="form-control"
                    name="OrderBillingCustomer[billing_state_province_id]" id="billing_state_province_id">
                    <option v-for="row in model.structure.billing_state_province_id.data" v-bind:value="row.id">
                        <?php  echo "{{row.name}}"?>
                    </option>
                </select>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_state_province_id.$error">
                                            <span v-if="!$v.model.attributes.billing_state_province_id.required">
                                <?php  echo "{{model.structure.billing_state_province_id.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label" :class="getClassErrorForm('billing_city',$v.model.attributes.billing_city)">

                <input type="text"
                       placeholder="{{__('checkout.form.billing_city.place-holder')}}"
                       id="billing_city"
                       @change="_setValueForm('billing_city', $v.model.attributes.billing_city.$model)"
                       v-model.trim="$v.model.attributes.billing_city.$model"
                       class="form-group__input"
                       v-focus-select
                       name="OrderBillingCustomer[billing_city]" required>

                <label   class='form-group__label '>{{__('checkout.form.billing_city')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_city.$error">
                                            <span v-if="!$v.model.attributes.billing_city.required">
                                <?php  echo "{{model.structure.billing_city.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>
        <div class="col-12">

            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_address_main',$v.model.attributes.billing_address_main)">
                <input
                    @change="_setValueForm('billing_address_main', $v.model.attributes.billing_address_main.$model)"
                    v-model.trim="$v.model.attributes.billing_address_main.$model"
                    type="text"
                    placeholder="{{__('checkout.form.billing_address_main.place-holder')}}"
                    name="OrderBillingCustomer[billing_address_main]" id="billing_address_main"
                    class="form-group__input"
                    v-focus-select
                    v-reset-field="{form:$v.model.attributes,fieldName:'billing_address_main'}"

                    required>
                <label class='form-group__label'>{{__('checkout.form.billing_address_main.place-holder')}}</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_address_main.$error">
                                            <span v-if="!$v.model.attributes.billing_address_main.required">
                                <?php  echo "{{model.structure.billing_address_main.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_address_main',$v.model.attributes.billing_address_secondary)">

                <input type="text"
                       placeholder="{{__('checkout.form.billing_address_secondary.place-holder')}}"
                       @change="_setValueForm('billing_address_secondary', $v.model.attributes.billing_address_secondary.$model)"
                       v-model.trim="$v.model.attributes.billing_address_secondary.$model"
                       name="OrderBillingCustomer[billing_address_secondary]"
                       class="form-group__input"
                       v-focus-select
                       v-reset-field="{form:$v.model.attributes,fieldName:'billing_address_secondary'}"

                       id="billing_address_secondary" required>
                <label class='form-group__label'>{{__('checkout.form.billing_address_secondary.place-holder')}}</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_address_secondary.$error">
                                            <span v-if="!$v.model.attributes.billing_address_secondary.required">
                                <?php  echo "{{model.structure.billing_address_secondary.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>


        <div class="col-md-12 col-sm-12">
            <div class="form-group form-group--float-label"
                 :class="getClassErrorForm('billing_zipcode',$v.model.attributes.billing_zipcode)">


                <input type="text"
                       placeholder="{{__('checkout.form.billing_zipcode.place-holder')}}"
                       id="billing_zipcode"
                       @change="_setValueForm('billing_zipcode', $v.model.attributes.billing_zipcode.$model)"
                       v-model.trim="$v.model.attributes.billing_zipcode.$model"
                       class="form-group__input"
                       v-focus-select
                       v-reset-field="{form:$v.model.attributes,fieldName:'billing_zipcode'}"

                       name="OrderBillingCustomer[billing_zipcode]" required>
                <label class='form-group__label'>{{__('checkout.form.billing_zipcode')}}*</label>
                <div class="content-message-errors">
                    <b-form-invalid-feedback
                        :state="!$v.model.attributes.billing_zipcode.$error">
                                            <span v-if="!$v.model.attributes.billing_zipcode.required">
                                <?php  echo "{{model.structure.billing_zipcode.required.msj}}"?>
                            </span>

                    </b-form-invalid-feedback>
                </div>
            </div>
        </div>

    </div>
</div>
