<script type="text/x-template" id="management-form-event-template">
    <div>
        <b-modal
            hide-footer
            id="modal-management-form-event"
            ref="refManagementFormEventModal"
            size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>

            <?php echo '@ok="_saveModal"' ?>
        >
            <template slot="modal-title">
                <label v-html="labelsConfig.title"></label>
            </template>

            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button

                        type="button"
                        class="btn  btn-danger"
                        v-on:click="_hideModal()">
                        <?php  echo "{{labelsConfig.buttons.return}}" ?>
                    </button>
                    <button type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModal">
                        <?php  echo "{{labelsConfig.buttons.manager}}" ?>
                    </button>
                </div>
            </b-container>
            <div class="d-block ">
                <b-form id="ManagementFormEvent" v-on:submit.prevent="_submitForm">
                    <b-row>
                        <h1 class="title-event">        <?php  echo "{{labelsConfig.event}}" ?></h1>

                        <b-col lg="4" v-show="validateForm()">

                            <div class="form-group"
                            >
                                <label class="form__label"
                                       for="preview"><?php echo '{{labelsConfig.buttons.verify}}' ?></label>
                                <div class="toggle">
                                    <input
                                        v-model="preview"
                                        type="checkbox"
                                        id="preview"
                                        name="preview"
                                        @change="_verify(preview)"

                                    >
                                    <label for="preview">
                                        <div class="toggle__switch"></div>
                                    </label>
                                </div>
                                <div class="content-message-errors col-md-12">

                                </div>
                            </div>
                        </b-col>
                    </b-row>

                    <div class="management" v-show="managementViews.management">

                        <b-row>
                            <b-col md="6">
                                <div class="form-group"
                                     :class="getClassErrorForm('user_payment_id',$v.model.attributes.user_payment_id)">
                                    <label class="form__label " v-html='getLabelForm("user_payment_id")' ></label>
                                    <div class="content ">
                                        <select
                                           id="user_payment_id"
                                            class="form-control m-select2 select2-container-modal"
                                            v-initS2Payment="{params:{model:$v.model.attributes},method:_managerS2UsersPayment}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.user_payment_id.$error">
                                            <span v-if="!$v.model.attributes.user_payment_id.required">
                                <?php  echo "{{model.structure.user_payment_id.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                        <b-row>

                            <b-col md="4">

                                <div class="form-group"
                                     :class="getClassErrorForm('team_id',$v.model.attributes.team_id)">
                                    <label class="form__label " v-html='getLabelForm("team_id")' ></label>
                                    <div class="content ">
                                        <select

                                            v-model.trim="$v.model.attributes.team_id.$model"
                                            v-bind:id="getNameAttribute('team_id')"
                                            v-bind:name="getNameAttribute('team_id')"
                                            class="form-control m-input"
                                            @change="_setValueForm('team_id',$v.model.attributes.team_id.$model)"
                                        >
                                            <option v-bind:value="option.value"
                                                    v-for="(option, indexOpn) in optionsTeams">
                                                <?php echo '{{option.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.team_id.$error">
                                            <span v-if="!$v.model.attributes.team_id.required">
                                <?php  echo "{{model.structure.team_id.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="4" v-if="$v.model.attributes.team_id.$model">

                                <div class="form-group"
                                     :class="getClassErrorForm('distance_id',$v.model.attributes.distance_id)">
                                    <label
                                        class="form__label " v-html='getLabelForm("distance_id")' ></label>
                                    <div class="content ">
                                        <select

                                            v-model.trim="$v.model.attributes.distance_id.$model"
                                            v-bind:id="getNameAttribute('distance_id')"
                                            v-bind:name="getNameAttribute('distance_id')"
                                            class="form-control m-input"
                                            @change="_setValueForm('distance_id', $v.model.attributes.distance_id.$model)"
                                        >
                                            <option v-bind:value="option.value"
                                                    v-for="(option, indexOpp) in optionsDistances">
                                                <?php echo '{{option.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors ">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.distance_id.$error">
                                            <span v-if="!$v.model.attributes.distance_id.required">
                                <?php  echo "{{model.structure.distance_id.required.msj}}"?>
                            </span>

                                        </b-form-invalid-feedback>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>

                        <div v-if="managerCustomers">
                            <div v-for="(v, index) in $v.model.attributes.people.$each.$iter"
                                 class="manager-content-user">
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group"
                                             :class="getClassErrorForm('user_id',v.user_id)">
                                            <label
                                                class="form__label " v-html='getLabelForm("user_id")' ></label>
                                            <div class="content">
                                                <select
                                                    v-bind:id="'user_id_'+index"
                                                    class="form-control m-select2 select2-container-modal"
                                                    v-initS2="{params:{model:v,index:index},method:_managerS2Users}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors ">
                                                <b-form-invalid-feedback
                                                    :state="!v.user_id.$error">
                                            <span v-if="!v.user_id.required">
                                <?php  echo "{{model.structure.user_id.required.msj}}"?>
                            </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>
                                    <b-col md="6">

                                        <div class="form-group"
                                             :class="getClassErrorForm('category_id',v.category_id)">
                                            <label
                                                class="form__label " v-html='getLabelForm("category_id")' ></label>
                                            <div class="content ">
                                                <select

                                                    v-model.trim="v.category_id.$model"
                                                    v-bind:id="'category_id_'+index"
                                                    v-bind:name="'category_id_'+index"
                                                    class="form-control m-input"
                                                    @change="_setValueFormItem(index,'category_id', v.category_id.$model)"
                                                >
                                                    <option v-bind:value="option.value"
                                                            v-for="(option, indexOpn) in optionsCategories">
                                                        <?php echo '{{option.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors ">
                                                <b-form-invalid-feedback
                                                    :state="!v.category_id.$error">
                                            <span v-if="!v.category_id.required">
                                <?php  echo "{{model.structure.category_id.required.msj}}"?>
                            </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>
                                    </b-col>
                                </b-row>
                                <span class="title-kit"> <?php echo '{{getLabelForm("kit_id")}}' ?></span>
                                <div class="kit-management">


                                    <b-row v-for="(vKit, indexKit) in  v.kits.$model">
                                        <b-col md="4">
                                            <span> <?php echo '{{vKit.text}}'?></span>
                                        </b-col>
                                        <b-col md="4" v-if="vKit.has_color">

                                            <div class="form-group"
                                            >
                                                <label
                                                    class="form__label " v-html='getLabelForm("color_id")' ></label>
                                                <div class="content ">
                                                    <select
                                                        v-bind:id="'color_id'+index+'_'+indexKit"
                                                        v-bind:name="'color_id'+index+'_'+indexKit"
                                                        class="form-control m-input"
                                                        @change="_setValueFormItemKit(index,indexKit,'colors',$event.target.value )"


                                                    >
                                                        <option v-bind:value="option.id"
                                                                v-for="(option, indexOpp) in vKit.colors.data">
                                                            <?php echo '{{option.text}}' ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="content-message-errors ">

                                                </div>
                                            </div>


                                        </b-col>
                                        <b-col md="4" v-if="vKit.has_size">
                                            <div class="form-group"
                                            >
                                                <label
                                                    class="form__label " v-html='getLabelForm("size_id")' ></label>
                                                <div class="content ">
                                                    <select
                                                        v-bind:id="'size_id'+index+'_'+indexKit"
                                                        v-bind:name="'size_id'+index+'_'+indexKit"
                                                        class="form-control m-input"
                                                        @change="_setValueFormItemKit(index,indexKit,'sizes',$event.target.value )"


                                                    >
                                                        <option v-bind:value="option.id"
                                                                v-for="(option, indexOpp) in vKit.sizes.data">
                                                            <?php echo '{{option.text}}' ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="content-message-errors ">

                                                </div>
                                            </div>

                                        </b-col>
                                    </b-row>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="preview-management" v-show="managementViews.preview">
                        <div class="content-row">
                            <label class="preview-management-lbl "><span
                                    class="preview-management__title" v-html='getLabelForm("team_id")' ></span>
                                : <?php echo '{{modelView.team}}' ?> </label>
                        </div>
                        <div class="content-row">
                            <label class="preview-management-lbl "><span
                                    class="preview-management__title" v-html='getLabelForm("distance_id")' ></span>
                                : <?php echo '{{modelView.distance}}' ?> </label>
                        </div>

                        <div v-for="(p, index) in  modelView.people" class="preview-management__people">
                            <div class="content-row">
                                <span class="preview-management__title"><?php echo '{{p.one.label}}' ?></span>
                                <span><?php echo '{{p.one.value}}' ?></span>
                            </div>
                            <div class="content-row">
                                <span class="preview-management__title"><?php echo '{{p.eight.label}}' ?></span>
                                <span><?php echo '{{p.eight.value}}' ?></span>
                            </div>
                            <div class="content-row">
                                <span class="preview-management__title"><?php echo '{{p.nine.label}}' ?></span>
                                <span v-html="p.nine.value"></span>
                            </div>
                        </div>

                    </div>
                </b-form>


            </div>
            <div class="customer-msg-user">
                <?php echo "<span class=''>{{labelsConfig.msg.customers_user}}</span>"?>
            </div>

        </b-modal>


    </div>

</script>
