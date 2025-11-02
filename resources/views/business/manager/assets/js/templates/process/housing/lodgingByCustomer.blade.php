<b-row>

    <b-alert v-model="!$v.model.attributes.people.required" variant="danger">
        Debe Existir por lo menos un huesped!
    </b-alert>
    <b-col lg="12" class="manager-add-guests">
        {{--ITERACTION INIT PEOPLE--}}
        <div v-if="getViewPeopleProcess()">
            <div v-for="(v, index) in $v.model.attributes.people.$each.$iter">
                <div v-bind:id="getIdManagerGuest(index,v)" class="content-badge-information-type-guest">


                    <b-badge
                            v-bind:variant="getClassGuest(v)"><?php echo '{{getLabelTitleGuest(index,v)}}' ?></b-badge>
                    <a v-if="v.allowAddPeopleS2.$model==false?(v.people_id.$model==null?true:false ):(true)" @click="_removePeople(index,v)" class="btn btn--delete btn-xs"
                       data-toggle="tooltip"
                       data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
                </div>
                <b-row>

                    <b-col md="6">

                        <div class="form-group"
                             :class="getClassErrorForm('people_nationality_id',v.people_nationality_id)">
                            <label class="form__label " v-html='getLabelForm("people_nationality_id")' ></label>
                            <div class="content ">
                                <select

                                        v-model.trim="v.people_nationality_id.$model"
                                        v-bind:id="getNameAttributePeople(index,'people_nationality_id')"
                                        v-bind:name="getNameAttributePeople(index,'people_nationality_id')"
                                        class="form-control m-input"
                                        @change="_setValueForm('people_nationality_id', $event.target.value,index,v.people_nationality_id)"
                                >
                                    <option v-bind:value="option.value"
                                            v-for="(option, indexOpn) in optionsPeopleNationality">
                                        <?php echo '{{option.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.people_nationality_id.$error">
                                            <span v-if="!v.people_nationality_id.required">
                                <?php  echo "{{model.structure.people_nationality_id.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="6">

                        <div class="form-group"
                             :class="getClassErrorForm('people_profession_id',v.people_profession_id)">
                            <label class="form__label " v-html='getLabelForm("people_profession_id")' ></label>
                            <div class="content ">
                                <select

                                        v-model.trim="v.people_profession_id.$model"
                                        v-bind:id="getNameAttributePeople(index,'people_profession_id')"
                                        v-bind:name="getNameAttributePeople(index,'people_profession_id')"
                                        class="form-control m-input"
                                        @change="_setValueForm('people_profession_id', $event.target.value,index,v.people_profession_id)"
                                >
                                    <option v-bind:value="option.value"
                                            v-for="(option, indexOpp) in optionsPeopleProfession">
                                        <?php echo '{{option.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.people_profession_id.$error">
                                            <span v-if="!v.people_profession_id.required">
                                <?php  echo "{{model.structure.people_profession_id.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col md="4">

                        <div class="form-group"
                             :class="getClassErrorForm('type_document',v.type_document)">
                            <label class="form__label " v-html='getLabelForm("type_document")' ></label>
                            <div class="content">
                                <select

                                        v-model.trim="v.type_document.$model"
                                        v-bind:id="getNameAttributePeople(index,'type_document')"
                                        v-bind:name="getNameAttributePeople(index,'type_document')"
                                        class="form-control m-input"
                                        @change="_setValueForm('type_document', $event.target.value,index,v.type_document)"
                                >
                                    <option v-bind:value="option.value"
                                            v-for="(option, indexOtd) in optionsTypeDocument">
                                        <?php echo '{{option.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.type_document.$error">
                                            <span v-if="!v.type_document.required">
                                <?php  echo "{{model.structure.type_document.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>

                    <b-col md="4">

                        <div class="form-group"
                             :class="getClassErrorForm('gender',v.gender)">
                            <label class="form__label " v-html='getLabelForm("gender")' ></label>
                            <div class="content ">
                                <select

                                        v-model.trim="v.gender.$model"
                                        v-bind:id="getNameAttributePeople(index,'gender')"
                                        v-bind:name="getNameAttributePeople(index,'gender')"
                                        class="form-control m-input"
                                        @change="_setValueForm('gender', $event.target.value,index,v.gender)"
                                >
                                    <option v-bind:value="option.value"
                                            v-for="(option, indexOg) in optionsGender">
                                        <?php echo '{{option.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.gender.$error">
                                            <span v-if="!v.gender.required">
                                <?php  echo "{{model.structure.gender.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="4">
                        <div class="form-group"
                             :class="getClassErrorForm('age',v.age)">
                            <label class="form__label " v-html='getLabelForm("age")' ></label>
                            <div class="content ">
                                <input
                                        type="number"
                                        v-model.trim="v.age.$model"
                                        v-bind:id="getNameAttributePeople(index,'age')"
                                        v-bind:name="getNameAttributePeople(index,'age')"
                                        class="form-control m-input"
                                        @change="_setValueForm('age', $event.target.value,index,v.age)"
                                        v-focus-select
                                >
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.age.$error">
                                            <span v-if="!v.age.required">
                                <?php  echo "{{model.structure.age.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>


                </b-row>
                <b-row>

                    <b-col md="6">

                        <div class="form-group"
                             :class="getClassErrorForm('document_number',v.document_number)">
                            <label class="form__label " v-html='getLabelForm("document_number")' ></label>
                            <div class="content">
                                <input
                                        v-model.trim="v.document_number.$model"
                                        v-bind:id="getNameAttributePeople(index,'document_number')"
                                        v-bind:name="getNameAttributePeople(index,'document_number')"
                                        class="form-control m-input"
                                        @change="_setValueForm('document_number', $event.target.value,index,v.document_number)"
                                        v-focus-select
                                >
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.document_number.$error">
                                            <span v-if="!v.document_number.required">
                                <?php  echo "{{model.structure.document_number.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>

                </b-row>
                <b-row>
                    <b-col md="6">
                        <div class="form-group"
                             :class="getClassErrorForm('last_name',v.last_name)">
                            <label class="form__label" v-html='getLabelForm("last_name")' ></label>
                            <div class="content ">
                                <input
                                        v-model.trim="v.last_name.$model"
                                        v-bind:id="getNameAttributePeople(index,'last_name')"
                                        v-bind:name="getNameAttributePeople(index,'last_name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('last_name', $event.target.value,index,v.last_name)"
                                        v-focus-select
                                >
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.last_name.$error">
                                            <span v-if="!v.last_name.required">
                                <?php  echo "{{model.structure.last_name.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="6">

                        <div class="form-group"
                             :class="getClassErrorForm('name',v.name)">
                            <label class="form__label " v-html='getLabelForm("status")' ></label>
                            <div class="content ">
                                <input
                                        v-model.trim="v.name.$model"
                                        v-bind:id="getNameAttributePeople(index,'name')"
                                        v-bind:name="getNameAttributePeople(index,'name')"
                                        class="form-control m-input"
                                        @change="_setValueForm('name', $event.target.value,index,v.name)"
                                        v-focus-select
                                >
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.name.$error">
                                            <span v-if="!v.name.required">
                                <?php  echo "{{model.structure.name.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                </b-row>

                <b-row v-if="!v.main.$model">
                    <b-col lg="2">

                        <div class="form-group"
                             :class="getClassErrorForm('has_information_additional',v.has_information_additional)">
                            <label class="form__label"
                                   v-bind:for="getNameAttributePeople(index,'has_information_additional')" v-html='getLabelForm("has_information_additional")' ></label>
                            <div class="toggle">
                                <input
                                        v-model="v.has_information_additional.$model"
                                        type="checkbox"
                                        v-bind:id="getNameAttributePeople(index,'has_information_additional')"
                                        v-bind:name="getNameAttributePeople(index,'has_information_additional')"
                                        @change="_setValueForm('has_information_additional', v.has_information_additional.$model,index,v.has_information_additional)"

                                >
                                <label v-bind:for="getNameAttributePeople(index,'has_information_additional')">
                                    <div class="toggle__switch"></div>
                                </label>
                            </div>
                            <div class="content-message-errors col-md-12">

                            </div>
                        </div>
                    </b-col>
                </b-row>
                {{--INFORMATION ADITIONAL--}}
                <b-row v-if="v.has_information_additional.$model">

                    <b-col md="6">

                        <div class="form-group"
                             :class="getClassErrorForm('mail',v.mail)">
                            <label class="form__label" v-html='getLabelForm("mail")' ></label>
                            <div class="content ">
                                <input
                                        v-model.trim="v.mail.$model"
                                        v-bind:id="getNameAttributePeople(index,'mail')"
                                        v-bind:name="getNameAttributePeople(index,'mail')"
                                        class="form-control m-input"
                                        @change="_setValueForm('mail', $event.target.value,index,v.mail)"
                                        v-focus-select
                                >
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.mail.$error">
                                            <span v-if="!v.mail.required">
                                <?php  echo "{{model.structure.mail.required.msj}}"?>
                            </span>
                                    <span v-if="!v.mail.email">
                                <?php  echo "Email-no valido"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="6">
                        <div class="form-group"
                             :class="getClassErrorForm('postal_code',v.postal_code)">
                            <label class="form__label " v-html='getLabelForm("postal_code")' ></label>
                            <div class="content ">
                                <input

                                        v-model.trim="v.postal_code.$model"
                                        v-bind:id="getNameAttributePeople(index,'postal_code')"
                                        v-bind:name="getNameAttributePeople(index,'postal_code')"
                                        class="form-control m-input"
                                        @change="_setValueForm('postal_code', $event.target.value,index,v.postal_code)"
                                        v-focus-select
                                >
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.postal_code.$error">
                                            <span v-if="!v.postal_code.required">
                                <?php  echo "{{model.structure.postal_code.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                </b-row>
                <b-row v-if="v.has_information_additional.$model">

                    <b-col md="6">

                        <div class="form-group"
                             :class="getClassErrorForm('phone',v.phone)">
                            <label class="form__label " v-html='getLabelForm("phone")' ></label>
                            <div class="content">
                                <input
                                        v-model.trim="v.phone.$model"
                                        v-bind:id="getNameAttributePeople(index,'phone')"
                                        v-bind:name="getNameAttributePeople(index,'phone')"
                                        class="form-control m-input"
                                        @change="_setValueForm('phone', $event.target.value,index,v.phone)"
                                        v-focus-select

                                >
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                        :state="!v.phone.$error">
                                            <span v-if="!v.phone.required">
                                <?php  echo "{{model.structure.phone.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                    <b-col md="6">
                        <div class="form-group"
                             :class="getClassErrorForm('mobile',v.mobile)">
                            <label class="form__label" v-html='getLabelForm("mobile")' ></label>
                            <div class="content ">
                                <input

                                        v-model.trim="v.mobile.$model"
                                        v-bind:id="getNameAttributePeople(index,'mobile')"
                                        v-bind:name="getNameAttributePeople(index,'mobile')"
                                        class="form-control m-input"
                                        @change="_setValueForm('mobile', $event.target.value,index,v.mobile)"
                                        v-focus-select
                                >
                            </div>
                            <div class="content-message-errors ">
                                <b-form-invalid-feedback
                                        :state="!v.mobile.$error">
                                            <span v-if="!v.mobile.required">
                                <?php  echo "{{model.structure.mobile.required.msj}}"?>
                            </span>

                                </b-form-invalid-feedback>
                            </div>
                        </div>
                    </b-col>
                </b-row>


                {{--map--}}
                <b-row v-if="v.has_information_additional.$model">
                    <b-col md="12">
                        <label class="title-information "><?php echo '{{labelsConfig.process.address}}' ?></label>
                    </b-col>
                </b-row>
                <b-row v-if="v.has_information_additional.$model">


                    <b-col md="12">
                        <div class="floating-panel-manager">
                            <input v-bind:id="getIdManagerGuestMap(index,v)"
                                   class="floating-panel-manager__search" type="textbox"
                                   value="Ecuador"
                                   v-focus-select


                            >

                        </div>
                        <div class="map-guests"
                             v-initMapLodging="{v:v,index:index,_initMap:_initMap}"
                             v-bind:id="getIdManagerGuestMapContent(index,v)">

                        </div>
                    </b-col>
                </b-row>
            </div>
        </div>


        {{--ITERACTION END--}}

    </b-col>
</b-row>
