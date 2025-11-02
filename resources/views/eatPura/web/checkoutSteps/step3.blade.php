<h4 class="checkout-title">{{__('checkout.titles.step3')}}</h4>

@include('eatPura.web.checkoutSteps.payment-method',array())
@include('eatPura.web.checkoutSteps.order-summary',array())
@include('eatPura.web.checkoutSteps.privacy-policies',array())

