<div class="checkout-payment-method">
    <input
        v-model.trim="$v.model.attributes.type_payment.$model"
        type="hidden"

        v-focus-select
    >

    @if(isset($dataManagerPage['typePayments']) )
        {{$dataManagerPage['typePayments']}}
    @endif


</div>
