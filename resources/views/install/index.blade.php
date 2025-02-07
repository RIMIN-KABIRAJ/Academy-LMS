<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Creativeitem Software Installation" />
    <meta name="author" content="Creativeitem" />
    <title>{{ __('Installation') . ' | ' . __('Academy Laravel') }}</title>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <!-- End meta -->

    <link rel="shortcut icon" href="{{ asset('assets/global/images/favicon.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendors/bootstrap/bootstrap.min.css') }}" />

    {{-- FlatIcons --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-thin-rounded/css/uicons-thin-rounded.css') }}" />

    {{-- Font awesome icons --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icon-picker/icons/fontawesome-all.min.css') }}" />

    {{-- Custom css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/custom.css') }}">

    <script type="text/javascript" src="{{ asset('assets/backend/js/jquery-3.7.1.min.js') }}"></script>


</head>

<body class="page-body">

    <div class="page-container horizontal-menu">

        <header class="navbar navbar-fixed-top ins-one bg-dark">
            <div class="container">
                <div class="navbar-inner">
                    <!-- logo -->
                    <div class="navbar-brand">
                        <a class="mt-1" href="#">
                            <img width="130px" src="{{ asset('assets/global/images/logo-light.png') }}" alt="">
                        </a>
                    </div>
                </div>
                <span class="logo_name ms-4 text-secondary">{{ __('Installation') }}</span>
            </div>
        </header>
        <div class="main_content container py-4">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('assets/backend/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    {{-- Summernote --}}
    <script src="{{ asset('assets/global/summernote/summernote-lite.min.js') }}"></script>

    {{-- Icon --}}
    <script src="{{ asset('assets/global/icon-picker/fontawesome-iconpicker.min.js') }}"></script>

    {{-- Jquery form --}}
    <script type="text/javascript" src="{{ asset('assets/global/jquery-form/jquery.form.min.js') }}"></script>

    {{-- Jquery UI --}}
    <script type="text/javascript" src="{{ asset('assets/global/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>

    {{-- Yaireo Tagify --}}
    <script src="{{ asset('assets/global/tagify-master/dist/tagify.min.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('assets/global/select2/select2.min.js') }}"></script>

    {{-- Date range picker --}}
    <script src="{{ asset('assets/backend/vendors/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/daterangepicker/daterangepicker.js') }}"></script>

    {{-- Html to PDF --}}
    <script src="{{ asset('assets/backend/js/html2pdf.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/backend/js/script.js') }}"></script>
</body>

</html>
