@extends('layouts.admin')
@push('title', get_phrase('Open Ai Settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Open AI Settings') }}
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('Manage your open ai settings') }}</h3>
                <div class="ol-card-body">
                    <form action="{{ route('admin.open.ai.settings.update') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label ol-form-label" for="">{{ get_phrase('Select ai model') }}</label>
                            <select class="ol-form-control ol-select2" name="open_ai_model">
                                <option value="gpt-3.5-turbo-0125" @if (get_settings('open_ai_model') == 'gpt-3.5-turbo-0125') selected @endif>gpt-3.5-turbo-0125</option>
                                <option value="gpt-4-0125-preview" @if (get_settings('open_ai_model') == 'gpt-4-0125-preview') selected @endif>gpt-4-0125-preview ({{ get_phrase('Required premium account') }})
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label ol-form-label" for="open_ai_max_token">{{ get_phrase('Max tokens') }}</label>
                            <input class="form-control ol-form-control" type="number" id="open_ai_max_token" value="{{ get_settings('open_ai_max_token') }}" name="open_ai_max_token" min="20"
                                max="2048" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label ol-form-label" for="ai_secret_key">{{ get_phrase('Secret key') }}</label>
                            <input class="form-control ol-form-control" type="text" id="open_ai_secret_key" value="{{ get_settings('open_ai_secret_key') }}" name="open_ai_secret_key"
                                required="">
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
