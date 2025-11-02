{{-- CMS -TEMPLATE-CHANGE-PASSWORD-TEMPLATE--}}
<div class="profile-edit-container">
    <div class="profile-edit-header fl-wrap" style="margin-top:30px">
        <h4> {{__('frontend.account.menu.change-password.title')}}</h4>
    </div>
    <div class="custom-form custom-form--opacity-placeholder-50 no-icons">
        <div class="pass-input-wrap fl-wrap">
            <label v-html='getLabelForm("password_old")'> {{__('frontend.account.menu.change-password.field.one')}}</label>
            <input
                type="password"
                class="pass-input" placeholder=""

                v-model.trim="$v.model.attributes.password_old.$model"
                v-bind:id="getNameAttribute('password_old')"
                v-bind:name="getNameAttribute('password_old')"
                @change="_setValueForm('password_old', $v.model.attributes.password_old.$model)"
                v-focus-select
            />
            <div class="content-message-errors ">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.password_old.$error">
                                            <div v-if="!$v.model.attributes.password_old.required">
                                <?php  echo "{{model.structure.password_old.required.msj}}"?>
                            </div>

                    <div v-if="!$v.model.attributes.password_old.isUnique">
                                <?php  echo "Password no coincide con la anterior."?>
                            </div>
                </b-form-invalid-feedback>
            </div>
            <span class="eye"><i class="fa fa-eye" aria-hidden="true"></i> </span>
        </div>
        <div class="pass-input-wrap fl-wrap">
            <label v-html='getLabelForm("password_new")'> {{__('frontend.account.menu.change-password.field.two')}}</label>
            <input type="password" class="pass-input" placeholder=""

                   v-model.trim="$v.model.attributes.password_new.$model"
                   v-bind:id="getNameAttribute('password_new')"
                   v-bind:name="getNameAttribute('password_new')"
                   @change="_setValueForm('password_new', $v.model.attributes.password_new.$model)"
                   v-focus-select

            />
            <b-form-invalid-feedback
                :state="!$v.model.attributes.password_new.$error">
                <div v-if="!$v.model.attributes.password_new.required">
                    <?php  echo "{{model.structure.password_new.required.msj}}"?>
                </div>


            </b-form-invalid-feedback>
            <span class="eye"><i class="fa fa-eye" aria-hidden="true"></i> </span>
        </div>
        <div class="pass-input-wrap fl-wrap">
            <label v-html='getLabelForm("password_repeat")'> {{__('frontend.account.menu.change-password.field.three')}}</label>
            <input type="password" class="pass-input" placeholder=""

                   v-model.trim="$v.model.attributes.password_repeat.$model"
                   v-bind:id="getNameAttribute('password_repeat')"
                   v-bind:name="getNameAttribute('password_repeat')"
                   @change="_setValueForm('password_repeat', $v.model.attributes.password_repeat.$model)"
                   v-focus-select
            />

            <b-form-invalid-feedback
                :state="!$v.model.attributes.password_repeat.$error">
                <div v-if="!$v.model.attributes.password_repeat.required">
                    <?php  echo '{{ !$v.model.attributes.password_new.sameAsPassword?"No son iguales las contraseñas.": model.structure.password_new.required.msj}}'?>
                </div>


            </b-form-invalid-feedback>
            <span class="eye"><i class="fa fa-eye" aria-hidden="true"></i> </span>
        </div>
        <button
            v-on:click="_saveModel()"
            :disabled="!validateForm()"
            class="btn  big-btn  color-bg flat-btn"> {{__('frontend.buttons.save-changes')}}<i
                class="fa fa-angle-right"


            ></i>

        </button>
    </div>
</div>
