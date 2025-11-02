function initButtonPayPal(params) {
    var optionsConfig = params['configPayPal'];
    var selector = params['selector'];
    var selectorId = params['selectorId'];
    var objectPaypal = paypal.Button.render(optionsConfig, selector);
    payPalButton = document.getElementById(selectorId);
    payPalButton.style.display = "block";

}

function getConfigPayPal() {

    var optionsConfig = {
        env: $configPayments['pay-pal']['env'],
        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay',
            height: 40
        },
        onInit: function (data, actions) {
            // Disable the buttons
            actions.disable();
            // Listen for changes to the checkbox
            document.querySelector('#payment_bank')
                .addEventListener('change', function (event) {

                    // Enable or disable the button when it is checked or unchecked
                    if (event.target.checked) {
                        actions.enable();
                    } else {
                        actions.disable();
                    }
                });
        },
        // Set up the payment:
        // 1. Add a payment callback
        payment: function (data, actions) {
            // 2. Make a request to your server
            var $accessToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                'Authorization': 'Bearer ' + $accessToken,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            var dataSend = {
                params: getDataShop()
            };
            return actions.request.post('/api/createPaymentPayPalEvents', dataSend, {
                headers: headers
            })
                .then(function (res) {
                    // 3. Return res.id from the response
                    return res.id;
                });
        },
        // Execute the payment:
        // 1. Add an onAuthorize callback
        onAuthorize: function (data, actions) {
            // 2. Make a request to your server
            var dataSend = {
                params: getDataShopExecuteString({
                    typeManager: 'payPal',
                    'data': data

                })
            };
            var $accessToken = $('meta[name="csrf-token"]').attr('content');
            var headers = {
                'Authorization': 'Bearer ' + $accessToken,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            };
            console.log(dataSend);
            return actions.request.post('/api/executePaymentPayPalEvents', dataSend, {
                headers: headers
            })
                .then(function (res) {
                    // 3. Show the buyer a confirmation message.
                    if (res.success) {
                        showAlert('success', $configPayments['pay-pal']['messages']['onAuthorize']['success']);
                        resetAll();
                        managerCheckoutDetails(res);
                        /* actions.redirect();*/
                    } else {
                        showAlert('warning', res.msg);

                    }
                }).catch(function(error){
                    console.log('error',error)
                });
        },
        onCancel: function (data, actions) {
            // Show a cancel page or return to cart
            /*   console.log('cancel');
               actions.redirect();*/
        },
        onError: function (err) {
            // Show an error page here, when an error occurs
            console.log('error', err);
            showAlert('error', $configPayments['pay-pal']['messages']['onError']['error']);
        }
    };
    return optionsConfig;
}
