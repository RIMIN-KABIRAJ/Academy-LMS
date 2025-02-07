@extends('layouts.admin')
@push('title', get_phrase('API Configurations'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="mainSection-title">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                    <div class="d-flex flex-column">
                        <h4>{{ get_phrase('API Configurations') }}</h4>
                        <ul class="d-flex align-items-center eBreadcrumb-2">
                            <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Settings') }}</a></li>
                            <li><a href="javascript:void(0)">{{ get_phrase('API Configurations') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="eSection-wrap-2">
                <div class="row g-2">
                    <div class="col-md-4">
                        <form action="{{ route('admin.api.configuration.update', ['type' => 'youtube_api_key']) }}" method="post">
                            @csrf
                            <label for="vimeo_api_key" class="form-label ol-form-label">{{ get_phrase('Youtube & Google Drive API key') }}</label>
                            <div class="input-group mb-3">
                                <input value="{{ get_settings('youtube_api_key') }}" type="text" class="form-control ol-form-control" name="youtube_api_key" id="youtube_api_key">
                                <button type="submit" class="input-group-text btn btn-success">{{ get_phrase('Update') }}</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form action="{{ route('admin.api.configuration.update', ['type' => 'vimeo_api_key']) }}" method="post">
                            @csrf
                            <label for="vimeo_api_key" class="form-label ol-form-label">{{ get_phrase('Vimeo API key') }}</label>
                            <div class="input-group mb-3">
                                <input value="{{ get_settings('vimeo_api_key') }}" type="text" class="form-control ol-form-control" name="vimeo_api_key" id="vimeo_api_key">
                                <button type="submit" class="input-group-text btn btn-success">{{ get_phrase('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin area -->
@endsection
