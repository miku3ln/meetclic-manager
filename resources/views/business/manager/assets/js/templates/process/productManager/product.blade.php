<script type="text/x-template" id="product_parent-template">
    <div>
        <b-form id="productForm" v-on:submit.prevent="_submitForm"
        >
            <b-container v-if="allowForm">
                <input v-model="model.attributes.id" type="hidden"
                       v-bind:id="getNameAttribute('id')"
                       v-bind:name="getNameAttribute('id')"
                >
                <b-row>
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('state',$v.model.attributes.state)">
                            <label class="form__label "
                                   v-html='getLabelForm("state")'></label>
                            <div class="content-element-form">
                                <select
                                    v-model.trim="$v.model.attributes.state.$model"
                                    v-bind:id="getNameAttribute('state')"
                                    v-bind:name="getNameAttribute('state')"
                                    class="form-control m-input form-select"
                                    @change="_setValueForm('state', $v.model.attributes.state.$model)"
                                >
                                    <option
                                        v-for="(row,index) in model.structure.state.options"
                                        v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php echo "{{model.structure.state.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('tax_id_data',$v.model.attributes.tax_id_data)">
                            <label class="form__label "
                                   v-html='getLabelForm("tax_id_data")'></label>
                            <div class="content-element-form">
                                <select
                                    v-model.trim="$v.model.attributes.tax_id_data.$model"
                                    v-bind:id="getNameAttribute('tax_id_data')"
                                    v-bind:name="getNameAttribute('tax_id_data')"
                                    class="form-control m-input form-select"
                                    @change="_setValueForm('tax_id_data', $v.model.attributes.tax_id_data.$model)"
                                >
                                    <option
                                        v-for="(row,index) in model.structure.tax_id_data.options"
                                        v-bind:value="row.id"><?php echo '{{row.value}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php echo "{{model.structure.state.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="2" class="not-view">
                        <div class="form-group"

                             :class="getClassErrorForm('view_online',$v.model.attributes.view_online)">
                            <label class="form__label "
                                   v-html='getLabelForm("view_online")'></label>
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
                    <b-col md="6" class="not-view">
                        <label
                            class="form__label "
                            v-html='getLabelForm("source")'></label>
                        <div class=" content-box-image content-box-preview"
                             id="manager-source"
                             :class="getClassErrorForm('source',$v.model.attributes.source)">
                            <img class="content-box-image__preview"
                                 id="preview-source">
                            <div class="content-element-form">
                                <input
                                    v-initEventUploadSource="{initMethod:_managerEventsUpload,modelCurrent: this.model,paramsInit:getAttributesManagerUpload({nameField:'source',modelCurrent: this.model})}"
                                    type="file" id="file-source"
                                    v-bind:name="getNameAttribute('source')">
                            </div>
                            <div class="progress-gallery-image not-view"
                                 id="progress-source">
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

                    <b-col md="4">
                        <div class="form-group"

                             :class="getClassErrorForm('code',$v.model.attributes.code)">
                            <label class="form__label "
                                   v-html='getLabelForm("code")'></label>
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
       <?php echo "{{model.structure.code.required.msj}}" ?>
      </span>
                                    <span
                                        v-if="!$v.model.attributes.code.maxLength">
       <?php echo "{{model.structure.code.maxLength.msj}}" ?>
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
                            <label class="form__label "
                                   v-html='getLabelForm("name")'></label>
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
       <?php echo "{{model.structure.name.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>


                <b-row>
                    <b-col md="4" class="not-view">
                        <div class="form-group"

                             :class="getClassErrorForm('product_trademark_id_data',$v.model.attributes.product_trademark_id_data)">
                            <label
                                class="form__label "
                                v-html='getLabelForm("product_trademark_id_data")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.product_trademark_id_data.model"
                                    type="hidden"
                                    v-bind:id="getNameAttribute('product_trademark_id_data')"
                                    v-bind:name="getNameAttribute('product_trademark_id_data')"
                                    @change="_setValueForm('product_trademark_id_data', $v.model.attributes.product_trademark_id_data.$model)"
                                >
                                <select id="product_trademark_id_data"
                                        class="form-control m-select2 form-select"
                                        v-initS2ProductTrademark="{rowId:model.attributes.id,_managerS2ProductTrademark:_managerS2ProductTrademark}"
                                >
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.product_trademark_id_data.$error">
      <span v-if="!$v.model.attributes.product_trademark_id_data.required">
       <?php echo "{{model.structure.product_trademark_id_data.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="4">
                        <div class="form-group"

                             :class="getClassErrorForm('product_category_id_data',$v.model.attributes.product_category_id_data)">
                            <label
                                class="form__label "
                                v-html='getLabelForm("product_category_id_data")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.product_category_id_data.model"
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
       <?php echo "{{model.structure.product_category_id_data.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="4"
                           v-if="model.attributes.product_category_id_data">
                        <div class="form-group"

                             :class="getClassErrorForm('product_subcategory_id_data',$v.model.attributes.product_subcategory_id_data)">
                            <label
                                class="form__label "
                                v-html='getLabelForm("product_subcategory_id_data")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.product_subcategory_id_data.model"
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
       <?php echo "{{model.structure.product_subcategory_id_data.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>
                <b-row>
                    <b-col md="4">
                        <div class="form-group"

                             :class="getClassErrorForm('product_measure_type_id_data',$v.model.attributes.product_measure_type_id_data)">
                            <label
                                class="form__label "
                                v-html='getLabelForm("product_measure_type_id_data")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.product_measure_type_id_data.model"
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
       <?php echo "{{model.structure.product_measure_type_id_data.required.msj}}" ?>
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
                            <label class="form__label "
                                   v-html='getLabelForm("description")'></label>
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
                <div class="head-info not-view">

                    <h1 class="head-info__title"> <?php echo "{{configProcess.variants.title}}" ?></h1>
                    <span
                        class="head-info__msg"> <?php echo "{{configProcess.variants.msg}}" ?></span>
                </div>
                <b-row class="not-view">
                    <b-col md="4">
                        <div class="form-group"

                             :class="getClassErrorForm('product_by_sizes_data',$v.model.attributes.product_by_sizes_data)">
                            <label
                                class="form__label "
                                v-html='getLabelForm("product_by_sizes_data")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.product_by_sizes_data.model"
                                    type="hidden"
                                    v-bind:id="getNameAttribute('product_by_sizes_data')"
                                    v-bind:name="getNameAttribute('product_by_sizes_data')"
                                    @change="_setValueForm('product_by_sizes_data', $v.model.attributes.product_by_sizes_data.$model)"
                                >
                                <select id="product_by_sizes_data"
                                        class="form-control m-select2 "
                                        v-initS2="{rowId:model.attributes.id,nameMethod:_managerS2Sizes}"
                                >
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.product_by_sizes_data.$error">
      <span v-if="!$v.model.attributes.product_by_sizes_data.required">
       <?php echo "{{model.structure.product_by_sizes_data.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="4">
                        <div class="form-group"

                             :class="getClassErrorForm('product_by_color_data',$v.model.attributes.product_by_color_data)">
                            <label
                                class="form__label "
                                v-html='getLabelForm("product_by_color_data")'></label>
                            <div class="content-element-form">
                                <input
                                    v-model="$v.model.attributes.product_by_color_data.model"
                                    type="hidden"
                                    v-bind:id="getNameAttribute('product_by_color_data')"
                                    v-bind:name="getNameAttribute('product_by_color_data')"
                                    @change="_setValueForm('product_by_color_data', $v.model.attributes.product_by_color_data.$model)"
                                >
                                <select id="product_by_color_data"
                                        class="form-control m-select2 "
                                        v-initS2="{rowId:model.attributes.id,nameMethod:_managerS2Colors}"
                                >
                                </select>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.product_by_color_data.$error">
      <span v-if="!$v.model.attributes.product_by_color_data.required">
       <?php echo "{{model.structure.product_by_color_data.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>
                <div class="head-info not-view">

                    <h1 class="head-info__title"> <?php echo "{{configProcess.shipping.title}}" ?></h1>
                    <span
                        class="head-info__msg"> <?php echo "{{configProcess.shipping.msg}}" ?></span>
                </div>
                <b-row class="not-view">
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('height',$v.model.attributes.height)">
                            <label class="form__label "
                                   v-html='getLabelForm("height")'></label>
                            <div class="content-element-form">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model.trim="$v.model.attributes.height.$model"
                                    v-bind:id="getNameAttribute('height')"
                                    v-bind:name="getNameAttribute('height')"
                                    @change="_setValueForm('height', $v.model.attributes.height.$model)"
                                    v-focus-select
                                ></input>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.height.$error">
      <span v-if="!$v.model.attributes.height.required">
       <?php echo "{{model.structure.height.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('length',$v.model.attributes.length)">
                            <label class="form__label "
                                   v-html='getLabelForm("length")'></label>
                            <div class="content-element-form">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model.trim="$v.model.attributes.length.$model"
                                    v-bind:id="getNameAttribute('length')"
                                    v-bind:name="getNameAttribute('length')"
                                    @change="_setValueForm('length', $v.model.attributes.length.$model)"
                                    v-focus-select
                                ></input>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.length.$error">
      <span v-if="!$v.model.attributes.length.required">
       <?php echo "{{model.structure.length.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('width',$v.model.attributes.width)">
                            <label class="form__label "
                                   v-html='getLabelForm("width")'></label>
                            <div class="content-element-form">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model.trim="$v.model.attributes.width.$model"
                                    v-bind:id="getNameAttribute('width')"
                                    v-bind:name="getNameAttribute('width')"
                                    @change="_setValueForm('width', $v.model.attributes.width.$model)"
                                    v-focus-select
                                ></input>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.width.$error">
      <span v-if="!$v.model.attributes.width.required">
       <?php echo "{{model.structure.width.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                    <b-col md="3">
                        <div class="form-group"
                             :class="getClassErrorForm('weight',$v.model.attributes.weight)">
                            <label class="form__label "
                                   v-html='getLabelForm("weight")'></label>
                            <div class="content-element-form">
                                <input
                                    type="number"
                                    min="0"
                                    class="form-control"
                                    v-model.trim="$v.model.attributes.weight.$model"
                                    v-bind:id="getNameAttribute('weight')"
                                    v-bind:name="getNameAttribute('weight')"
                                    @change="_setValueForm('weight', $v.model.attributes.weight.$model)"
                                    v-focus-select
                                ></input>
                            </div>
                            <div class="content-message-errors">
                                <b-form-invalid-feedback
                                    :state="!$v.model.attributes.weight.$error">
      <span v-if="!$v.model.attributes.weight.required">
       <?php echo "{{model.structure.weight.required.msj}}" ?>
      </span>
                                </b-form-invalid-feedback>
                            </div>
                        </div>

                    </b-col>
                </b-row>
            </b-container>

        </b-form>


    </div>
</script>

<div class="modal fade" id="modal-delete-product_parent_by_prices" tabindex="-1" aria-labelledby="miModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-delete-product_parent_by_prices__title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-delete-product_parent_by_prices__body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-delete-product_parent_by_prices__btn-close"
                        data-bs-dismiss="modal">

                </button>
                <button type="button"
                        class="btn btn-primary modal-delete-product_parent_by_prices__btn-accept"></button>
            </div>
        </div>
    </div>
</div>
<script type="text/x-template" id="product_parent_by_prices-template">
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title not-view">Table
                            head
                            options</h4>
                        <p class="sub-header not-view">
                            Use one of two modifier classes to
                            make <code>&lt;thead&gt;</code>s
                            appear light
                            or dark gray.
                        </p>
                        <a class="link-add-manager link-add-manager--fixed"
                           v-on:click="onAddData()"
                        >
                            <i class="fas fa-plus-square"></i>
                            <?php echo '{{params.managerSteps.two.footer.buttonsManager.threeListPrice.title}}' ?>
                        </a>
                        <b-form id="ProductParentByPrices" v-on:submit.prevent="_submitForm">
                            <div class="table-responsive tableFixHead">

                                <table class="table mb-0" v-if="getViewDataProcess()">
                                    <thead
                                        class="table-light table-product_parent_by_prices">
                                    <tr>

                                        <th><?php echo '{{params.managerSteps.two.body.tabs.one.table.colOne.title}}' ?></th>
                                        <th><?php echo '{{params.managerSteps.two.body.tabs.one.table.colTwo.title}}' ?></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr v-for="(v, index) in $v.model.attributes.product_parent_by_prices_data.$each.$iter"
                                        :key="index"
                                        v-bind:index-manager="index"
                                        v-bind:id="'id-manager-product_parent_by_prices-'+index"
                                        v-bind:delete-allow="v.id.$model">

                                        <td>

                                            <div class="form-group"
                                                 :class="getClassErrorForm('description',v.description)">
                                                <label class="form__label "
                                                       v-html='getLabelForm("description")'></label>
                                                <div class="content ">
                                                    <input

                                                        v-model.trim="v.description.$model"
                                                        v-bind:id="getNameAttributeData(index,'description')"
                                                        v-bind:name="getNameAttributeData(index,'description')"
                                                        class="form-control m-input"
                                                        @change="_setValueFormData('description', $event.target.value,index,v.description)"
                                                        v-focus-select
                                                    >
                                                </div>
                                                <div class="content-message-errors ">
                                                    <b-form-invalid-feedback
                                                        :state="!v.description.$error">
                                            <span v-if="!v.description.required">
                                <?php echo "{{model.structure.description.required.msj}}" ?>
                            </span>

                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </td>
                                        <td>

                                            <div class="form-group"
                                                 :class="getClassErrorForm('price',v.price)">
                                                <label class="form__label " v-html='getLabelForm("price")'></label>
                                                <div class="content ">
                                                    <input
                                                        type="number"
                                                        v-model.trim="v.price.$model"
                                                        v-bind:id="getNameAttributeData(index,'price')"
                                                        v-bind:name="getNameAttributeData(index,'price')"
                                                        class="form-control m-input"
                                                        @change="_setValueFormData('price', $event.target.value,index,v.price)"
                                                        v-focus-select
                                                    >
                                                </div>
                                                <div class="content-message-errors ">
                                                    <b-form-invalid-feedback
                                                        :state="!v.price.$error">
                                            <span v-if="!v.price.required">
                                <?php echo "{{model.structure.price.required.msj}}" ?>
                            </span>

                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <a class="link-add-manager link-add-manager--fixed"
                                               v-on:click="onDeleteData({index:index,value:v})"
                                            >
                                                <i class="fas fa-trash"></i>

                                            </a></td>
                                    </tr>

                                    </tbody>


                                </table>


                                <div class="card text-white bg-primary" v-if="!getViewDataProcess()">
                                    <div class="card-body">
                                        <blockquote class="card-bodyquote mb-0">
                                            <p>Advertencia. !</p>
                                            <footer class="blockquote-footer text-white">Agrege <cite
                                                    title="Source Title">Precios</cite></footer>
                                        </blockquote>
                                    </div>
                                </div>

                            </div> <!-- end table-responsive-->
                        </b-form>

                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>

    </div>
</script>

<div class="modal fade" id="modal-delete-product_parent_by_package_params" tabindex="-1" aria-labelledby="miModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-delete-product_parent_by_package_params__title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-delete-product_parent_by_package_params__body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-delete-product_parent_by_package_params__btn-close"
                        data-bs-dismiss="modal">

                </button>
                <button type="button"
                        class="btn btn-primary modal-delete-product_parent_by_package_params__btn-accept"></button>
            </div>
        </div>
    </div>
</div>
<script type="text/x-template" id="product_parent_by_package_params-template">
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title not-view">Table
                            head
                            options</h4>
                        <p class="sub-header not-view">
                            Use one of two modifier classes to
                            make <code>&lt;thead&gt;</code>s
                            appear light
                            or dark gray.
                        </p>

                        <a class="link-add-manager link-add-manager--fixed"
                           v-on:click="onAddData()"
                        >
                            <i class="fas fa-plus-square"></i>
                            <?php echo '{{params.managerSteps.two.footer.buttonsManager.threeListPacking.title}}' ?>
                        </a>
                        <b-form id="ProductParentByPackageParams" v-on:submit.prevent="_submitForm">
                            <div class="table-responsive tableFixHead">
                                <table class="table mb-0" v-if="getViewDataProcess()" id="fixedTable">
                                    <thead
                                        class="table-light table-product_parent_by_package_params">
                                    <tr>

                                        <th><?php echo '{{params.managerSteps.two.body.tabs.two.table.colOne.title}}' ?></th>
                                        <th><?php echo '{{params.managerSteps.two.body.tabs.two.table.colTwo.title}}' ?></th>
                                        <th><?php echo '{{params.managerSteps.two.body.tabs.two.table.colThree.title}}' ?></th>
                                        <th><?php echo '{{params.managerSteps.two.body.tabs.two.table.colFour.title}}' ?></th>

                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(v, index) in $v.model.attributes.product_parent_by_package_params_data.$each.$iter"

                                        :key="index"
                                        v-bind:index-manager="index"
                                        v-bind:id="'id-manager-product_parent_by_package_params-'+index"
                                        v-bind:delete-allow="v.id.$model">

                                        <td>

                                            <div class="form-group"
                                                 :class="getClassErrorForm('name',v.name)">
                                                <label class="form__label "
                                                       v-html='getLabelForm("name" )'></label>
                                                <div class="content ">
                                                    <input

                                                        v-model.trim="v.name.$model"
                                                        v-bind:id="getNameAttributeData(index,'name')"
                                                        v-bind:name="getNameAttributeData(index,'name')"
                                                        class="form-control m-input"
                                                        @change="_setValueFormData('name', $event.target.value,index,v.name)"
                                                        v-focus-select
                                                    >
                                                </div>
                                                <div class="content-message-errors ">
                                                    <b-form-invalid-feedback
                                                        :state="!v.name.$error">
                                            <span v-if="!v.name.required">
                                <?php echo "{{model.structure.name.required.msj}}" ?>
                            </span>

                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </td>
                                        <td>

                                            <div class="form-group"
                                                 :class="getClassErrorForm('type_param',v.type_param)">
                                                <label class="form__label "
                                                       v-html='getLabelForm("type_param")'></label>
                                                <div class="content ">
                                                    <select
                                                        class="form-control form-select "
                                                        v-model.trim="v.type_param.$model"
                                                        v-bind:id="getNameAttributeData(index,'type_param')"
                                                        v-bind:name="getNameAttributeData(index,'type_param')"
                                                        @change="_setValueFormData('type_param', $event.target.value,index,v.type_param)"
                                                    >
                                                        <option
                                                            v-for="(row,index) in type_param_data"
                                                            v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="content-message-errors ">
                                                    <b-form-invalid-feedback
                                                        :state="!v.type_param.$error">
                                            <span v-if="!v.type_param.required">
                                <?php echo "{{model.structure.type_param.required.msj}}" ?>
                            </span>

                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </td>
                                        <td>

                                            <div class="form-group"
                                                 :class="getClassErrorForm('limit_one',v.limit_one)">
                                                <label class="form__label " v-html='getLabelForm("limit_one")'></label>
                                                <div class="content ">
                                                    <input
                                                        type="number"
                                                        v-model.trim="v.limit_one.$model"
                                                        v-bind:id="getNameAttributeData(index,'limit_one')"
                                                        v-bind:name="getNameAttributeData(index,'limit_one')"
                                                        class="form-control m-input"
                                                        @change="_setValueFormData('limit_one', $event.target.value,index,v.limit_one)"
                                                        v-focus-select
                                                    >
                                                </div>
                                                <div class="content-message-errors ">
                                                    <b-form-invalid-feedback
                                                        :state="!v.limit_one.$error">
                                            <span v-if="!v.limit_one.required">
                                <?php echo "{{model.structure.limit_one.required.msj}}" ?>
                            </span>

                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>
                                            <div class="form-group"
                                                 v-if="v.type_param.$model==typeParamsData.GREATER_AND_LESS_THAN"
                                                 :class="getClassErrorForm('limit_two',v.limit_two)">
                                                <label class="form__label " v-html='getLabelForm("limit_two")'></label>
                                                <div class="content ">
                                                    <input
                                                        type="number"
                                                        v-model.trim="v.limit_two.$model"
                                                        v-bind:id="getNameAttributeData(index,'limit_two')"
                                                        v-bind:name="getNameAttributeData(index,'limit_two')"
                                                        class="form-control m-input"
                                                        @change="_setValueFormData('limit_two', $event.target.value,index,v.limit_two)"
                                                        v-focus-select
                                                    >
                                                </div>
                                                <div class="content-message-errors ">
                                                    <b-form-invalid-feedback
                                                        :state="!v.limit_two.$error">
                                            <span v-if="!v.limit_two.required">
                                <?php echo "{{model.structure.limit_two.required.msj}}" ?>
                            </span>

                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>
                                        </td>

                                        <td>

                                            <div class="form-group"
                                                 :class="getClassErrorForm('product_parent_by_prices_id_data',v.product_parent_by_prices_id_data)">
                                                <label class="form__label "
                                                       v-html='getLabelForm("product_parent_by_prices_id_data" )'></label>
                                                <div class="content ">


                                                    <select
                                                        class="form-control form-select "
                                                        v-model.trim="v.product_parent_by_prices_id_data.$model"
                                                        v-bind:id="getNameAttributeData(index,'product_parent_by_prices_id_data')"
                                                        v-bind:name="getNameAttributeData(index,'product_parent_by_prices_id_data')"
                                                        @change="_setValueFormData('product_parent_by_prices_id_data', $event.target.value,index,v.product_parent_by_prices_id_data)"
                                                    >
                                                        <option
                                                            v-for="(row,index) in dataParentPrices"
                                                            v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="content-message-errors ">
                                                    <b-form-invalid-feedback
                                                        :state="!v.product_parent_by_prices_id_data.$error">
                                            <span v-if="!v.product_parent_by_prices_id_data.required">
                                <?php echo "{{model.structure.product_parent_by_prices_id_data.required.msj}}" ?>
                            </span>

                                                    </b-form-invalid-feedback>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <a class="link-add-manager link-add-manager--fixed"
                                               v-on:click="onDeleteData({index:index,value:v})"
                                            >
                                                <i class="fas fa-trash"></i>

                                            </a>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                                <div class="card text-white bg-primary" v-if="!getViewDataProcess()">
                                    <div class="card-body">
                                        <blockquote class="card-bodyquote mb-0">
                                            <p>Advertencia. !</p>
                                            <footer class="blockquote-footer text-white">Agrege <cite
                                                    title="Source Title">Paquetes </cite></footer>
                                        </blockquote>
                                    </div>
                                </div>
                            </div>
                        </b-form>

                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>

    </div>
</script>
<script type='text/x-template' id='{{$configProcess['entity-process']}}-template' main-process>
    <div>

        <div class='content-component'>
            <b-container class="container-manager-buttons--tabs">

                <div class="content-row-manager-buttons">
                    <button
                        v-if="!managerMenuConfig.view && !showManager"
                        type="button"
                        class="btn "
                        :class="{'btn-success':!showManager,'btn-danger':showManager}"
                        v-on:click="_viewManager(showManager?2:1)">
                        <?php echo "{{showManager?'Regresar':'Nuevo'}}" ?></button>


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

                <div class="custom-scroll-admin-grid table-responsive" v-show="!managerSteps.config.show">
                    <table id="{{$configProcess['entity-process']}}-grid"
                           class="xywer-tbl-admin--inka"

                    >
                        <thead class="manager-thead">
                        <tr>
                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                            <th data-column-id="code_name" data-formatter="code_name"  data-order="desc">Cod/Producto</th>
                            <th data-column-id="product_category" data-formatter="product_category">Categoria</th>
                            <th data-column-id="product_subcategory" data-formatter="product_subcategory">Subcategoria</th>
                            <th data-column-id="amount_variety" data-formatter="amount_variety">Cant Varia</th>
                            <th data-column-id="amount_total" data-formatter="amount_total">Cant Total</th>
                            <th data-column-id="state" data-formatter="state">Estado</th>
                            <th data-column-id="product_parent_by_prices_data" data-formatter="product_parent_by_prices_data" data-sortable="false">Precios</th>
                            <th data-column-id="product_parent_by_package_params_data" data-formatter="product_parent_by_package_params_data" data-sortable="false">Paquetes</th>



                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="content-form" v-if="managerSteps.config.show">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <div id="addproduct-nav-pills-wizard" class="twitter-bs-wizard form-wizard-header"
                                     v-initFormWizard="{nameMethod:initFormWizard}">
                                    <ul class="twitter-bs-wizard-nav mb-2">
                                        <li class="nav-item">
                                            <a href="#product_parent" class="nav-link" data-bs-toggle="tab"
                                               data-toggle="tab"
                                               id="product_parent-a"
                                            >
                                                <span
                                                    class="number"> <?php echo '{{managerSteps.one.header.number}}' ?></span>
                                                <span class="d-none d-sm-inline">
                                                    <?php echo '{{managerSteps.one.header.title}}' ?>

                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#product_by_manager_process" class="nav-link" data-bs-toggle="tab"
                                               data-toggle="tab"

                                               id="product_by_manager_process-a">
                                                <span
                                                    class="number"><?php echo '{{managerSteps.two.header.number}}' ?></span>
                                                <span
                                                    class="d-none d-sm-inline"><?php echo '{{managerSteps.two.header.title}}' ?></span>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="#product_parent_by_product" class="nav-link" data-bs-toggle="tab"
                                               data-toggle="tab"

                                               id="product_parent_by_product-a"
                                            >
                                                <span
                                                    class="number"><?php echo '{{managerSteps.three.header.number}}' ?></span>
                                                <span
                                                    class="d-none d-sm-inline"><?php echo '{{managerSteps.three.header.title}}' ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content twitter-bs-wizard-tab-content">
                                        <div class="tab-pane" id="product_parent">
                                            <h4 class="header-title"><?php echo '{{managerSteps.one.messages.one.title}}' ?></h4>
                                            <p class="sub-header"><?php echo '{{managerSteps.one.messages.one.value}}' ?></p>

                                            <div>

                                                <product_parent-component

                                                    ref="refProductParent"
                                                    :params="{data:managerSteps}"
                                                    @on-send-events-by-component-to-parent="onSendEventsByComponentToParent"
                                                    @message-to-product_parent="handleMessageFromParent"
                                                ></product_parent-component>
                                            </div>

                                            <ul class="pager wizard mb-0 list-inline text-end mt-3 pager--buttons-steps">
                                                <li class=" list-inline-item"
                                                >
                                                    <button id='return-product_parent' type="button" class="btn btn-danger"

                                                            v-on:click="onReturnModelComponent({type:'product_parent'})"
                                                    >
                                                        <i
                                                            class="mdi mdi-arrow-left"></i>
                                                        <?php echo '{{managerSteps.one.footer.buttonsManager.two.title}}' ?>


                                                    </button>
                                                    <button type="button" class="btn btn-success"

                                                            :disabled="!managerSteps.one.footer.buttonsManager.one.allow"
                                                            v-on:click="onSaveModelComponent({type:'product_parent'})"
                                                    >
                                                        <?php echo '{{managerSteps.one.footer.buttonsManager.one.title}}' ?>

                                                        <i
                                                            class="mdi mdi-arrow-right ms-1"></i>

                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" id="product_by_manager_process">
                                            <div v-if="managerSteps.process.parent_id">
                                                <h4 class="header-title"><?php echo '{{managerSteps.two.messages.one.title}}' ?></h4>
                                                <p class="sub-header "></p>

                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h4 class="header-title mb-4 not-view">Tabs Bordered</h4>

                                                            <ul class="nav nav-tabs nav-bordered">
                                                                <li class="nav-item">
                                                                    <a href="#product_parent_by_prices"
                                                                       data-bs-toggle="tab"
                                                                       aria-expanded="false"
                                                                       id="product_parent_by_prices-li"
                                                                       class="nav-link nav-link--prices-packing active">
                                                                    <span class="d-inline-block d-sm-none"><i
                                                                            class="mdi mdi-home-variant"></i></span>
                                                                        <span
                                                                            class="d-none d-sm-inline-block"><?php echo '{{managerSteps.two.body.tabs.one.title}}' ?></span>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a href="#product_parent_by_package_params"
                                                                       data-bs-toggle="tab" aria-expanded="true"
                                                                       id="product_parent_by_package_params-li"
                                                                       class="nav-link  nav-link--prices-packing">
                                                                    <span class="d-inline-block d-sm-none"><i
                                                                            class="mdi mdi-account"></i></span>
                                                                        <span
                                                                            class="d-none d-sm-inline-block"><?php echo '{{managerSteps.two.body.tabs.two.title}}' ?></span>
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                            <div class="tab-content">

                                                                <div class="tab-pane active"
                                                                     id="product_parent_by_prices">

                                                                    <product_parent_by_prices-component

                                                                        ref="refProductParentByPrices"
                                                                        :params="{managerSteps:managerSteps}"
                                                                        :processData="{name:'product_parent_by_prices'}"
                                                                        @on-send-events-by-component-to-parent="onSendEventsByComponentToParent"
                                                                        @message-to-product_parent_by_prices="handleMessageFromParent"

                                                                    ></product_parent_by_prices-component>


                                                                </div>
                                                                <div class="tab-pane show "
                                                                     id="product_parent_by_package_params">
                                                                    <product_parent_by_package_params-component
                                                                        v-if="managerSteps.two.body.tabs.one.allow"

                                                                        ref="refProductParentByPackageParams"
                                                                        :params="{managerSteps:managerSteps}"
                                                                        :processData="{name:'product_parent_by_package_params'}"
                                                                        @on-send-events-by-component-to-parent="onSendEventsByComponentToParent"
                                                                        @message-to-product_parent_by_package_params="handleMessageFromParent"

                                                                    ></product_parent_by_package_params-component>
                                                                    <!-- BUSINESS-MANAGER-VIEW-CONDITION--ProductParentByPackageParams -->

                                                                    <div class="card text-white bg-primary"
                                                                         v-if="!managerSteps.two.body.tabs.one.allow">
                                                                        <!-- BUSINESS-MANAGER-VIEW-CONDITION--ProductParentByPackageParams -->
                                                                        <div class="card-body">
                                                                            <blockquote class="card-bodyquote mb-0">
                                                                                <p>Advertencia. !</p>
                                                                                <footer
                                                                                    class="blockquote-footer text-white">
                                                                                    No
                                                                                    se puede agregar Parametros si no
                                                                                    existe: <cite
                                                                                        title="Source Title">Precios</cite>
                                                                                </footer>
                                                                            </blockquote>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div> <!-- end card -->
                                                </div> <!-- end col -->

                                                <ul class="pager wizard mb-0 list-inline text-end mt-3 pager--buttons-steps">
                                                    <li class="list-inline-item">

                                                        <button type="button" class="btn btn-danger"
                                                                v-on:click="onReturnModelComponent({type:'product_by_manager_process'})">
                                                            <i
                                                                class="mdi mdi-arrow-left"></i> <?php echo '{{managerSteps.two.footer.buttonsManager.twoListPrice.title}}' ?>
                                                        </button>
                                                    </li>
                                                    <li class=" list-inline-item not-view">
                                                        <button type="button"
                                                                class="btn btn-success"><?php echo '{{managerSteps.two.footer.buttonsManager.oneListPrice.title}}' ?>
                                                            <i
                                                                class="mdi mdi-arrow-right ms-1"></i></button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card text-white bg-primary"
                                                 v-if="!managerSteps.process.parent_id">
                                                <div class="card-body">
                                                    <blockquote class="card-bodyquote mb-0">
                                                        <p>Advertencia. !</p>
                                                        <footer
                                                            class="blockquote-footer text-white">No se puede
                                                            Configurar:
                                                            <cite

                                                                title="Source Title">Precios y Paquetes, hasta que se
                                                                cree el producto principal.
                                                            </cite>

                                                        </footer>
                                                    </blockquote>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="product_parent_by_product">


                                            <div class="card text-white bg-primary"
                                                 v-if="!managerSteps.two.body.tabs.one.allow || !managerSteps.two.body.tabs.two.allow ">


                                                <div class="card-body">
                                                    <blockquote class="card-bodyquote mb-0">
                                                        <p>Advertencia. !</p>
                                                        <footer
                                                            class="blockquote-footer text-white">No se puede Agregar
                                                            Productos , debido a que no se a configurado.
                                                            <cite
                                                                v-if="managerSteps.two.body.tabs.one.allow && !managerSteps.two.body.tabs.two.allow"
                                                                title="Source Title">Paquetes.
                                                            </cite>
                                                            <cite
                                                                v-else-if="!managerSteps.two.body.tabs.one.allow && managerSteps.two.body.tabs.two.allow"
                                                                title="Source Title">Precios
                                                            </cite>
                                                            <cite
                                                                v-else-if="!managerSteps.two.body.tabs.one.allow && !managerSteps.two.body.tabs.two.allow"
                                                                title="Source Title">Precios y Paquetes
                                                            </cite>
                                                        </footer>
                                                    </blockquote>
                                                </div>
                                            </div>
                                            <div
                                                v-if="managerSteps.two.body.tabs.one.allow && managerSteps.two.body.tabs.two.allow ">


                                                <product_parent_by_product_manager-component

                                                    ref="refProductParentByProductManager"
                                                    :params="{managerSteps:managerSteps}"
                                                    :processData="{name:'product_parent_by_product_manager'}"
                                                    @on-send-events-by-component-to-parent="onSendEventsByComponentToParent"
                                                    @message-to-product_parent_by_product_manager="handleMessageFromParent"

                                                ></product_parent_by_product_manager-component>


                                            </div>


                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </div>
</script>

<script type='text/x-template' id='product_by_log_inventory-template'>
    <div>
        <div class='content-component'>


            <b-modal
                hide-footer
                id="modal-product_by_log_inventory"
                ref="refModalProductByLogInventory"
                size="xl"
                <?php echo '@show="_showModal"' ?><?php echo '@hidden="_hideModal"' ?><?php echo '@ok="_saveModal"' ?>>
                <template slot="modal-title">
                    <label v-html="labelsConfig.title"></label>
                </template>
                <b-container class="container-manager-buttons">

                    <div class="content-row-manager-buttons-not" v-if="allowViewButton()">

                        <button v-if="showManager " type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                            <?php echo '{{managerType==1?labelsConfig.buttons.save:labelsConfig.buttons.update}}' ?>    </button>

                    </div>
                </b-container>

                <div class="content-form" v-if="showManager">
                    <div class="d-block ">
                        <b-form id="languageProductForm" v-on:submit.prevent="_submitForm">


                            <b-container>
                                <input v-model="model.attributes.id" type="hidden"
                                       v-bind:id="getNameAttribute('id')"
                                       v-bind:name="getNameAttribute('id')"
                                >
                                <b-row>
                                    <b-col md="4">
                                        <div class="form-group"

                                             :class="getClassErrorForm('type_input',$v.model.attributes['type_input'])">
                                            <label
                                                class="form__label " v-html='getLabelForm("type_input")'></label>
                                            <div class="content-element-form">
                                                <select v-model.trim="$v.model.attributes['type_input'].$model"
                                                        v-bind:id="getNameAttribute('type_input')"
                                                        v-bind:name="getNameAttribute('type_input')"
                                                        class="form-control m-input"
                                                        @change="_setValueForm('type_input', $v.model.attributes['type_input'].$model)"
                                                >
                                                    <option v-for="(row,index) in model.structure['type_input'].options"
                                                            v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes['type_input'].$error">
      <span v-if="!$v.model.attributes['type_input'].required">
       <?php echo "{{model.structure['type_input'].required.msj}}" ?>
      </span>


                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>
                                </b-row>
                                <b-row>
                                    <b-col md="6">
                                        <div class="form-group form-group--content">
                                            <label
                                                class="form-group__quantity-units"> <?php echo '{{model.structure["quantity_units"].label}} Actual:' ?>
                                                <span
                                                    class="badge badge--size-large badge-info"><?php echo '{{configParams.data.quantity_units}}' ?></span>
                                            </label>
                                        </div>
                                    </b-col>

                                </b-row>
                                <b-row>

                                    <b-col md="6">
                                        <div class="form-group "

                                             :class="getClassErrorForm('quantity_units',$v.model.attributes.quantity_units)">
                                            <label
                                                class="form__label " v-html='getLabelForm("quantity_units")'></label>


                                            <div class="content-element-form">

                                                <input

                                                    v-model.trim="$v.model.attributes.quantity_units.$model"
                                                    type="number"
                                                    min="0"

                                                    v-bind:id="getNameAttribute('quantity_units')"
                                                    v-bind:name="getNameAttribute('quantity_units')"
                                                    class="form-control m-input i"
                                                    @change="_setValueForm('quantity_units', $v.model.attributes.quantity_units.$model)"
                                                    v-focus-select
                                                >

                                            </div>
                                            <div class="content-message-errors">
                                                <b-form-invalid-feedback
                                                    :state="!$v.model.attributes.quantity_units.$error">
      <span v-if="!$v.model.attributes.quantity_units.required">
       <?php echo "{{model.structure.quantity_units.required.msj}}" ?>
      </span>
                                                    <span v-if="!$v.model.attributes.quantity_units.maxValue">
                                               <?php echo "{{model.structure.quantity_units.maxValue.msj}} {{configParams.data.quantity_units}}" ?>
                                                    </span>
                                                </b-form-invalid-feedback>
                                            </div>
                                        </div>

                                    </b-col>


                                </b-row>
                                <b-row v-if="validateForm()"
                                >
                                    <b-col md="6">
                                        <div class="form-group form-group--content">
                                            <label
                                                class="form-group__quantity-units"> <?php echo '{{model.structure["quantity_units"].label}} Total:' ?>
                                                <span
                                                    class="badge badge--size-large badge-success"><?php echo '{{getResultQuantityUnits()}}' ?></span>
                                            </label>
                                        </div>
                                    </b-col>

                                </b-row>
                            </b-container>


                        </b-form>
                    </div>

                </div>

            </b-modal>


        </div>
    </div>
</script>


<script type='text/x-template' id='product_parent_by_product_manager-template' second-process>
    <div>
        <div v-if="configModalProductByLogInventory.viewAllow">
            <product_by_log_inventory-component
                ref="refProductByLogInventory"
                :params="configModalProductByLogInventory"
                @on-send-events-by-component-to-parent="onSendEventsByComponentToParent"
            >
            </product_by_log_inventory-component>
        </div>
        <div class='content-component'>
            <div class="container-manager-buttons--tabs">
                <div class="row">

                    <div class="col-md-2">

                        <div class="content-manager-buttons-grid ready" >
                            <div class="inline-data">
                                <a class="content-manager-buttons-grid__a link--manager" v-if="!showManagerReturn"
                                   v-on:click="onViewProcessProductParent({type:1})"><i
                                        class="far fa-arrow-alt-circle-left">
                                    </i>

                                </a>
                            </div>
                            <menu-admin-grid v-if="managerMenuConfig.view"
                                @input="_managerRowGrid($event)"
                                :manager-menu-config="managerMenuConfig">

                            </menu-admin-grid>
                        </div>

                    </div>
                    <div class="col-md-10">
                        <div class="content-row-manager-buttons--tabs">

                            <button
                                v-if="!showManager"
                                type="button"
                                class="btn "
                                :class="{'btn-success':!showManager,'btn-warning':showManager}"
                                v-on:click="_viewManager(showManager?2:1)">
                                <i v-if="!showManager" class="fas fa-plus-circle"></i>
                                <?php echo "{{showManager?'Regresar':'Añadir Producto'}}" ?>

                            </button>

                        </div>
                    </div>
                </div>

            </div>
            <div class="manager-view-product-parent" v-show="!managerSteps.config.show">
                <div class="row">
                    <h2> <?php echo '{{configParams.managerSteps.process.data.name}}' ?>   </h2>
                    <span class="info-value"> <?php echo '{{configParams.managerSteps.process.data.code}}' ?>
                        <a class="link--manager"
                           v-on:click="onViewProcessProductParent({type:8})"><i
                                class="fas fa-external-link-alt"></i></a>
                    </span>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <h3 class="manager-view-product-parent__title"> Especificaciones
                        </h3>
                        <ul class="manager-view-product-parent__ul">
                            <li class="manager-view-product-parent__li">

                                <span class="manager-view-product-parent__li-title">Estado</span>
                                <span
                                    class="manager-view-product-parent__li-value"><?php echo '{{configParams.managerSteps.process.data.state=="ACTIVE"?"ACTIVO":"INACTIVO" }}' ?> </span>

                            </li>
                            <li class="manager-view-product-parent__li">

                                <span class="manager-view-product-parent__li-title">Iva</span>
                                <span
                                    class="manager-view-product-parent__li-value"><?php echo '{{configParams.managerSteps.process.data.tax_value}}' ?> </span>

                            </li>
                            <li class="manager-view-product-parent__li">

                                <span class="manager-view-product-parent__li-title">Categoria</span>
                                <span
                                    class="manager-view-product-parent__li-value"><?php echo '{{configParams.managerSteps.process.data.product_category}}' ?> </span>

                            </li>
                            <li class="manager-view-product-parent__li">

                                <span class="manager-view-product-parent__li-title">Subcategoria</span>
                                <span
                                    class="manager-view-product-parent__li-value"><?php echo '{{configParams.managerSteps.process.data.product_subcategory}}' ?> </span>

                            </li>
                            <li class="manager-view-product-parent__li">

                                <span class="manager-view-product-parent__li-title">Medida</span>
                                <span
                                    class="manager-view-product-parent__li-value"><?php echo '{{configParams.managerSteps.process.data.product_measure_type}}' ?> </span>

                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3 class="manager-view-product-parent__title"> Listado de precios
                            <span class="info-value"> <a class="link--manager"
                                                         v-on:click="onViewProcessProductParent({type:2})"><i
                                        class="fas fa-external-link-alt"></i></a></span>
                        </h3>
                        <ul class="manager-view-product-parent__ul">
                            <li class="manager-view-product-parent__li"
                                v-for="(row,index) in configParams.managerSteps.process.data.product_parent_by_prices_data">

                                <span
                                    class="manager-view-product-parent__li-title"><?php echo '{{row.description}}' ?></span>
                                <span class="manager-view-product-parent__li-value"><?php echo '{{row.price}}' ?></span>

                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3 class="manager-view-product-parent__title"> Listado de paquetes
                            <span class="info-value">
                                <a class="link--manager" v-on:click="onViewProcessProductParent({type:3})">
                                    <i
                                        class="fas fa-external-link-alt"></i>
                                </a>
                            </span>
                        </h3>
                        <ul class="manager-view-product-parent__ul">
                            <li class="manager-view-product-parent__li"
                                v-for="(row,index) in configParams.managerSteps.process.data.product_parent_by_package_params_data">

                                <span class="manager-view-product-parent__li-title"><?php echo '{{row.name}}' ?></span>
                                <span
                                    class="manager-view-product-parent__li-value"><?php echo '{{row.limit_one}}' ?></span>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="content-manager-grid">

                <div class="custom-scroll-admin-grid table-responsive" v-show="!managerSteps.config.show">
                    <table id="product_parent_by_product_manager-grid"
                           class="xywer-tbl-admin--inka"

                    >
                        <thead class="manager-thead">
                        <tr>
                            <th data-visible="false" data-column-id="id" data-identifier="true"> ID</th>
                            <th data-column-id="code_name" data-formatter="code_name"  data-order="desc">Cod/Producto</th>
                            <th data-column-id="packages" data-formatter="packages" data-sortable="false">Paquetes</th>
                            <th data-column-id="stock" data-formatter="stock">Stock</th>
                            <th data-column-id="state" data-formatter="state">Estado</th>



                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div v-if="managerSteps.config.show">


                <product_parent_by_product-component

                    ref="refProductParentByProduct"
                    :params="{managerSteps:configParams.managerSteps,managerStepsParent:managerSteps}"
                    :processData="{name:'product_parent_by_product'}"
                    @on-send-events-by-component-to-parent="onSendEventsByComponentToParent"
                    @message-to-product_parent_by_product="handleMessageFromParent"

                ></product_parent_by_product-component>
            </div>

        </div>
    </div>
</script>
<script type='text/x-template' id='product_parent_by_product-template' third-process>
    <div>

        <div class="container-manager-buttons--tabs-input">
            <div class="row">
                <div class="col-md-10">
                    <div class="content-row-manager-buttons--tabs-left">
                        <div class="inline-data">
                            <button

                                type="button"
                                class="btn btn-danger"
                                v-on:click="_viewManager(2)">
                                Regresar
                            </button>

                        </div>
                        <div class="inline-data">
                            <button

                                type="button"
                                :disabled="!validateForm()"
                                class="btn btn-success "
                                v-on:click="_saveModel()">
                                <?php echo '{{labelsConfig.buttons.managerSave}}' ?>
                            </button>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        <div class="content-form">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-4 not-view">Tabs Bordered</h4>

                            <ul class="nav nav-tabs nav-bordered">
                                <li class="nav-item">
                                    <a href="#product"
                                       data-bs-toggle="tab"
                                       aria-expanded="false"
                                       id="product_parent_by_prices-li"
                                       class="nav-link nav-link--prices-packing active">
                                                                    <span class="d-inline-block d-sm-none"><i
                                                                            class="mdi mdi-home-variant"></i></span>


                                        <span
                                            class="d-none d-sm-inline-block">Producto</span>

                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product_by_multimedia"
                                       data-bs-toggle="tab" aria-expanded="true"
                                       id="product-li"
                                       class="nav-link  nav-link--prices-packing">
                                                                    <span class="d-inline-block d-sm-none"><i
                                                                            class="mdi mdi-account"></i></span>
                                        <span
                                            class="d-none d-sm-inline-block"> Imagenes</span>
                                    </a>
                                </li>

                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane active"
                                     id="product">
                                    <b-form id="productForm" v-on:submit.prevent="_submitForm">
                                        <div>
                                            <input v-model="model.attributes.id" type="hidden"
                                                   v-bind:id="getNameAttribute('id')"
                                                   v-bind:name="getNameAttribute('id')"
                                            >
                                            <div class="head-info">

                                                <h1 class="head-info__title"> <?php echo "{{configParams.managerStepsParent.one.messages.one.title}}" ?></h1>
                                                <span
                                                    class="head-info__msg"> <?php echo "{{configParams.managerStepsParent.one.messages.one.value}}" ?></span>
                                            </div>
                                            <b-row>
                                                <b-col md="3">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('state',$v.model.attributes.state)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("state")'></label>
                                                        <div class="content-element-form">
                                                            <select v-model.trim="$v.model.attributes.state.$model"
                                                                    v-bind:id="getNameAttribute('state')"
                                                                    v-bind:name="getNameAttribute('state')"
                                                                    class="form-control m-input"
                                                                    @change="_setValueForm('state', $v.model.attributes.state.$model)"
                                                            >
                                                                <option
                                                                    v-for="(row,index) in model.structure.state.options"
                                                                    v-bind:value="row.value"><?php echo '{{row.text}}' ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.state.$error">
      <span v-if="!$v.model.attributes.state.required">
       <?php echo "{{model.structure.state.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                                <b-col md="2">
                                                    <div class="form-group"

                                                         :class="getClassErrorForm('view_online',$v.model.attributes.view_online)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("view_online")'></label>
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


                                                <b-col md="3">
                                                    <div class="form-group"

                                                         :class="getClassErrorForm('code',$v.model.attributes.code)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("code")'></label>
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
       <?php echo "{{model.structure.code.required.msj}}" ?>
      </span>
                                                                <span v-if="!$v.model.attributes.code.maxLength">
       <?php echo "{{model.structure.code.maxLength.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                                <b-col md="9">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('name',$v.model.attributes.name)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("name")'></label>
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
       <?php echo "{{model.structure.name.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                            </b-row>
                                            <b-row>
                                                <b-col md="8">
                                                    <div class="form-group"

                                                         :class="getClassErrorForm('product_by_package_data',$v.model.attributes.product_by_package_data)">
                                                        <label
                                                            class="form__label "
                                                            v-html='getLabelForm("product_by_package_data")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                v-model="$v.model.attributes.product_by_package_data.model"
                                                                type="hidden"
                                                                v-bind:id="getNameAttribute('product_by_package_data')"
                                                                v-bind:name="getNameAttribute('product_by_package_data')"
                                                                @change="_setValueForm('product_by_package_data', $v.model.attributes.product_by_package_data.$model)"
                                                            >
                                                            <select id="product_by_package_data"
                                                                    class="form-control m-select2 "
                                                                    v-initS2Packages="{rowId:model.attributes.id,nameMethod:initS2Packages}"
                                                            >
                                                            </select>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.product_by_package_data.$error">
      <span v-if="!$v.model.attributes.product_by_package_data.required">
       <?php echo "{{model.structure.product_by_package_data.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                            </b-row>

                                            <div class="head-info">

                                                <h1 class="head-info__title"> <?php echo "{{configParams.managerStepsParent.two.messages.one.title}}" ?></h1>
                                                <span
                                                    class="head-info__msg"> <?php echo "{{configParams.managerStepsParent.two.messages.one.value}}" ?></span>
                                            </div>
                                            <b-row>
                                                <b-col md="12">
                                                    <div class="form-group"

                                                         :class="getClassErrorForm('description',$v.model.attributes.description)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("description")'></label>
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
                                            <b-row>
                                                <b-col md="4">
                                                    <div class="form-group"

                                                         :class="getClassErrorForm('product_by_sizes_data',$v.model.attributes.product_by_sizes_data)">
                                                        <label
                                                            class="form__label "
                                                            v-html='getLabelForm("product_by_sizes_data")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                v-model="$v.model.attributes.product_by_sizes_data.model"
                                                                type="hidden"
                                                                v-bind:id="getNameAttribute('product_by_sizes_data')"
                                                                v-bind:name="getNameAttribute('product_by_sizes_data')"
                                                                @change="_setValueForm('product_by_sizes_data', $v.model.attributes.product_by_sizes_data.$model)"
                                                            >
                                                            <select id="product_by_sizes_data"
                                                                    class="form-control m-select2 "
                                                                    v-initS2="{rowId:model.attributes.id,nameMethod:_managerS2Sizes}"
                                                            >
                                                            </select>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.product_by_sizes_data.$error">
      <span v-if="!$v.model.attributes.product_by_sizes_data.required">
       <?php echo "{{model.structure.product_by_sizes_data.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                                <b-col md="4">
                                                    <div class="form-group"

                                                         :class="getClassErrorForm('product_by_color_data',$v.model.attributes.product_by_color_data)">
                                                        <label
                                                            class="form__label "
                                                            v-html='getLabelForm("product_by_color_data")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                v-model="$v.model.attributes.product_by_color_data.model"
                                                                type="hidden"
                                                                v-bind:id="getNameAttribute('product_by_color_data')"
                                                                v-bind:name="getNameAttribute('product_by_color_data')"
                                                                @change="_setValueForm('product_by_color_data', $v.model.attributes.product_by_color_data.$model)"
                                                            >
                                                            <select id="product_by_color_data"
                                                                    class="form-control m-select2 "
                                                                    v-initS2="{rowId:model.attributes.id,nameMethod:_managerS2Colors}"
                                                            >
                                                            </select>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.product_by_color_data.$error">
      <span v-if="!$v.model.attributes.product_by_color_data.required">
       <?php echo "{{model.structure.product_by_color_data.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                            </b-row>

                                            <div class="head-info">

                                                <h1 class="head-info__title"> <?php echo "{{configParams.managerStepsParent.four.messages.one.title}}" ?></h1>
                                                <span
                                                    class="head-info__msg"> <?php echo "{{configParams.managerStepsParent.four.messages.one.value}}" ?></span>
                                            </div>
                                            <b-row>
                                                <b-col md="6">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('title',$v.model.attributes.title)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("title")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                type="text"

                                                                class="form-control"
                                                                v-model.trim="$v.model.attributes.title.$model"
                                                                v-bind:id="getNameAttribute('title')"
                                                                v-bind:name="getNameAttribute('title')"
                                                                @change="_setValueForm('title', $v.model.attributes.title.$model)"
                                                                v-focus-select
                                                            ></input>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.title.$error">
      <span v-if="!$v.model.attributes.title.required">
       <?php echo "{{model.structure.title.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                                <b-col md="6">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('keyword',$v.model.attributes.keyword)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("keyword")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                type="text"

                                                                class="form-control"
                                                                v-model.trim="$v.model.attributes.keyword.$model"
                                                                v-bind:id="getNameAttribute('keyword')"
                                                                v-bind:name="getNameAttribute('keyword')"
                                                                @change="_setValueForm('keyword', $v.model.attributes.keyword.$model)"
                                                                v-focus-select
                                                            ></input>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.keyword.$error">
      <span v-if="!$v.model.attributes.keyword.required">
       <?php echo "{{model.structure.keyword.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>


                                            </b-row>

                                            <b-row>
                                                <b-col md="12">
                                                    <div class="form-group"

                                                         :class="getClassErrorForm('description_meta',$v.model.attributes.description_meta)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("description_meta")'></label>
                                                        <div class="content-element-form">
<textarea
    rows="10" class="form-control"
    v-model.trim="$v.model.attributes.description_meta.$model"
    v-bind:id="getNameAttribute('description_meta')"
    v-bind:name="getNameAttribute('description_meta')"
    @change="_setValueForm('description_meta', $v.model.attributes.description_meta.$model)"
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
                                            <div class="head-info">

                                                <h1 class="head-info__title"> <?php echo "{{configProcess.shipping.title}}" ?></h1>
                                                <span
                                                    class="head-info__msg"> <?php echo "{{configProcess.shipping.msg}}" ?></span>
                                            </div>


                                            <b-row>
                                                <b-col md="3">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('height',$v.model.attributes.height)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("height")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                type="number"
                                                                min="0"
                                                                class="form-control"
                                                                v-model.trim="$v.model.attributes.height.$model"
                                                                v-bind:id="getNameAttribute('height')"
                                                                v-bind:name="getNameAttribute('height')"
                                                                @change="_setValueForm('height', $v.model.attributes.height.$model)"
                                                                v-focus-select
                                                            ></input>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.height.$error">
      <span v-if="!$v.model.attributes.height.required">
       <?php echo "{{model.structure.height.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                                <b-col md="3">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('length',$v.model.attributes.length)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("length")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                type="number"
                                                                min="0"
                                                                class="form-control"
                                                                v-model.trim="$v.model.attributes.length.$model"
                                                                v-bind:id="getNameAttribute('length')"
                                                                v-bind:name="getNameAttribute('length')"
                                                                @change="_setValueForm('length', $v.model.attributes.length.$model)"
                                                                v-focus-select
                                                            ></input>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.length.$error">
      <span v-if="!$v.model.attributes.length.required">
       <?php echo "{{model.structure.length.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                                <b-col md="3">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('width',$v.model.attributes.width)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("width")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                type="number"
                                                                min="0"
                                                                class="form-control"
                                                                v-model.trim="$v.model.attributes.width.$model"
                                                                v-bind:id="getNameAttribute('width')"
                                                                v-bind:name="getNameAttribute('width')"
                                                                @change="_setValueForm('width', $v.model.attributes.width.$model)"
                                                                v-focus-select
                                                            ></input>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.width.$error">
      <span v-if="!$v.model.attributes.width.required">
       <?php echo "{{model.structure.width.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                                <b-col md="3">
                                                    <div class="form-group"
                                                         :class="getClassErrorForm('weight',$v.model.attributes.weight)">
                                                        <label class="form__label "
                                                               v-html='getLabelForm("weight")'></label>
                                                        <div class="content-element-form">
                                                            <input
                                                                type="number"
                                                                min="0"
                                                                class="form-control"
                                                                v-model.trim="$v.model.attributes.weight.$model"
                                                                v-bind:id="getNameAttribute('weight')"
                                                                v-bind:name="getNameAttribute('weight')"
                                                                @change="_setValueForm('weight', $v.model.attributes.weight.$model)"
                                                                v-focus-select
                                                            ></input>
                                                        </div>
                                                        <div class="content-message-errors">
                                                            <b-form-invalid-feedback
                                                                :state="!$v.model.attributes.weight.$error">
      <span v-if="!$v.model.attributes.weight.required">
       <?php echo "{{model.structure.weight.required.msj}}" ?>
      </span>
                                                            </b-form-invalid-feedback>
                                                        </div>
                                                    </div>

                                                </b-col>
                                            </b-row>


                                        </div>

                                    </b-form>

                                </div>
                                <div class="tab-pane show "
                                     id="product_by_multimedia">

                                    <div class="row"
                                         v-if="configParams.managerStepsParent.process.parent_id!=null">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="header-title"><?php echo "{{configParams.managerStepsParent.three.messages.one.title}}" ?></h4>
                                                        <p class="sub-header">
                                                            <?php echo "{{configParams.managerStepsParent.three.messages.one.value}}" ?>
                                                        </p>

                                                        <form v-bind:action="getUrlCurrentUploadProductByImages()"
                                                              method="post"
                                                              class="dropzone"
                                                              id="myAwesomeDropzone"
                                                              data-plugin="dropzone"
                                                              data-previews-container="#file-previews"
                                                              data-upload-preview-template="#uploadPreviewTemplate"
                                                              v-initUploadImages="{initMethod:initUploadImages}"

                                                        >
                                                            <div class="fallback">
                                                                <input name="file" type="file" multiple/>
                                                            </div>

                                                            <div class="dz-message needsclick">
                                                                <i class="h1 text-muted ri-upload-cloud-2-line"></i>
                                                                <h3>Drop files here or click to upload.</h3>
                                                                <span class="text-muted font-13">(This is just a demo dropzone. Selected files are
                                                    <strong>not</strong> actually uploaded.)</span>
                                                            </div>
                                                        </form>

                                                        <!-- Preview -->
                                                        <div class="dropzone-previews mt-3" id="file-previews">

                                                        </div>

                                                    </div> <!-- end card-body-->
                                                </div> <!-- end card-->
                                            </div><!-- end col -->
                                        </div>
                                        <!-- end row -->

                                        <!-- file preview template -->
                                        <div class="d-none" id="uploadPreviewTemplate">
                                            <div class="card mt-1 mb-0 shadow-none border">
                                                <div class="p-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <img data-dz-thumbnail src="#"
                                                                 class="avatar-sm rounded bg-light" alt="">
                                                        </div>
                                                        <div class="col ps-0">
                                                            <a href="javascript:void(0);" class="text-muted fw-bold"
                                                               data-dz-name></a>
                                                            <p class="mb-0" data-dz-size></p>
                                                        </div>
                                                        <div class="col-auto">
                                                            <!-- Button -->
                                                            <a href="" class="btn btn-link btn-lg text-muted"
                                                               data-dz-remove>
                                                                <i class="fe-x"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card text-white bg-primary"
                                         v-else>
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote mb-0">
                                                <p>Advertencia. !</p>
                                                <footer
                                                    class="blockquote-footer text-white">No se puede Agregar
                                                    Imagenes , debido a que no se a creado.
                                                    <cite

                                                        title="Source Title">Producto.
                                                    </cite>

                                                </footer>
                                            </blockquote>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col -->
            </div>
        </div>

    </div>

</script>
