@extends('layouts.admin')
@push('title', get_phrase('System settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('System Settings') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-7">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('System Settings') }}</h3>
                <div class="ol-card-body">
                    <div class="col-lg-12">

                        <form class="required-form" action="{{ route('admin.system.settings.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="system_name">{{ get_phrase('Website name') }}<span>*</span></label>
                                <input type="text" name = "system_name" id = "system_name" class="form-control ol-form-control" value="{{ get_settings('system_name') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="system_title">{{ get_phrase('Website title') }}<span>*</span></label>
                                <input type="text" name = "system_title" id = "system_title" class="form-control ol-form-control" value="{{ get_settings('system_title') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label for="website_keywords" class="form-label ol-form-label">{{ get_phrase('Website keywords') }}</label>
                                <input type="text" class="form-control ol-form-control bootstrap-tag-input w-100" id = "website_keywords" name="website_keywords" data-role="tagsinput" value="{{ get_settings('website_keywords') }}" />
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="website_description">{{ get_phrase('Website description') }}</label>
                                <textarea name="website_description" id = "website_description" class="form-control ol-form-control" rows="5">{{ get_settings('website_description') }}</textarea>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="author">{{ get_phrase('Author') }}</label>
                                <input type="text" name = "author" id = "author" class="form-control ol-form-control" value="{{ get_settings('author') }}">
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="slogan">{{ get_phrase('Slogan') }}<span>*</span></label>
                                <input type="text" name = "slogan" id = "slogan" class="form-control ol-form-control" value="{{ get_settings('slogan') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="system_email">{{ get_phrase('System email') }}<span>*</span></label>
                                <input type="text" name = "system_email" id = "system_email" class="form-control ol-form-control" value="{{ get_settings('system_email') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="address">{{ get_phrase('Address') }}</label>
                                <textarea name="address" id = "address" class="form-control ol-form-control" rows="5">{{ get_settings('address') }}</textarea>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="phone">{{ get_phrase('Phone') }}</label>
                                <input type="text" name = "phone" id = "phone" class="form-control ol-form-control" value="{{ get_settings('phone') }}">
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="youtube_api_key">{{ get_phrase('Youtube API key') }}<span>*</span> &nbsp; <a href = "https://developers.google.com/youtube/v3/getting-started" target = "_blank" class="text-12px text-secondary">({{ get_phrase('Get YouTube API key') }} <i class="mdi mdi-open-in-new"></i>)</a></label>
                                <input type="text" name = "youtube_api_key" id = "youtube_api_key" class="form-control ol-form-control" value="{{ get_settings('youtube_api_key') }}" required>
                                <a href="https://support.google.com/googleapi/answer/6158841" target="_blank" class="text-12px text-secondary">
                                    {{ get_phrase('If you want to use Google Drive video, you need to enable the Google Drive service in this API') }}
                                </a>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="vimeo_api_key">{{ get_phrase('Vimeo API key') }}<span>*</span>
                                    &nbsp; <a href = "https://www.youtube.com/watch?v=Wwy9aibAd54" target = "_blank" class="text-12px text-secondary">({{ get_phrase('get Vimeo API key') }} <i class="mdi mdi-open-in-new"></i>)</a></label>
                                <input type="text" name = "vimeo_api_key" id = "vimeo_api_key" class="form-control ol-form-control" value="{{ get_settings('vimeo_api_key') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label for="purchase_code">{{ get_phrase('Purchase code') }}<span class="form-label ol-form-label">*</span></label>
                                <input type="text" name = "purchase_code" id = "purchase_code" class="form-control ol-form-control" value="{{ get_settings('purchase_code') }}" required>
                            </div>
                            
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="language">{{ get_phrase('System language') }}</label>
                                <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="language" id="language">
                                    @foreach(App\Models\Language::get() as $language)
                                        <option value="{{strtolower($language->name)}}" @if (get_settings('language') == strtolower($language->name)) selected @endif>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="fpb-7 mb-3 ">
                                <label class="form-label ol-form-label" for="course_selling_tax">{{ get_phrase('Course selling tax') }} (%)
                                    <span>*</span></label>
                                <div class="input-group">
                                    <input type="number" value="{{ get_settings('course_selling_tax') }}" min="0" max="100" id="course_selling_tax" name="course_selling_tax" class="form-control ol-form-control" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text ol-form-control">%</span>
                                    </div>
                                </div>
                                <small>{{ get_phrase('Enter 0 if you want to disable the tax option') }}</small>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="student_email_verification">{{ get_phrase('Student email verification') }}</label>
                                <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="student_email_verification" id="student_email_verification">
                                    <option value="0" @if (get_settings('student_email_verification') != 1) selected @endif>{{ get_phrase('Disabled') }}</option>
                                    <option value="1" @if (get_settings('student_email_verification') == 1) selected @endif>{{ get_phrase('Enabled') }}</option>
                                </select>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="device_limitation">{{ get_phrase('Device limitation') }}</label>
                                <input type="number" name="device_limitation" id="device_limitation" class="form-control ol-form-control" value="{{ get_settings('device_limitation') }}" required>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="footer_text">{{ get_phrase('Footer text') }}</label>
                                <input type="text" name = "footer_text" id = "footer_text" class="form-control ol-form-control" value="{{ get_settings('footer_text') }}">
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="footer_link">{{ get_phrase('Footer link') }}</label>
                                <input type="text" name = "footer_link" id = "footer_link" class="form-control ol-form-control" value="{{ get_settings('footer_link') }}">
                            </div>

                            <button type="submit" class="btn ol-btn-primary" onclick="checkRequiredFields()">{{ get_phrase('Save Changes') }}</button>
                        </form>


                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        <div class="col-xl-5">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('Update Product') }}</h3>
                <div class="ol-card-body">
                    <div class="col-lg-12">
                        <form action="{{ route('admin.product.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" class="">{{ get_phrase('File') }}</label>

                                <input type="file" class="form-control ol-form-control" id="file_name" name="file" required onchange="changeTitleOfImageUploader(this)">
                            </div>

                            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
                        </form>
                    </div>
                </div> <!-- end card body-->
            </div>
        </div>
    </div>
@endsection
@push('js')@endpush
