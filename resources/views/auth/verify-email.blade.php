@extends('layouts' . '.' . get_frontend_settings('theme'))
@push('title', get_phrase('Email Verification'))
@push('meta')@endpush
@push('css')
@endpush
@section('content')
    <!------------------- Login Area Start  ------>
    <section class="login-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6">
                    <div class="login-img text-center">
                        <img class="w-75 h-auto ms-auto me-auto" src="{{ asset('assets/frontend/default/image/login.gif') }}" alt="...">
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <form action="{{ route('verification.send') }}" class="global-form login-form mt-25" method="POST">
                        @csrf
                        <h4 class="g-title">{{ get_phrase('Email Verification') }}</h4>
                        <p class="description">{{ get_phrase('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }} </p>

                        @if (session('status') == 'verification-link-sent')
                            <p class="description mt-4 text-success">{{ get_phrase('A new verification link has been sent to the email address you provided during registration.') }}</p>
                        @endif
                        
                        <button type="submit" class="eBtn gradient w-100 mt-5">{{ get_phrase('Resend Verification Email') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Login Area End  ------>
@endsection
@push('js')

@endpush

