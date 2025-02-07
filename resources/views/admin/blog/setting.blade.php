@extends('layouts.admin')
@push('title', get_phrase('Blog Setting'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Blog settings') }}</span>
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route('admin.blog.settings.update') }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Instructor permission') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="instructors_blog_permission" required>
                                <option value="">{{ get_phrase('Select an option') }}</option>
                                <option value="1" @if(get_frontend_settings('instructors_blog_permission') == 1) selected @endif>{{ get_phrase('Provide access') }}</option>
                                <option value="0" @if(get_frontend_settings('instructors_blog_permission') == 0) selected @endif>{{ get_phrase('Decline access') }}</option>
                            </select>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Visibility on homepage') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="blog_visibility_on_the_home_page" required>
                                <option value="">{{ get_phrase('Select an option') }}</option>
                                <option value="1" @if(get_frontend_settings('blog_visibility_on_the_home_page') == 1) selected @endif>{{ get_phrase('Visible') }}</option>
                                <option value="0" @if(get_frontend_settings('blog_visibility_on_the_home_page') == 0) selected @endif>{{ get_phrase('Hidden') }}</option>
                            </select>
                        </div>

                        <div class="fpb7 mb-3">
                            <button class="ol-btn-primary" type="submit">{{ get_phrase('Save changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')@endpush
