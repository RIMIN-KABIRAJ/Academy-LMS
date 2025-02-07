<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $system_name = \App\Models\Setting::where('type', 'system_name')->value('description');
        $system_favicon = \App\Models\Setting::where('type', 'system_fav_icon')->value('description');
    @endphp
    <title>{{ $system_name }}</title>
    <!-- all the meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- CSRF Token for ajax for submission -->
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <!-- all the css files -->
    <!-- fav icon -->
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/payment/style/vendors/bootstrap-5.1.3/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/payment/style/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/payment/style/css/custom.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/payment/style/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/payment/style/vendors/bootstrap-icons-1.8.1/bootstrap-icons.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/payment/style/css/own.css') }}" />
    <!--Main Jquery-->
    <script src="{{ asset('assets/payment/style/vendors/jquery/jquery-3.7.1.min.js') }}"></script>
    <style>
        .main_content {
            min-height: calc(100% - 50px);
            margin-top: 0px !important;
        }
        [data-bs-target="#doku"] img {
                height: 40px;
                width: auto;
            }

    </style>
</head>

<body class="pt-5">
    @if (session('app_url'))
        @include('payment.go_back_to_mobile_app')
    @endif

    <div class="main_content paymentContent">
        <div class="paymentHeader d-flex justify-content-between align-items-center">
            <h5 class="title">{{ get_phrase('Order summary') }}</h5>
            <a href="{{ $payment_details['cancel_url'] }}" class="btn btn-light text-sm"><i class="fi-rr-cross-small"></i> {{ get_phrase('Cancel Payment') }} </a>
        </div>
        @include('payment.payment_gateway')
    </div>
    <!--Bootstrap bundle with popper-->
    <script src="{{ asset('assets/payment/style/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/payment/style/js/swiper-bundle.min.js') }}"></script>
    <!-- Datepicker js -->
    <script src="{{ asset('assets/payment/style/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/payment/style/js/sweetalert2@11.js') }}"></script>
    <!-- toster file -->
    @include('frontend.default.toaster')
</body>

</html>
