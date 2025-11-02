<script type='text/x-template' id='product-measure-type-template'>
    <div>

        <div class='content-component'>


            <div v-if="configModalLanguageProductMeasureType.viewAllow">
                <language-product-measure-type-component
                    ref="refLanguageProductMeasureType"
                    :params="configModalLanguageProductMeasureType"
                >
                </language-product-measure-type-component>
            </div>
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
                        <?php echo '{{managerType==1?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?></button>

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

            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!showManager">
                    <table id="product-measure-type-grid"
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
                <b-form id="productMeasureTypeForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >

                        <b-row>
                            <b-col md="3">
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

                        </b-row>

                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('value',$v.model.attributes.value)">
                                    <label class="form__label " v-html='getLabelForm("value")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.value.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('value')"
                                            v-bind:name="getNameAttribute('value')"
                                            class="form-control m-input"
                                            @change="_setValueForm('value', $v.model.attributes.value.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.value.$error">
      <span v-if="!$v.model.attributes.value.required">
       <?php  echo "{{model.structure.value.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.value.maxLength">
       <?php  echo "{{model.structure.value.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="3">
                                <div class="form-group"

                                     :class="getClassErrorForm('abbreviation',$v.model.attributes.abbreviation)">
                                    <label class="form__label " v-html='getLabelForm("abbreviation")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.abbreviation.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('abbreviation')"
                                            v-bind:name="getNameAttribute('abbreviation')"
                                            class="form-control m-input"
                                            @change="_setValueForm('abbreviation', $v.model.attributes.abbreviation.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.abbreviation.$error">
      <span v-if="!$v.model.attributes.abbreviation.maxLength">

       <?php  echo "{{model.structure.abbreviation.maxLength.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.abbreviation.required">
       <?php  echo "{{model.structure.abbreviation.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="3">
                                <div class="form-group"

                                     :class="getClassErrorForm('prefix',$v.model.attributes.prefix)">
                                    <label class="form__label " v-html='getLabelForm("prefix")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.prefix.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('prefix')"
                                            v-bind:name="getNameAttribute('prefix')"
                                            class="form-control m-input"
                                            @change="_setValueForm('prefix', $v.model.attributes.prefix.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.prefix.$error">
      <span v-if="!$v.model.attributes.prefix.required">
       <?php  echo "{{model.structure.prefix.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.prefix.maxLength">
       <?php  echo "{{model.structure.prefix.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="2">
                                <div class="form-group"

                                     :class="getClassErrorForm('symbol',$v.model.attributes.symbol)">
                                    <label class="form__label " v-html='getLabelForm("symbol")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.symbol.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('symbol')"
                                            v-bind:name="getNameAttribute('symbol')"
                                            class="form-control m-input"
                                            @change="_setValueForm('symbol', $v.model.attributes.symbol.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.symbol.$error">
      <span v-if="!$v.model.attributes.symbol.maxLength">
       <?php  echo "{{model.structure.symbol.maxLength.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.symbol.required">
       <?php  echo "{{model.structure.symbol.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('unit',$v.model.attributes.unit)">
                                    <label class="form__label " v-html='getLabelForm("unit")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.unit.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('unit')"
                                            v-bind:name="getNameAttribute('unit')"
                                            class="form-control m-input"
                                            @change="_setValueForm('unit', $v.model.attributes.unit.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.unit.$error">

                                                                        <span v-if="!$v.model.attributes.unit.required">
       <?php  echo "{{model.structure.unit.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="3" v-if="$v.model.attributes.unit.$model==1">
                                <div class="form-group"

                                     :class="getClassErrorForm('number_of_units',$v.model.attributes.number_of_units)">
                                    <label
                                        class="form__label " v-html='getLabelForm("number_of_units")' ></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.number_of_units.$model"
                                            type="number"
                                            v-bind:id="getNameAttribute('number_of_units')"
                                            v-bind:name="getNameAttribute('number_of_units')"
                                            min="0" class="form-control m-input"
                                            @change="_setValueForm('number_of_units', $v.model.attributes.number_of_units.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.number_of_units.$error">

                                                                        <span v-if="!$v.model.attributes.number_of_units.required">
       <?php  echo "{{model.structure.number_of_units.required.msj}}"?>
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
    rows="10" class="form-control"
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

