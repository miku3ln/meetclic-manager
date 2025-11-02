<script type='text/x-template' id='odontogram-by-patient-template'>
    <div>

        <div class='content-component'>


            <b-container class="container-manager-buttons-process">

                <div class="content-row-manager-buttons-process">
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
                    <table id="odontogram-by-patient-grid"
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
                <b-form id="odontogramByPatientForm" v-on:submit.prevent="_submitFormPopover">
                    <b-popover v-if="popoverConfigForm.popoverShow"
                               id="manager-information-social-network"
                               :target="popoverConfigForm.target"
                               :show.sync="popoverConfigForm.popoverShow"
                               placement="auto"
                               container="information-social-network"
                               ref="refPopoverInformationSocialNetwork"

                    <?php  echo '  @show="_showPopover"      @shown="_shownPopover"     @hidden="_closePopover"'?>
                    >
                        <template v-slot:title>
                            <b-button v-if="popoverConfigForm.piecesSelect.model==null" @click="closePopoverButton()"
                                      class="close" aria-label="Close">
                                <span class="d-inline-block" aria-hidden="true">&times;</span>
                            </b-button>

                            <?php echo '{{popoverConfigForm.title}} <span class="badge badge--size-large badge-info ">{{popoverConfigForm.pieces.count}}</span>'?>

                            <select v-if="popoverConfigForm.pieces.count"
                                    v-model.trim="popoverConfigForm.piecesSelect.model"
                                    id="piecesSelect"
                                    name="piecesSelect"
                                    class="form-control m-input"
                                    @change="_setValueFormItemsPiecesSelect(popoverConfigForm.piecesSelect.model)"
                            >
                                <option v-for="(row,index) in popoverConfigForm.piecesSelect.options"
                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                </option>
                            </select>
                        </template>

                        <div>
                            <div v-if="popoverConfigForm.piecesSelect.model==null" class="management-create">
                                <b-row>
                                    <b-col md="12">
                                        <div class="form-group"

                                             :class="getClassErrorForm('description',popoverConfigForm.v.reference_piece_id)">
                                            <label
                                                class="form__label "><?php echo '{{model.structure.items.reference_piece_id.label}}{{model.structure.items.reference_piece_id.required?"*":""}}'?></label>

                                            <div class="content-element-form">

                                                <select id="reference_piece_id"
                                                        class="form-control m-select2 "
                                                        v-init-select2="{initMethod:initS2ReferencePiece,model:popoverConfigForm.v}"
                                                >
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!popoverConfigForm.v.reference_piece_id.$error">
      <span v-if="!popoverConfigForm.v.reference_piece_id.required">
        <?php  echo "{{model.structure.items.reference_piece_id.required.msj}}"?>

      </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>

                                    <b-col md="12">
                                        <div class="form-group"
                                             :class="getClassErrorForm('description',popoverConfigForm.v.description)">
                                            <label
                                                class="form__label "><?php echo '{{model.structure.items.description.label}}{{model.structure.items.description.required?"*":""}}'?></label>
                                            <div class="content-element-form">
                        <textarea
                            v-model.trim="popoverConfigForm.v.description.$model"
                            v-bind:id="model.structure.items.description.id"
                            v-bind:name="model.structure.items.description.id"
                            class="form-control m-input"
                            v-focus-select
                        >
                        </textarea>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!popoverConfigForm.v.description.$error">
      <span v-if="!popoverConfigForm.v.description.required">
       <?php  echo "{{model.structure.items.description.required.msj}}"?>
      </span>

                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>

                            </div>


                            <div v-else>
                                <span>Eliminar Pieza Agregada</span>

                            </div>


                            <b-button v-if="popoverConfigForm.piecesSelect.model"
                                      @click="_deleteFormPopoverItem(popoverConfigForm.piecesSelect.model)" size="sm"
                                      variant="danger">Eliminar
                            </b-button>
                            <b-button v-if="popoverConfigForm.piecesSelect.model==null"
                                      @click="_addModelPopover(popoverConfigForm)" size="sm"
                                      :disabled="!validateFormPopover(popoverConfigForm)"
                                      variant="primary"><?php echo "{{popoverConfigForm.buttons.title}}"?></b-button>

                        </div>
                    </b-popover>


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('status',$v.model.attributes.status)">
                                    <label class="form__label " v-html='getLabelForm("status")' ></label>
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

                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('date',$v.model.attributes.date)">
                                    <label class="form__label " v-html='getLabelForm("date")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.date.$model"
                                            v-bind:id="getNameAttribute('date')"
                                            v-bind:name="getNameAttribute('date')"
                                            class="form-control m-input"
                                            @change="_setValueForm('date', $v.model.attributes.date.$model)"
                                            type="date"
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.date.$error">
      <span v-if="!$v.model.attributes.date.required">
       <?php  echo "{{model.structure.date.required.msj}}"?>
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
                                    <label class="form__label " v-html='getLabelForm("description")' ></label>
                                    <div class="content-element-form">
<textarea
    rows="2" class="form-control"
    v-model.trim="$v.model.attributes.description.$model"
    v-bind:id="getNameAttribute('description')"
    v-bind:name="getNameAttribute('description')"
    @change="_setValueForm('description', $v.model.attributes.description.$model)"
    v-focus-select
></textarea>
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

                        <b-row>
                            <div v-show="!initOdontogram" class="loading-odontogram">
                                Cargando Odontograma.......
                            </div>
                            <div v-show="initOdontogram" class="content-render-odontogram "
                                 v-init-odontogram="{model:model,initMethod:initSvg}">

                                <div id="content-render-data-odontogram-superior">

                                </div>
                                <div id="content-render-data-odontogram-inferior">
                                </div>
                                @if(empty($dataManagerPage["odontogramConfiguration"]))
                                    <h1>Leyendas no configuradas</h1>

                                @endif
                                @if(!empty($dataManagerPage["odontogramConfiguration"]))
                                    <div class="content-legend">

                                        @foreach($dataManagerPage["odontogramConfiguration"] as $legend)
                                            <div class="content-legend__item">
                                                <span class="content-legend__item-bullet"
                                                      style="background-color:{{$legend->color}}; "></span>
                                                <span class="content-legend__item-text">{{$legend->name}}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </b-row>
                    </b-container>

                </b-form>

            </div>


        </div>
    </div>
</script>

