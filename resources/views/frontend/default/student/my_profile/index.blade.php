@extends('layouts.default')
@push('title', get_phrase('My profile'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------ My profile area start  ------------>
    <section class="course-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')
                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('Personal Information') }}</h4>
                    <div class="my-panel message-panel edit_profile">
                        <form action="{{ route('update.profile', $user_details->id) }}" method="POST">@csrf
                            <div class="row">
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label for="name" class="form-label">{{ get_phrase('Full Name') }}</label>
                                        <input type="text" class="form-control" name="name" value="{{ $user_details->name }}" id="name">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ get_phrase('Email Address') }}</label>
                                        <input type="email" class="form-control" name="email" value="{{ $user_details->email }}" id="email">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">{{ get_phrase('Phone Number') }}</label>
                                        <input type="tel" class="form-control" name="phone" value="{{ $user_details->phone }}" id="phone">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="website" class="form-label">{{ get_phrase('Website') }}</label>
                                        <input type="text" class="form-control" name="website" value="{{ $user_details->website }}" id="website">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="facebook" class="form-label">{{ get_phrase('Facebook') }}</label>
                                        <input type="text" class="form-control" name="facebook" value="{{ $user_details->facebook }}" id="facebook">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="twitter" class="form-label">{{ get_phrase('Twitter') }}</label>
                                        <input type="text" class="form-control" name="twitter" value="{{ $user_details->twitter }}" id="twitter">
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-20">
                                    <div class="form-group">
                                        <label for="linkedin" class="form-label">{{ get_phrase('Linkedin') }}</label>
                                        <input type="text" class="form-control" name="linkedin" value="{{ $user_details->linkedin }}" id="linkedin">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label for="skills" class="form-label">{{ get_phrase('Skills') }}</label>
                                        <input type="text" class="form-control tagify" name="skills" data-role="tagsinput" value="{{ $user_details->skills }}" id="skills">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-20">
                                    <div class="form-group">
                                        <label for="biography" class="form-label">{{ get_phrase('Biography') }}</label>
                                        <textarea name="biography" class="form-control" id="biography" cols="30" rows="5">{{ $user_details->biography }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="eBtn btn gradient mt-10">{{ get_phrase('Save Changes') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ My profile area end  ------------>
@endsection
@push('js')

@endpush
