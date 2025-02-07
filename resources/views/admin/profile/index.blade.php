@extends('layouts.admin')
@push('title', get_phrase('Manage profile'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $auth = auth()->user();
    @endphp

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Manage profile') }}</span>
                </h4>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-xl-7">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route('admin.manage.profile.update') }}" method="post" enctype="multipart/form-data">@csrf
                        <input type="hidden" name="type" value="general">
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Name') }}</label>
                            <input type="text" class="form-control ol-form-control" name="name" value="{{ $auth->name }}" required />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Email') }}</label>
                            <input type="email" class="form-control ol-form-control" name="email" value="{{ $auth->email }}" required />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Facebook link') }}</label>
                            <input type="text" class="form-control ol-form-control" name="facebook" value="{{ $auth->facebook }}" />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Twitter link') }}</label>
                            <input type="text" class="form-control ol-form-control" name="twitter" value="{{ $auth->twitter }}" />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Linkedin link') }}</label>
                            <input type="text" class="form-control ol-form-control" name="linkedin" value="{{ $auth->linkedin }}" />
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('A short title about yourself') }}</label>
                            <textarea rows="5" id="short-title" class="form-control ol-form-control" name="about" placeholder="{{ $auth->about }}"></textarea>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="skills">{{ get_phrase('Skills') }}</label>
                            <input type="text" name="skills" value="{{ $auth->skills }}" id="skills" class="tagify ol-form-control w-100" data-role="tagsinput">
                            <small class="text-muted">{{ get_phrase('Write your skill and click the enter button') }}</small>
                        </div>

                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Biography') }}</label>
                            <textarea rows="5" class="form-control ol-form-control text_editor" name="biography" placeholder="">{!! removeScripts($auth->biography) !!}</textarea>
                        </div>


                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Photo') }}
                                <small>({{ get_phrase('The image size should be any square image') }})</small>
                            </label>
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img class = "rounded-circle img-thumbnail image-50" src="{{ get_image($auth->photo) }}" >
                                </div>
                                <div class="col-10">
                                    <input type="file" class="form-control ol-form-control" name="photo" id="user_image" onchange="changeTitleOfImageUploader(this.id)" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="fpb7 mb-2">
                            <button type="submit" class="btn mt-4 ol-btn-primary">{{ get_phrase('Update profile') }}</button>
                        </div>
                    </form>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
        <div class="col-xl-5">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route('admin.manage.profile.update') }}" method="post"> @csrf
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Current password') }}</label>
                            <input type="password" class="form-control ol-form-control" name="current_password" required />
                        </div>
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('New password') }}</label>
                            <input type="password" class="form-control ol-form-control" name="new_password" required />
                        </div>
                        <div class="fpb7 mb-2">
                            <label class="form-label ol-form-label">{{ get_phrase('Confirm password') }}</label>
                            <input type="password" class="form-control ol-form-control" name="confirm_password" required />
                        </div>
                        <div class="fpb7 mb-2">
                            <button type="submit" class="ol-btn-primary">{{ get_phrase('Update password') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
