@extends('layouts' . '.' . get_frontend_settings('theme'))
@push('title', get_phrase('Forgot Password'))
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
                    <form action="{{ route('password.email') }}" class="global-form login-form mt-25" method="POST">
                        @csrf
                        <h4 class="g-title">{{ get_phrase('Forgot Password') }}</h4>
                        <p class="description">{{ get_phrase('Submit your account email address.') }} </p>
                        <div class="form-group">
                            <label for="email" class="form-label">{{ get_phrase('Email') }}</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="{{ get_phrase('Enter Your Email') }}">
                        </div>
                        <button type="submit" class="eBtn gradient w-100 mt-5">{{ get_phrase('Send Request') }}</button>
                        <a href="{{route('login')}}" class="eBtn gradient w-100 mt-5 text-center">{{ get_phrase('Back to login page') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Login Area End  ------>
@endsection
@push('js')

@endpush
