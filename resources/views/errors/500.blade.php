@extends('layouts.default')
@push('title', get_phrase('500 error found'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Start About Us -->
    <section class="pb-120 pt-30 description-style mt-5">
        <div class="container mt-5">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <img src="{{asset('assets/frontend/default/image/500.png')}}" alt="">
                </div>
                <div class="col-md-6 ms-auto">
                    <h1 class="g-title fs-28px mb-5 mt-5">{{ get_phrase('500 error found') }}</h1>
                    <p class="g-text mb-4">{{ get_phrase('A technical error has occurred') }}. {{ get_phrase('Please contact with site administrator') }}.</p>
                    <p class="mb-2 fw-bold">
                        {{ get_phrase('Contact Email') }} :
                        @php
                            $contact_info = json_decode(get_frontend_settings('contact_info'), true);
                            if (is_array($contact_info) && array_key_exists('email', $contact_info)) {
                                echo $contact_info['email'];
                            }
                        @endphp
                    </p>
                    <a class="eBtn gradient mt-5" href="{{route('home')}}">{{get_phrase('Back to home')}}</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us -->
@endsection
@push('js')@endpush
