<h4 class="checkout-title">{{__('checkout.titles.step3')}}</h4>

@include('frontend.web.checkoutSteps.payment-method',array())
@include('frontend.web.checkoutSteps.order-summary',array())
@include('frontend.web.checkoutSteps.privacy-policies',array())

