<script type="text/x-template" id="register-form-template">
    <div>

        <b-form id="LodgingForm" v-on:submit.prevent="_submitForm">




            <b-row>
                <b-col lg="12" class="manager-add-guests">
                    <b-alert v-model="!$v.model.attributes.people.required" variant="danger">
                        Debe Existir por lo menos una persona!
                    </b-alert>
                </b-col>


                <b-col lg="12" class="manager-add-guests">
                    {{--ITERACTION INIT PEOPLE--}}
                    <div v-if="getViewPeopleProcess()">
                        <div v-for="(v, index) in $v.model.attributes.people.$each.$iter">
                            <b-row class="content-badge-information-type-guest">

                                <b-col class="col-md-3 col-12" v-bind:id="getIdManagerGuest(index,v)+'-document_number'">

                                    <div class="form-group"
                                         :class="getClassErrorForm('document_number',v.document_number)">
                                        <label class="form__label "
                                               v-html='getLabelForm("document_number")'></label>
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
                                                :state="!getViewErrorForm('document_number',v.document_number)">
                                            <span v-if="getViewErrorForm('document_number',v.document_number)">
                                <?php echo "{{model.structure.document_number.required.msj}}" ?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col class="col-md-5 col-8" v-bind:id="getIdManagerGuest(index,v)+'-full_name'">
                                    <div class="form-group"
                                         :class="getClassErrorForm('full_name',v.full_name)">
                                        <label class="form__label" v-html='getLabelForm("full_name")'></label>
                                        <div class="content ">
                                            <input
                                                v-model.trim="v.full_name.$model"
                                                v-bind:id="getNameAttributePeople(index,'full_name')"
                                                v-bind:name="getNameAttributePeople(index,'full_name')"
                                                class="form-control m-input"
                                                @change="_setValueForm('full_name', $event.target.value,index,v.full_name)"
                                                v-focus-select
                                            >
                                        </div>
                                        <div class="content-message-errors ">
                                            <b-form-invalid-feedback
                                                :state="!getViewErrorForm('full_name',v.full_name)">
                                            <span v-if="getViewErrorForm('full_name',v.full_name)">
                                <?php echo "{{model.structure.last_name.required.msj}}" ?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>
                                <b-col class="col-md-2 col-4" v-bind:id="getIdManagerGuest(index,v)+'-age'">
                                    <div class="form-group"
                                         :class="getClassErrorForm('age',v.age)">
                                        <label class="form__label " v-html='getLabelForm("age")'></label>
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
                                            <b-form-invalid-feedback :state="!getViewErrorForm('age',v.age)">
                                            <span v-if="getViewErrorForm('age',v.age)">
                                <?php echo "{{model.structure.age.required.msj}}" ?>
                            </span>

                                            </b-form-invalid-feedback>
                                        </div>
                                    </div>
                                </b-col>

                                <div class="div-manager-process">
                                    <a @click="_removePeople(index,v)" class="btn btn--delete btn-xs"
                                       data-toggle="tooltip"
                                       data-placement="top" title="Eliminar"><i class="fa fa-trash"></i></a>
                                </div>
                            </b-row>

                        </div>
                    </div>
                </b-col>
            </b-row>
            <!-- ✅ Acciones fijas (abajo derecha) -->
            <div class="embark-actions" role="group" aria-label="Acciones de embarque">

                <button type="button"
                        class="embark-actions__btn embark-actions__btn--send"
                        :disabled="!validateForm()"
                        v-on:click="_saveModel()"

                >
                    <i class="fa fa-floppy-o embark-actions__icon" aria-hidden="true"></i>
                    <span class="embark-actions__text">Enviar Registro Embarque</span>
                </button>
                <button type="button"
                        class="embark-actions__btn embark-actions__btn--add"
                        @click="_addPeople()"
                        aria-label="Agregar huésped">
                    <i class="fa fa-plus embark-actions__icon" aria-hidden="true"></i>
                </button>
            </div>

        </b-form>

    </div>

</script>

<script type="text/x-template" id="points-sales-template">
    <div>

        <input id="action-users-listAllRoutes" type="hidden"
               value="{{route('listUsersRoutes',app()->getLocale())}}"/>
        <div id="management-take-part">
            <div v-if="configModalManagementFormEvent.viewAllow">

                <management-form-event-component
                    ref="refManagementFormEvent"
                    :params="configModalManagementFormEvent"

                ></management-form-event-component>
            </div>
        </div>
        <div id="management-take-part-details">
            <div v-if="configModalManagementFormEventDetails.viewAllow">

                <management-form-event-details-component
                    ref="refManagementFormEventDetails"
                    :params="configModalManagementFormEventDetails"

                ></management-form-event-details-component>
            </div>
        </div>
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

                <table id="points-sales-grid"
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


    </div>

</script>
