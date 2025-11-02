<script type='text/x-template' id='product-service-template'>
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
                        <?php echo '{{managerType==1?labelsConfig.buttons.create:labelsConfig.buttons.update}}'?></button>

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
                    <table id="product-service-grid"
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
                <b-form id="productServiceForm" v-on:submit.prevent="_submitForm">


                    <b-container>
                        <input v-model="model.attributes.id" type="hidden"
                               v-bind:id="getNameAttribute('id')"
                               v-bind:name="getNameAttribute('id')"
                        >
                        <b-row>
                            <b-col md="3">
                                <div class="form-group"
                                     :class="getClassErrorForm('state',$v.model.attributes.state)">
                                    <label class="form__label " v-html='getLabelForm("state")'></label>
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
                            <b-col md="2">
                                <div class="form-group"

                                     :class="getClassErrorForm('view_online',$v.model.attributes.view_online)">
                                    <label class="form__label " v-html='getLabelForm("view_online")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.view_online.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('view_online')"
                                            v-bind:name="getNameAttribute('view_online')"
                                            class="form-control m-input"
                                            @change="_setValueForm('view_online', $v.model.attributes.view_online.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.view_online.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="6">
                                <label
                                    class="form__label " v-html='getLabelForm("source")'></label>
                                <div class=" content-box-image content-box-preview"
                                     id="manager-source"
                                     :class="getClassErrorForm('source',$v.model.attributes.source)">
                                    <img class="content-box-image__preview" id="preview-source">
                                    <div class="content-element-form">
                                        <input
                                            v-initEventUploadSource="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                            type="file" id="file-source"
                                            v-bind:name="getNameAttribute('source')">
                                    </div>
                                    <div class="progress-gallery-image not-view" id="progress-source">
                                        <div class="progress__bar"></div>
                                        <div class="progress__percent">0%</div>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.source.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="2">
                                <div class="form-group"

                                     :class="getClassErrorForm('has_tax',$v.model.attributes.has_tax)">
                                    <label class="form__label " v-html='getLabelForm("has_tax")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.has_tax.$model"
                                            type="checkbox"
                                            v-bind:id="getNameAttribute('has_tax')"
                                            v-bind:name="getNameAttribute('has_tax')"
                                            class="form-control m-input"
                                            @change="_setValueForm('has_tax', $v.model.attributes.has_tax.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.has_tax.$error">
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"
                                     :class="getClassErrorForm('sale_price',$v.model.attributes.sale_price)">
                                    <label class="form__label " v-html='getLabelForm("sale_price")'></label>
                                    <div class="content-element-form">
                                        <input
                                            type="number"
                                            min="0"
                                            class="form-control"
                                            v-model.trim="$v.model.attributes.sale_price.$model"
                                            v-bind:id="getNameAttribute('sale_price')"
                                            v-bind:name="getNameAttribute('sale_price')"
                                            @change="_setValueForm('sale_price', $v.model.attributes.sale_price.$model)"
                                            v-focus-select
                                        ></input>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.sale_price.$error">
      <span v-if="!$v.model.attributes.sale_price.required">
       <?php  echo "{{model.structure.sale_price.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('code',$v.model.attributes.code)">
                                    <label class="form__label " v-html='getLabelForm("code")'></label>
                                    <div class="content-element-form">
                                        <input
                                            v-model.trim="$v.model.attributes.code.$model"
                                            type="text"
                                            v-bind:id="getNameAttribute('code')"
                                            v-bind:name="getNameAttribute('code')"
                                            class="form-control m-input"
                                            @change="_setValueForm('code', $v.model.attributes.code.$model)"
                                            v-focus-select
                                        >
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.code.$error">
      <span v-if="!$v.model.attributes.code.required">
       <?php  echo "{{model.structure.code.required.msj}}"?>
      </span>
                                            <span v-if="!$v.model.attributes.code.maxLength">
       <?php  echo "{{model.structure.code.maxLength.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12">
                                <div class="form-group"
                                     :class="getClassErrorForm('name',$v.model.attributes.name)">
                                    <label class="form__label " v-html='getLabelForm("name")'></label>
                                    <div class="content-element-form">
                                        <input
                                            class="form-control"
                                            v-model.trim="$v.model.attributes.name.$model"
                                            v-bind:id="getNameAttribute('name')"
                                            v-bind:name="getNameAttribute('name')"
                                            @change="_setValueForm('name', $v.model.attributes.name.$model)"
                                            v-focus-select
                                        ></input>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.name.$error">
      <span v-if="!$v.model.attributes.name.required">
       <?php  echo "{{model.structure.name.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>


                        <b-row>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('product_trademark_id_data',$v.model.attributes.product_trademark_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("product_trademark_id_data")'></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.product_trademark_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('product_trademark_id_data')"
                                               v-bind:name="getNameAttribute('product_trademark_id_data')"
                                               @change="_setValueForm('product_trademark_id_data', $v.model.attributes.product_trademark_id_data.$model)"
                                        >
                                        <select id="product_trademark_id_data"
                                                class="form-control m-select2 "
                                                v-initS2ProductTrademark="{rowId:model.attributes.id,_managerS2ProductTrademark:_managerS2ProductTrademark}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_trademark_id_data.$error">
      <span v-if="!$v.model.attributes.product_trademark_id_data.required">
       <?php  echo "{{model.structure.product_trademark_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('product_category_id_data',$v.model.attributes.product_category_id_data)">
                                    <label
                                        class="form__label " v-html='getLabelForm("product_category_id_data")'></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.product_category_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('product_category_id_data')"
                                               v-bind:name="getNameAttribute('product_category_id_data')"
                                               @change="_setValueForm('product_category_id_data', $v.model.attributes.product_category_id_data.$model)"
                                        >
                                        <select id="product_category_id_data"
                                                class="form-control m-select2 "
                                                v-initS2ProductCategory="{rowId:model.attributes.id,_managerS2ProductCategory:_managerS2ProductCategory}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_category_id_data.$error">
      <span v-if="!$v.model.attributes.product_category_id_data.required">
       <?php  echo "{{model.structure.product_category_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                            <b-col md="4" v-if="model.attributes.product_category_id_data">
                                <div class="form-group"

                                     :class="getClassErrorForm('product_subcategory_id_data',$v.model.attributes.product_subcategory_id_data)">
                                    <label
                                        class="form__label "
                                        v-html='getLabelForm("product_subcategory_id_data")'></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.product_subcategory_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('product_subcategory_id_data')"
                                               v-bind:name="getNameAttribute('product_subcategory_id_data')"
                                               @change="_setValueForm('product_subcategory_id_data', $v.model.attributes.product_subcategory_id_data.$model)"
                                        >
                                        <select id="product_subcategory_id_data"
                                                class="form-control m-select2 "
                                                v-initS2ProductSubcategory="{rowId:model.attributes.id,_managerS2ProductSubcategory:_managerS2ProductSubcategory}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_subcategory_id_data.$error">
      <span v-if="!$v.model.attributes.product_subcategory_id_data.required">
       <?php  echo "{{model.structure.product_subcategory_id_data.required.msj}}"?>
      </span>
                                        </b-form-invalid-feedback>
                                    </div>
                                </div>

                            </b-col>
                        </b-row>
                        <b-row v-show="false">
                            <b-col md="4">
                                <div class="form-group"

                                     :class="getClassErrorForm('product_measure_type_id_data',$v.model.attributes.product_measure_type_id_data)">
                                    <label
                                        class="form__label "
                                        v-html='getLabelForm("product_measure_type_id_data")'></label>
                                    <div class="content-element-form">
                                        <input v-model="$v.model.attributes.product_measure_type_id_data.model"
                                               type="hidden"
                                               v-bind:id="getNameAttribute('product_measure_type_id_data')"
                                               v-bind:name="getNameAttribute('product_measure_type_id_data')"
                                               @change="_setValueForm('product_measure_type_id_data', $v.model.attributes.product_measure_type_id_data.$model)"
                                        >
                                        <select id="product_measure_type_id_data"
                                                class="form-control m-select2 "
                                                v-initS2ProductMeasureType="{rowId:model.attributes.id,_managerS2ProductMeasureType:_managerS2ProductMeasureType}"
                                        >
                                        </select>
                                    </div>
                                    <div class="content-message-errors">
                                        <b-form-invalid-feedback
                                            :state="!$v.model.attributes.product_measure_type_id_data.$error">
      <span v-if="!$v.model.attributes.product_measure_type_id_data.required">
       <?php  echo "{{model.structure.product_measure_type_id_data.required.msj}}"?>
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
                                    <label class="form__label " v-html='getLabelForm("description")'></label>
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

