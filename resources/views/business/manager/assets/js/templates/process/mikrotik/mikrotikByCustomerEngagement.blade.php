<script type='text/x-template' id='mikrotik-by-customer-engagement-template'>
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
                    <table id="mikrotik-by-customer-engagement-grid"
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
                <b-form id="mikrotikByCustomerEngagementForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('customer_id_data',$v.model.attributes.customer_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("customer_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.customer_id_data.model" type="hidden"
                                               v-bind:id="getNameAttribute('customer_id_data')"
                                               v-bind:name="getNameAttribute('customer_id_data')"
                                               @change="_setValueForm('customer_id_data', $v.model.attributes.customer_id_data.$model)"
                                        >
                                        <select id="customer_id_data"
                                                class="form-control m-select2 "
                                                v-initS2Customer="{rowId:model.attributes.id,_managerS2Customer:_managerS2Customer}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.customer_id_data.$error">
      <span v-if="!$v.model.attributes.customer_id_data.required">
       <?php  echo "{{model.structure.customer_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="12">
                                <div class="form-group"

                                     :class="getClassErrorForm('address',$v.model.attributes.address)">
                                    <label class="form__label " v-html='getLabelForm("address")' ></label>
                                    <div class="content-element-form">
<textarea
    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.address.$model"
    v-bind:id="getNameAttribute('address')"
    v-bind:name="getNameAttribute('address')"
    @change="_setValueForm('address', $v.model.attributes.address.$model)"
    v-focus-select
></textarea>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.address.$error">
      <span v-if="!$v.model.attributes.address.required">
       <?php  echo "{{model.structure.address.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>


                        </b-row>
                        <div class="row">
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('engagement_number',$v.model.attributes.engagement_number)">
                                    <label
                                        class="form__label " v-html='getLabelForm("status")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.engagement_number.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('engagement_number')"
                                            v-bind:name="getNameAttribute('engagement_number')"
                                            min="0" class="form-control m-input"
                                            @change="_setValueForm('engagement_number', $v.model.attributes.engagement_number.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.engagement_number.$error">
      <span v-if="!$v.model.attributes.engagement_number.required">
       <?php  echo "{{model.structure.engagement_number.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('invoice_sale_id_data',$v.model.attributes.invoice_sale_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("invoice_sale_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.invoice_sale_id_data.model" type="hidden"
                                               v-bind:id="getNameAttribute('invoice_sale_id_data')"
                                               v-bind:name="getNameAttribute('invoice_sale_id_data')"
                                               @change="_setValueForm('invoice_sale_id_data', $v.model.attributes.invoice_sale_id_data.$model)"
                                        >
                                        <select id="invoice_sale_id_data"
                                                class="form-control m-select2 "
                                                v-initS2InvoiceSale="{rowId:model.attributes.id,_managerS2InvoiceSale:_managerS2InvoiceSale}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.invoice_sale_id_data.$error">
      <span v-if="!$v.model.attributes.invoice_sale_id_data.required">
       <?php  echo "{{model.structure.invoice_sale_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('type_ethernet',$v.model.attributes.type_ethernet)">
                                    <label class="form__label " v-html='getLabelForm("type_ethernet")' ></label>
                                    <div class="content-element-form">


                                        <select v-model.trim="$v.model.attributes.type_ethernet.$model"
                                                v-bind:id="getNameAttribute('type_ethernet')"
                                                v-bind:name="getNameAttribute('type_ethernet')"
                                                class="form-control m-input"
                                                @change="_setValueForm('type_ethernet', $v.model.attributes.type_ethernet.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.type_ethernet.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>

                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.type_ethernet.$error">
      <span v-if="!$v.model.attributes.type_ethernet.required">
       <?php  echo "{{model.structure.type_ethernet.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('mikrotik_rate_limit_id_data',$v.model.attributes.mikrotik_rate_limit_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("mikrotik_rate_limit_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.mikrotik_rate_limit_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('mikrotik_rate_limit_id_data')"
                                               v-bind:name="getNameAttribute('mikrotik_rate_limit_id_data')"
                                               @change="_setValueForm('mikrotik_rate_limit_id_data', $v.model.attributes.mikrotik_rate_limit_id_data.$model)"
                                        >
                                        <select id="mikrotik_rate_limit_id_data"
                                                class="form-control m-select2 "
                                                v-initS2MikrotikRateLimit="{rowId:model.attributes.id,_managerS2MikrotikRateLimit:_managerS2MikrotikRateLimit}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.mikrotik_rate_limit_id_data.$error">
      <span v-if="!$v.model.attributes.mikrotik_rate_limit_id_data.required">
       <?php  echo "{{model.structure.mikrotik_rate_limit_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('assigned_ip',$v.model.attributes.assigned_ip)">
                                    <label class="form__label " v-html='getLabelForm("assigned_ip")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.assigned_ip.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('assigned_ip')"
                                            v-bind:name="getNameAttribute('assigned_ip')"
                                            class="form-control m-input"
                                            @change="_setValueForm('assigned_ip', $v.model.attributes.assigned_ip.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.assigned_ip.$error">
      <span v-if="!$v.model.attributes.assigned_ip.required">
       <?php  echo "{{model.structure.assigned_ip.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.assigned_ip.maxLength">
       <?php  echo "{{model.structure.assigned_ip.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('mac_computer',$v.model.attributes.mac_computer)">
                                    <label class="form__label " v-html='getLabelForm("mac_computer")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.mac_computer.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('mac_computer')"
                                            v-bind:name="getNameAttribute('mac_computer')"
                                            class="form-control m-input"
                                            @change="_setValueForm('mac_computer', $v.model.attributes.mac_computer.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.mac_computer.$error">
      <span v-if="!$v.model.attributes.mac_computer.required">
       <?php  echo "{{model.structure.mac_computer.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.mac_computer.maxLength">
       <?php  echo "{{model.structure.mac_computer.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('mikrotik_dhcp_server_id_data',$v.model.attributes.mikrotik_dhcp_server_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("mikrotik_dhcp_server_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.mikrotik_dhcp_server_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('mikrotik_dhcp_server_id_data')"
                                               v-bind:name="getNameAttribute('mikrotik_dhcp_server_id_data')"
                                               @change="_setValueForm('mikrotik_dhcp_server_id_data', $v.model.attributes.mikrotik_dhcp_server_id_data.$model)"
                                        >
                                        <select id="mikrotik_dhcp_server_id_data"
                                                class="form-control m-select2 "
                                                v-initS2MikrotikDhcpServer="{rowId:model.attributes.id,_managerS2MikrotikDhcpServer:_managerS2MikrotikDhcpServer}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.mikrotik_dhcp_server_id_data.$error">
      <span v-if="!$v.model.attributes.mikrotik_dhcp_server_id_data.required">
       <?php  echo "{{model.structure.mikrotik_dhcp_server_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('computer_state',$v.model.attributes.computer_state)">
                                    <label
                                        class="form__label " v-html='getLabelForm("computer_state")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.computer_state.$model"
                                                v-bind:id="getNameAttribute('computer_state')"
                                                v-bind:name="getNameAttribute('computer_state')"
                                                class="form-control m-input"
                                                @change="_setValueForm('computer_state', $v.model.attributes.computer_state.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.computer_state.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.computer_state.$error">
      <span v-if="!$v.model.attributes.computer_state.required">
       <?php  echo "{{model.structure.computer_state.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>

                        </div>
                        <div class="row" v-if="model.attributes.type_ethernet==0">
                           <div class="col-md-12">
                               <h2>Equipo de Recepcion de Internet</h2>
                           </div>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('antenna_assigned_ip',$v.model.attributes.antenna_assigned_ip)">
                                    <label
                                        class="form__label " v-html='getLabelForm("antenna_assigned_ip")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.antenna_assigned_ip.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('antenna_assigned_ip')"
                                            v-bind:name="getNameAttribute('antenna_assigned_ip')"
                                            class="form-control m-input"
                                            @change="_setValueForm('antenna_assigned_ip', $v.model.attributes.antenna_assigned_ip.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.antenna_assigned_ip.$error">
      <span v-if="!$v.model.attributes.antenna_assigned_ip.maxLength">
       <?php  echo "{{model.structure.antenna_assigned_ip.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('antenna_mac_computer',$v.model.attributes.antenna_mac_computer)">
                                    <label
                                        class="form__label " v-html='getLabelForm("antenna_mac_computer")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.antenna_mac_computer.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('antenna_mac_computer')"
                                            v-bind:name="getNameAttribute('antenna_mac_computer')"
                                            class="form-control m-input"
                                            @change="_setValueForm('antenna_mac_computer', $v.model.attributes.antenna_mac_computer.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.antenna_mac_computer.$error">
      <span v-if="!$v.model.attributes.antenna_mac_computer.maxLength">
       <?php  echo "{{model.structure.antenna_mac_computer.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('antenna_mikrotik_dhcp_server_id_data',$v.model.attributes.antenna_mikrotik_dhcp_server_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("antenna_mikrotik_dhcp_server_id_data")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model="$v.model.attributes.antenna_mikrotik_dhcp_server_id_data.model"
                                            type="hidden"
                                            v-bind:id="getNameAttribute('antenna_mikrotik_dhcp_server_id_data')"
                                            v-bind:name="getNameAttribute('antenna_mikrotik_dhcp_server_id_data')"
                                            @change="_setValueForm('antenna_mikrotik_dhcp_server_id_data', $v.model.attributes.antenna_mikrotik_dhcp_server_id_data.$model)"
                                        >
                                        <select id="antenna_mikrotik_dhcp_server_id_data"
                                                class="form-control m-select2 "
                                                v-initS2AntennaMikrotikDhcpServer="{rowId:model.attributes.id,_managerS2AntennaMikrotikDhcpServer:_managerS2AntennaMikrotikDhcpServer}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.antenna_mikrotik_dhcp_server_id_data.$error">
      <span v-if="!$v.model.attributes.antenna_mikrotik_dhcp_server_id_data.required">
       <?php  echo "{{model.structure.antenna_mikrotik_dhcp_server_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="6">
                                <div class="form-group"

                                     :class="getClassErrorForm('antenna_state',$v.model.attributes.antenna_state)">
                                    <label
                                        class="form__label " v-html='getLabelForm("antenna_state")' ></label>
                                    <div class="content-element-form">
                                        <select v-model.trim="$v.model.attributes.antenna_state.$model"
                                                v-bind:id="getNameAttribute('antenna_state')"
                                                v-bind:name="getNameAttribute('antenna_state')"
                                                class="form-control m-input"
                                                @change="_setValueForm('antenna_state', $v.model.attributes.antenna_state.$model)"
                                        >
                                            <option v-for="(row,index) in model.structure.antenna_state.options"
                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.antenna_state.$error">
      <span v-if="!$v.model.attributes.antenna_state.required">
       <?php  echo "{{model.structure.antenna_state.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>


                        </div>
                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>

