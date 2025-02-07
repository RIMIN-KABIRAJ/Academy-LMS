@php
    $payment_keys = json_decode($payment_gateway->keys, true);

    if ($payment_gateway->test_mode == 1) {
        $client_id = $payment_keys['sandbox_client_id'];
        $paypalURL = 'https://api.sandbox.paypal.com/v1/';
    } else {
        $client_id = $payment_keys['production_client_id'];
        $paypalURL = 'https://api.paypal.com/v1/';
    }
@endphp

<div id="smart-button-container">
    <div class="text-center">
        <div id="paypal-button-container"></div>
    </div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id={{ $client_id }}&enable-funding=venmo,card&currency={{ $payment_gateway->currency }}" data-sdk-integration-source="button-factory"></script>

<script>
    "use strict";

    function initPayPalButton() {
        paypal.Buttons({
            env: '<?php echo $payment_gateway->test_mode != 1 ? 'production' : 'sandbox'; ?>',
            style: {
                layout: 'vertical',  // Set to vertical layout
                label: 'paypal',
                size: 'large',      // small | medium | large | responsive
                shape: 'rect',      // pill | rect
                color: 'blue'       // gold | blue | silver | black
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $payment_details['payable_amount']; ?>',
                            currency_code: '{{$payment_gateway->currency}}'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    console.log(data);
                    window.location = "{{ $payment_details['success_url'] . '/' . $payment_gateway->identifier }}" +
                    "?payment_id=" + data.orderID + "&payer_id=" + details.payer.payer_id;
                });
            },
            onError: function(err) {
                console.error(err);
            }
        }).render('#paypal-button-container');
    }

    $(function() {
        const initPaypal = setInterval(function() {
            if (typeof paypal !== 'undefined') {
                initPayPalButton();
                clearInterval(initPaypal);
            }
        }, 500);
    });
</script>
