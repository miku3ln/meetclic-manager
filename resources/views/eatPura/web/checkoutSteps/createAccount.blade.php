@if(!$dataManagerPage['profileConfig']['success'])
    <div class="create-account">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="single-method">

                    <input type="checkbox"
                           @change="_setValueForm('create_account', $v.model.attributes.create_account.$model)"
                           id="create_account"
                           v-model.trim="$v.model.attributes.create_account.$model">
                    <label for="create_account">{{__('checkout.form.create-account')}} </label>
                </div>

            </div>

        </div>
        <div class="row" v-if="$v.model.attributes.create_account.$model">
            <div class="col-md-12 col-sm-12">
                <div class="form-group" :class="getClassErrorForm('email',$v.model.attributes.email)">

                    <label class='form__label'>{{__('checkout.form.create-account.email')}}*</label>
                    <input
                        @change="_setValueForm('email', $v.model.attributes.email.$model)"
                        v-model.trim="$v.model.attributes.email.$model"
                        type="email"
                        placeholder="{{__('checkout.form.create-account.email.place-holder')}}"
                        name="OrderBillingCustomer[email]" id="email"
                        class="form-control"
                        v-focus-select
                        v-reset-field="{form:$v.model.attributes,fieldName:'email'}"
                        required>
                    <div class="content-message-errors">
                        <b-form-invalid-feedback
                            :state="!$v.model.attributes.email.$error">
                                            <span v-if="!$v.model.attributes.email.required">
                                <?php  echo "{{model.structure.email.required.msj}}"?>
                            </span>
                            <span v-if="!$v.model.attributes.email.email">
                                <?php  echo "{{model.structure.email.email.msj}}"?>
                            </span>

                            <span v-if="!$v.model.attributes.email.isUnique && managerInitGet.email.allow">
                               <?php  echo "{{model.structure.email.unique.msj}}"?>
                            </span>
                        </b-form-invalid-feedback>
                    </div>
                </div>
            </div>

        </div>
    </div>




@endif
