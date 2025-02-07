@extends('layouts.default')
@push('title', get_phrase('Privacy Policy'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Start Breadcrumb -->
    <section class="py-56" data-background="{{ asset('assets/frontend/images/breadcrumb.png') }}">
        <div class="container">
            <ul class="ul-ol d-flex align-items-center cg-17 pb-20">
                <li class="d-flex align-items-center cg-12">
                    <div class="d-flex">
                        <img src="{{ asset('assets/frontend/images/icon/home.svg') }}" alt="" />
                    </div>
                    <p class="fz-16 fw-500 lh-30 text-white">{{ get_phrase('Home') }}</p>
                </li>
                <li class="d-flex align-items-center cg-12">
                    <div class="d-flex">
                        <img src="{{ asset('assets/frontend/images/icon/arrow-right-white.svg') }}" alt="" />
                    </div>
                    <p class="fz-16 fw-500 lh-30 text-white">{{ get_phrase('Privacy Policy') }}</p>
                </li>
            </ul>
            <h4 class="fz-56 fw-600 lh-64 text-white">{{ get_phrase('Privacy Policy') }} </h4>
        </div>
    </section>
    <!-- End Breadcrumb -->

    <!-- Start About Us -->
    <section class="course-details-wraper pb-120 pt-30">
        <div class="container description-style">
            {!! htmlspecialchars_decode(removeScripts(get_frontend_settings('privacy_policy'))) !!}
        </div>
    </section>
    <!-- End About Us -->
@endsection
@push('js')@endpush
