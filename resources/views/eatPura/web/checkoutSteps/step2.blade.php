<!-- Billing Address -->
<h4 class="checkout-title">{{__('checkout.titles.step2')}}</h4>
@include('eatPura.web.checkoutSteps.delivery-address',array())
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="single-method">
            <input type="checkbox"
                   @change="_setValueForm('same_billing_address', $v.model.attributes.same_billing_address.$model)"
                   id="same_billing_address"
                   v-model.trim="$v.model.attributes.same_billing_address.$model">
            <label for="same_billing_address">{{__('checkout.form.same_billing_address')}} </label>

        </div>

    </div>

</div>
@include('eatPura.web.checkoutSteps.delivery-other-address',array())
