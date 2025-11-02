<script type='text/x-template' id='mikrotik-type-conection-template'>
    <div>

        <div class='content-component'>


            <b-container class="container-manager-buttons">

                <div class="content-row-manager-buttons">
                    <button
                        v-if="!managerMenuConfig.view"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                        <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?></button>
                    <button v-if="showManager" type="button"
                            :disabled="!validateForm()"
                            class="btn btn-success "
                            v-on:click="_saveModel()">
                        <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?></button>

                    <div v-if="!showManager">
                        <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                            <menu-admin-grid
                                @input="_managerRowGrid($event)"
                                :manager-menu-config="managerMenuConfig">

                            </menu-admin-grid>


                        </div>
                    </div>
                </div>
            </b-container>

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="mikrotik-type-conection-grid"
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
            <div class="content-form" v-if="showManager">
                <b-form id="mikrotikTypeConectionForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('state',$v.model.attributes.state)">
                                    <label class="form__label " v-html='getLabelForm("state")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.state.$model"
                                                v-bind:id="getNameAttribute('state')"
                                                v-bind:name="getNameAttribute('state')"
                                                class="form-control m-input"
                                                @change="_setValueForm('state', $v.model.attributes.state.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.state.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php  echo "{{model.structure.state.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('user',$v.model.attributes.user)">
                                    <label class="form__label " v-html='getLabelForm("user")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.user.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('user')"
                                            v-bind:name="getNameAttribute('user')"
                                            class="form-control m-input"
                                            @change="_setValueForm('user', $v.model.attributes.user.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.user.$error">
      <span v-if="!$v.model.attributes.user.required">
       <?php  echo "{{model.structure.user.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.user.maxLength">
       <?php  echo "{{model.structure.user.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('password',$v.model.attributes.password)">
                                    <label class="form__label " v-html='getLabelForm("password")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.password.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('password')"
                                            v-bind:name="getNameAttribute('password')"
                                            class="form-control m-input"
                                            @change="_setValueForm('password', $v.model.attributes.password.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.password.$error">
      <span v-if="!$v.model.attributes.password.required">
       <?php  echo "{{model.structure.password.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.password.maxLength">
       <?php  echo "{{model.structure.password.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>


                        </b-row>
                        <b-row>

                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('name',$v.model.attributes.name)">
                                    <label class="form__label " v-html='getLabelForm("name")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.name.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('name')"
                                            v-bind:name="getNameAttribute('name')"
                                            class="form-control m-input"
                                            @change="_setValueForm('name', $v.model.attributes.name.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.name.$error">
      <span v-if="!$v.model.attributes.name.required">
       <?php  echo "{{model.structure.name.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.name.maxLength">
       <?php  echo "{{model.structure.name.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('ip_conection',$v.model.attributes.ip_conection)">
                                    <label class="form__label " v-html='getLabelForm("ip_conection")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.ip_conection.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('ip_conection')"
                                            v-bind:name="getNameAttribute('ip_conection')"
                                            class="form-control m-input"
                                            @change="_setValueForm('ip_conection', $v.model.attributes.ip_conection.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.ip_conection.$error">
      <span v-if="!$v.model.attributes.ip_conection.required">
       <?php  echo "{{model.structure.ip_conection.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.ip_conection.maxLength">
       <?php  echo "{{model.structure.ip_conection.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>


                        </b-row>

                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>

