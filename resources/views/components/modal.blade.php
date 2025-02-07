<head>
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/backend/vendors/bootstrap-5.1.3/css/bootstrap.min.css') }}" />
    <!-- Datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/daterangepicker.css') }}" />
    <!-- Select2 css -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/select2.min.css') }}" />

    {{-- FlatIcons --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/uicons-thin-rounded/css/uicons-thin-rounded.css') }}" />

    {{-- Font awesome icons --}}
    <link rel="stylesheet"
        href="{{ asset('assets/backend/css/font-awesome-icon-picker/fontawesome-iconpicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/css/fontawesome-all.min.css') }}" />




    {{-- Datatable --}}
    <link href="{{ asset('assets/backend/DataTables/datatables.min.css') }}" rel="stylesheet">

    {{-- File uploader --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/uploader/file-uploader.css') }}" />

    {{-- Yaireo Tagify --}}
    <link href="{{ asset('assets/backend/tagify-master/dist/tagify.css') }}" rel="stylesheet" type="text/css" />

    <!--Custom css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/custom.css') }}" />

    {{-- app --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/app.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/icons.min.css.map') }}" />
    {{-- plg --}}

</head>

<body>


    @props(['name', 'show' => false, 'maxWidth' => '2xl'])

    @php
        $maxWidth = [
            'sm' => 'sm:max-w-sm',
            'md' => 'sm:max-w-md',
            'lg' => 'sm:max-w-lg',
            'xl' => 'sm:max-w-xl',
            '2xl' => 'sm:max-w-2xl',
        ][$maxWidth];
    @endphp

    <div x-data="{
        show: @js($show),
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => !el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
    }" x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
        x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
        x-on:close.stop="show = false" x-on:keydown.escape.window="show = false"
        x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
        x-on:keydown.shift.tab.prevent="prevFocusable().focus()" x-show="show"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: {{ $show ? 'block' : 'none' }};">
        <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div x-show="show"
            class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            {{ $slot }}
        </div>
    </div>

    <script src="{{ asset('assets/backend/js/app.min.js') }}"></script>
    <!--Bootstrap bundle with popper-->
    <script src="{{ asset('assets/backend/vendors/bootstrap-5.1.3/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/swiper-bundle.min.js') }}"></script>
    <!-- Datepicker js -->
    <script src="{{ asset('assets/backend/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/daterangepicker.min.js') }}"></script>
    <!-- Select2 js -->
    <script src="{{ asset('assets/backend/js/select2.min.js') }}"></script>

    {{-- Summernote --}}
    <script src="{{ asset('assets/backend/js/vendor/plg/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/vendor/plg/demo.summernote.js') }}"></script>

    {{-- Datatable --}}
    <script src="{{ asset('assets/backend/DataTables/datatables.min.js') }}"></script>

    {{-- Icon --}}
    <script src="{{ asset('assets/backend/icon-picker/fontawesome-iconpicker.min.js') }}"></script>

    {{-- File uploader --}}
    <script src="{{ asset('assets/backend/uploader/file-uploader.js') }}"></script>

    {{-- Jquery form --}}
    <script type="text/javascript" src="{{ asset('assets/global/jquery-form/jquery.form.min.js') }}"></script>

    {{-- Yaireo Tagify --}}
    <script src="{{ asset('assets/backend/tagify-master/dist/tagify.min.js') }}"></script>

    <!--Custom Script-->
    <script src="{{ asset('assets/backend/js/script.js') }}"></script>
    <script src="{{ asset('assets/backend/js/custom.js') }}"></script>
</body>
