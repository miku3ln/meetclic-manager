<script type='text/x-template' id='mikrotik-dhcp-server-template'>
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
                    <table id="mikrotik-dhcp-server-grid"
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
                <b-form id="mikrotikDhcpServerForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <div class="row">
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

                                     :class="getClassErrorForm('mikrotik_type_conection_id_data',$v.model.attributes.mikrotik_type_conection_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("mikrotik_type_conection_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.mikrotik_type_conection_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('mikrotik_type_conection_id_data')"
                                               v-bind:name="getNameAttribute('mikrotik_type_conection_id_data')"
                                               @change="_setValueForm('mikrotik_type_conection_id_data', $v.model.attributes.mikrotik_type_conection_id_data.$model)"
                                        >
                                        <select id="mikrotik_type_conection_id_data"
                                                class="form-control m-select2 "
                                                v-initS2MikrotikTypeConection="{rowId:model.attributes.id,_managerS2MikrotikTypeConection:_managerS2MikrotikTypeConection}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.mikrotik_type_conection_id_data.$error">
      <span v-if="!$v.model.attributes.mikrotik_type_conection_id_data.required">
       <?php  echo "{{model.structure.mikrotik_type_conection_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
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

                        </div>
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('interface',$v.model.attributes.interface)">
                                    <label class="form__label " v-html='getLabelForm("interface")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.interface.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('interface')"
                                            v-bind:name="getNameAttribute('interface')"
                                            class="form-control m-input"
                                            @change="_setValueForm('interface', $v.model.attributes.interface.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.interface.$error">
      <span v-if="!$v.model.attributes.interface.required">
       <?php  echo "{{model.structure.interface.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.interface.maxLength">
       <?php  echo "{{model.structure.interface.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('addres_pool',$v.model.attributes.addres_pool)">
                                    <label class="form__label " v-html='getLabelForm("addres_pool")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.addres_pool.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('addres_pool')"
                                            v-bind:name="getNameAttribute('addres_pool')"
                                            class="form-control m-input"
                                            @change="_setValueForm('addres_pool', $v.model.attributes.addres_pool.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.addres_pool.$error">
      <span v-if="!$v.model.attributes.addres_pool.required">
       <?php  echo "{{model.structure.addres_pool.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.addres_pool.maxLength">
       <?php  echo "{{model.structure.addres_pool.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('address',$v.model.attributes.address)">
                                    <label class="form__label " v-html='getLabelForm("address")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.address.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('address')"
                                            v-bind:name="getNameAttribute('address')"
                                            class="form-control m-input"
                                            @change="_setValueForm('address', $v.model.attributes.address.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.address.$error">
      <span v-if="!$v.model.attributes.address.required">
       <?php  echo "{{model.structure.address.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.address.maxLength">
       <?php  echo "{{model.structure.address.maxLength.msj}}"?>
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

