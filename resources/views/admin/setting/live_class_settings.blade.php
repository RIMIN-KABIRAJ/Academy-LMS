@extends('layouts.admin')
@push('title', get_phrase('Live class settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Live Class Settings') }}
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-7">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('Configure ZOOM server-to-server-oauth credentials') }}</h3>
                <div class="ol-card-body">
                    <form class="required-form" action="{{ route('admin.live.class.settings.update') }}" method="post">
                        @csrf

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="zoom_account_email">{{ get_phrase('Account Email') }}<span class="required">*</span></label>
                            <input type="email" name = "zoom_account_email" id = "zoom_account_email" class="form-control ol-form-control" value="{{ get_settings('zoom_account_email') }}" required>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="zoom_account_id">{{ get_phrase('Account ID') }}<span class="required">*</span></label>
                            <input type="text" name = "zoom_account_id" id = "zoom_account_id" class="form-control ol-form-control" value="{{ get_settings('zoom_account_id') }}" required>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="zoom_client_id">{{ get_phrase('Client ID') }}<span class="required">*</span></label>
                            <input type="text" name = "zoom_client_id" id = "zoom_client_id" class="form-control ol-form-control" value="{{ get_settings('zoom_client_id') }}" required>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="zoom_client_secret">{{ get_phrase('Client Secret') }}<span class="required">*</span></label>
                            <input type="text" name = "zoom_client_secret" id = "zoom_client_secret" class="form-control ol-form-control" value="{{ get_settings('zoom_client_secret') }}" required>
                        </div>

                        <hr>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="zoom_web_sdk_active">{{ get_phrase('Do you want to use Web SDK for your live class?') }}<span class="required">*</span></label><br>
                            <input type="radio" id="zoom_web_sdk_active" class="form-check-input" value="active" name="zoom_web_sdk" @if (get_settings('zoom_web_sdk') == 'active') checked @endif>
                            <label for="zoom_web_sdk_active" onclick="$('.web-ddk-credentials').show()">{{ get_phrase('Yes') }}</label>
                            &nbsp;&nbsp;
                            <input type="radio" id="zoom_web_sdk_inactive" class="form-check-input" value="inactive" name="zoom_web_sdk" @if (get_settings('zoom_web_sdk') == 'inactive') checked @endif>
                            <label for="zoom_web_sdk_inactive" onclick="$('.web-ddk-credentials').hide()">{{ get_phrase('No') }}</label>
                        </div>

                        <div class="web-ddk-credentials @if (get_settings('zoom_web_sdk') == 'inactive') d-hidden @endif">

                            <div class="fpb-7 mb-3" id="zoom_sdk_client_id">
                                <label class="form-label ol-form-label" for="zoom_sdk_client_id">{{ get_phrase('Meeting SDK Client ID') }}<span class="required">*</span></label>
                                <input type="text" name = "zoom_sdk_client_id" id = "zoom_sdk_client_id" class="form-control ol-form-control" value="{{ get_settings('zoom_sdk_client_id') }}" required>
                            </div>

                            <div class="fpb-7 mb-3" id="zoom_web_sdk_client_secret">
                                <label class="form-label ol-form-label" for="zoom_sdk_client_secret">{{ get_phrase('Meeting SDK Client Secret') }}<span class="required">*</span></label>
                                <input type="text" name = "zoom_sdk_client_secret" id = "zoom_sdk_client_secret" class="form-control ol-form-control" value="{{ get_settings('zoom_sdk_client_secret') }}" required>
                            </div>
                        </div>

                        <div class="fpb-7 mb-3">
                            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
