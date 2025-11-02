<!--ECCOMERCE-001-->
<script type="text/x-template" id="management-form-details-product-template">
    <div>
        <b-modal
            hide-footer
            id="modal-management-form-details-product"
            ref="refManagementFormDetailsProductModal"
            size="xl"
        <?php echo '@show="_showModal"' ?>
            <?php echo '@hidden="_hideModal"' ?>


        >
            <template slot="modal-title">
                <label v-html="labelsConfig.title"></label>
            </template>
            <div class="product-content" v-show="managementViews.managementForm">
                <b-form id="ManagementFormEvent" v-on:submit.prevent="_submitForm">

                    <div class="row">

                        <div class="col-md-6" >

                            <div v-show="managementViews.sliderProductMultimedia.show" id="management-multimedia" class="lazy slider"
                                 v-html="managementViews.data.multimediaHmtl">

                            </div>

                            <div v-html="managementViews.sliderProductMultimedia.emptyHtml" class="loading-product" v-show="!managementViews.sliderProductMultimedia.show">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <h1 class="product__title"
                                v-html="managementViews.data.name+'-'+managementViews.data.code"></h1>
                            <p class="price product__price">
                                <span id="main-price"
                                      class="main-price  "
                                      v-bind:class="{ 'discounted': managementViews.data.allowDiscount }">$ <?php echo "{{managementViews.data.price}}"?></span>
                                <span id="discounted-price" class="discounted-price"
                                      v-if="managementViews.data.allowDiscount">$ <?php echo "{{managementViews.data.priceDiscount}}"?></span>
                            </p>
                            <div id="description" class="product__description product-content__management"
                                 v-html="managementViews.data.description">

                            </div>
                            <div class="product__color product-content__management" v-if="model.attributes['allowColor']">
                                <span class="product-details-title">  {{__('labels.forty-nine')}}*: </span>

                                <select v-model.trim="$v.model.attributes['color_id'].$model"
                                        v-bind:id="getNameAttribute('color_id')"
                                        v-bind:name="getNameAttribute('color_id')"
                                        class="form-control m-input nice-select-quick-view product-color__items"
                                        @change="_setValueForm('color_id', $v.model.attributes['color_id'].$model)"
                                >
                                    <option v-for="(row,index) in model.structure['color_id'].options"
                                            v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="product__size product-content__management" v-if="model.attributes['allowSize']">
                                <span class="product-details-title">      {{__('labels.fifty')}}*: </span>

                                <select v-model.trim="$v.model.attributes['size_id'].$model"
                                        v-bind:id="getNameAttribute('size_id')"
                                        v-bind:name="getNameAttribute('size_id')"
                                        class="form-control m-input nice-select-quick-view product-size__items"
                                        @change="_setValueForm('size_id', $v.model.attributes['size_id'].$model)"
                                >
                                    <option v-for="(row,index) in model.structure['size_id'].options"
                                            v-bind:value="row.id"><?php echo '{{row.text}}' ?>
                                    </option>
                                </select>
                            </div>
                            <div class="pro-qty d-inline-block manager-basket-inputs" v-if="managementViews.buttons.addCart.view">
                                <a class="dec qty-btn" v-on:click="_incrementDecrement(0)" ><i class="fa fa-minus"></i></a>
                                <input type="number"    @change="
                                " v-model.trim="$v.model.attributes['amount'].$model"  min="1"  id="product-amount-preview">
                                <a class="inc qty-btn" v-on:click="_incrementDecrement(1)" ><i class="fa fa-plus"></i></a>
                            </div>
                            <div v-if="managementViews.buttons.addCart.view" class="add-to-cart-btn d-inline-block manager-basket-inputs product__buttons">
                                <button class="btn  big-btn btn--custom "
                                        product-id="null"
                                        type="button"
                                        :disabled="!validateForm()"
                                        v-on:click="_saveModel()"
                                        id="add-cart-preview">
                                    {{__('config.buttons.one')}}
                                </button>
                            </div>
                            <div class="product__quick-view-info">

                            </div>
                        </div>
                    </div>
                </b-form>


            </div>

        </b-modal>


    </div>

</script>
