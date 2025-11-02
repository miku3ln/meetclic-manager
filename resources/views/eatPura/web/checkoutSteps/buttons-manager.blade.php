<div class="footer">
    <div class="manager-buttons">

        <div
            class="manager-paypal"
            v-bind:class="validateForm()?'enabled-container':'disabled-container'"
            id="paypal-button-container"
            v-show="model.attributes.type_payment=='pay-pal'">

        </div>
        <button v-if="model.attributes.type_payment=='bank-deposit'"
                v-on:click="_saveModelBankDeposit()"
                :disabled="!validateForm()"
                class="theme-button theme-button--small theme-button--alt theme-button--register theme-button--payment"
                type="button">   {{__('checkout.buttons.submit')}}
        </button>
        <button v-if="model.attributes.type_payment=='payment_pay_phone'"
                v-on:click="_saveModelPayPhone()"
                :disabled="!validateForm()"
                class="theme-button theme-button--small theme-button--alt theme-button--register theme-button--payment"
                type="button">   {{__('checkout.buttons.submit')}}
        </button>
        @if($allowModalPaymentez)
            <button v-if="model.attributes.type_payment=='api-credit-cards'"
                    v-on:click="_saveModelPaymentez()"
                    :disabled="!validateForm()"
                    class="js-paymentez-checkout theme-button theme-button--small theme-button--alt theme-button--register theme-button--payment"
                    type="button">   {{__('checkout.buttons.submit')}}
            </button>
        @else
            <div v-init-paymentez="{initMethod:initPaymentez}"
                 v-if="model.attributes.type_payment=='api-credit-cards'"
                 class="paymentez-form" id="my-card"
                 data-invalid-card-type-message="Tarjeta invalida. Por favor ingresa una tarjeta Exito / Alkosto."
                 data-invalid-expiry-year-message="YEAR ERROR"
                 data-capture-name="true">

            </div>
            <div id="messages">

            </div>

            <button v-if="model.attributes.type_payment=='api-credit-cards'"
                    v-on:click="_saveModelPaymentez()"
                    :disabled="!validateForm()"
                    class="js-paymentez-checkout theme-button theme-button--small theme-button--alt theme-button--register theme-button--payment"
                    type="button">   {{__('checkout.buttons.submit')}}
            </button>
        @endif
    </div>
    <div id="container">
        <div id="cont">
            <div class="footer_center">

            </div>
        </div>
    </div>
</div>

<div class="buttons-manager">


</div>
