@php
    $page_data = $data['page_data'];
    $payment_details = $data['payment_details'];
    $color = $data['color'];
    $payment_gateway = DB::table('payment_gateways')->where('identifier', 'razorpay')->first();
@endphp

<button id="rzp-button1" hidden>{{ get_phrase('Pay') }}</button>

<form action="{{ route('payment.success', ['identifier' => 'razorpay']) }}" hidden>
    @csrf
    <input type="text" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="text" name="razorpay_order_id" id="razorpay_order_id">
    <input type="text" name="razorpay_signature" id="razorpay_signature">
    <input type="submit" id="payment_done">
</form>

<script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    "use strict";

    var color = "{{ $color }}";

    var options = {
        "key": "{{ $page_data['razorpay_id'] }}",
        "amount": "{{ $page_data['amount'] }}",
        "currency": "{{ $payment_gateway->currency }}",

        "name": "{{ $page_data['name'] }}",
        "description": "{{ $page_data['description'] }}",
        "image": "{{ get_image(auth()->user()->photo) }}",

        "order_id": "{{ $page_data['order_id'] }}",

        "handler": function(response) {
            var razorpay_payment_id = response.razorpay_payment_id;
            var razorpay_order_id = response.razorpay_order_id;
            var razorpay_signature = response.razorpay_signature;
            window.location.href = "{{$payment_details['success_url'] . '/' . $payment_gateway->identifier}}?razorpay_payment_id=" + response.razorpay_payment_id;
        },

        "prefill": {
            "name": "{{ $page_data['name'] }}",
            "email": "{{ $page_data['email'] }}",
            "contact": "{{ $page_data['phone'] }}"
        },
        "notes": {
            "address": "{{ $page_data['name'] }}"
        },
        "theme": {
            "color": color
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.on('payment.failed', function(response) {
        alert(response.error.description);
        alert(response.error.reason);
    });
    document.getElementById('rzp-button1').onclick = function(e) {
        rzp1.open();
        e.preventDefault();
    }

    $(document).ready(function() {
        $('#rzp-button1').trigger('click');
    });
</script>
