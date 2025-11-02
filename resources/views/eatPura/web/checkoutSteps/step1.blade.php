<h4 class="checkout-title">{{__('checkout.titles.step1')}}</h4>
@include('eatPura.web.checkoutSteps.createAccount',array())
<div class="row">
    <div class="col-md-12">
        <div class="card-total">


            <div class="checkout-cart-total">

                <h4>{{__('checkout.billing.product')}}
                    <span>{{__('checkout.billing.total')}}</span></h4>
                <ul class='products-list' v-html="getViewsRowProduct(managerData.data)">

                </ul>
                <p class="tr-tax">{{__('shop-cart.product.tax')}}<span
                        class="tax-total"><?php echo "{{managerData.taxTotal}}" ?></span></p>
                <p>{{__('checkout.billing.sub-total')}} <span
                        class="subtotal"><?php echo "{{managerData.subTotal}}" ?></span></p>
                <p>{{__('checkout.billing.shipping-fee')}} <span
                        class="shipping"><?php echo "{{managerData.shipping}}" ?></span></p>

                <h4>{{__('checkout.billing.total-cart')}} <span
                        class="total"><?php echo "{{managerData.total}}" ?></span></h4>

            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="form-group" :class="getClassErrorForm('country_id',$v.model.attributes.country_id)">
            <label class='form__label'>{{__('checkout.form.country_id')}}*</label>
            {{ $dataManagerPage['countriesBillingAddress']}}
            <div class="content-message-errors">
                <b-form-invalid-feedback
                    :state="!$v.model.attributes.country_id.$error">
                                            <span v-if="!$v.model.attributes.country_id.required">
                                <?php echo "{{model.structure.country_id.required.msj}}" ?>
                            </span>

                </b-form-invalid-feedback>
            </div>
        </div>
    </div>
</div>
