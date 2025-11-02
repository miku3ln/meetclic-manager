<script type='text/x-template' id='business-counter-custom-by-data-template'>
    <div>

        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-business-counter-custom-by-data"
                ref="refBusinessCounterCustomByDataModal"
                size="xl"
            <?php  echo '@show="_showModal"' ?>    <?php  echo '@hidden="_hideModal"' ?>    <?php  echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons">
                        <button
                            v-if="!managerMenuConfig.view"
                            type="button"
                            class="btn "
                            :class="{'btn-success':!showManager,'btn-danger':showManager}"
                            v-on:click="_viewManager(showManager?2:1)">
                            <?php  echo "{{showManager?'Regresar':'Nuevo'}}" ?>    </button>
                        <button v-if="showManager" type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}'?>    </button>

                        <div v-if="!showManager">
                            <div class="content-manager-buttons-grid ready" v-if="managerMenuConfig.view">
                                <menu-admin-grid
                                    @input="_managerRowGrid($event)"
                                    :manager-menu-config="managerMenuConfig" >

                                </menu-admin-grid>

                            </div>
                        </div>
                    </div>
                </b-container>

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="BusinessCounterCustomByDataForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"
                                             :class="getClassErrorForm('status',$v.model.attributes.status)">
                                            <label
                                                class="form__label " v-html='getLabelForm("status")' ></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes.status.$model"
                                                        v-bind:id="getNameAttribute('status')"
                                                        v-bind:name="getNameAttribute('status')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('status', $v.model.attributes.status.$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure.status.options"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.status.$error">
      <span v-if="!$v.model.attributes.status.required">
       <?php  echo "{{model.structure.status.required.msj}}"?>
      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>

                                    <b-col md="2">
                                        <div class="form-group"
                                             :class="getClassErrorForm('count',$v.model.attributes.count)">
                                            <label class="form__label " v-html='getLabelForm("count")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.count.$model"
                                                    type="number"
                                                    v-bind:id="getNameAttribute('count')"
                                                    v-bind:name="getNameAttribute('count')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('count', $v.model.attributes.count.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.count.$error">
      <span v-if="!$v.model.attributes.count.required">
       <?php  echo "{{model.structure.count.required.msj}}"?>
      </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="2">
                                        <div class="form-group"
                                             :class="getClassErrorForm('count_symbol',$v.model.attributes.count_symbol)">
                                            <label class="form__label " v-html='getLabelForm("count_symbol")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.count_symbol.$model"
                                                    type="text"
                                                    v-bind:id="getNameAttribute('count_symbol')"
                                                    v-bind:name="getNameAttribute('count_symbol')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('count_symbol', $v.model.attributes.count_symbol.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.count_symbol.$error">
      <span v-if="!$v.model.attributes.count_symbol.required">
       <?php  echo "{{model.structure.count_symbol.required.msj}}"?>
      </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                    <b-col md="2">
                                        <div class="form-group"
                                             :class="getClassErrorForm('count_percentage',$v.model.attributes.count_percentage)">
                                            <label class="form__label " v-html='getLabelForm("count_percentage")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    v-model.trim="$v.model.attributes.count_percentage.$model"
                                                    type="number"
                                                    v-bind:id="getNameAttribute('count_percentage')"
                                                    v-bind:name="getNameAttribute('count_percentage')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('count_percentage', $v.model.attributes.count_percentage.$model)"
                                                    v-focus-select
                                                >
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.count_percentage.$error">
      <span v-if="!$v.model.attributes.count_percentage.required">
       <?php  echo "{{model.structure.count_percentage.required.msj}}"?>
      </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>

                                <b-row>

                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('title',$v.model.attributes.title)">
                                            <label class="form__label " v-html='getLabelForm("title")' ></label>
                                            <div class="content-element-form">
                                                <input
                                                    style="display:none;"
                                                    v-model.trim="$v.model.attributes.title.$model"
                                                    type="text"
                                                    v-bind:id="getNameAttribute('title')"
                                                    v-bind:name="getNameAttribute('title')"
                                                    class="form-control m-input"
                                                    @change="_setValueForm('title', $v.model.attributes.title.$model)"
                                                    v-focus-select
                                                >
                                                <div class="title form-control" id="title"
                                                     v-initSummerNote="{initMethod:_initSummerNote}"></div>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.title.$error">
      <span v-if="!$v.model.attributes.title.required">
       <?php  echo "{{model.structure.title.required.msj}}"?>
      </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('description',$v.model.attributes.description)">
                                            <label
                                                class="form__label " v-html='getLabelForm("description")' ></label>
                                            <div class="content-element-form">
<textarea
    style="display: none;"
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
                                                <div class="description form-control" id="description"
                                                     v-initSummerNote="{initMethod:_initSummerNote}"></div>


                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.description.$error">
      <span v-if="!$v.model.attributes.description.required">
       <?php  echo "{{model.structure.description.required.msj}}"?>
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

                <div class="content-manager-grid">

                    <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                        <table id="business-counter-custom-by-data-grid"
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
            </b-modal>


        </div>
    </div>
</script>

