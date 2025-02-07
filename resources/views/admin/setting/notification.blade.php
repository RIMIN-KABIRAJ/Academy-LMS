<h4 class="title mt-4 mb-3">{{ get_phrase('Configure your notification settings') }}</h4>
@php
    $notify_settings = App\Models\NotificationSetting::get();
@endphp
<div class="row">
    <div class="col-md-12">

        @foreach ($notify_settings as $row)
            @php
                $system_notification = json_decode($row['system_notification'], true);
                $email_notification = json_decode($row['email_notification'], true);
            @endphp


            <div class="row mb-3">
                <div class="col-12">
                    <label class="m-0 p-0">
                        {{ get_phrase($row->setting_title) }}
                        @if ($row->is_editable != 1)
                            <small class="text-warning"><b>({{ get_phrase('Not editable') }})</b></small>
                        @endif

                    </label>
                    <p class="text-muted mb-1">
                        <small>{{ get_phrase($row->setting_sub_title) }}</small>
                    </p>
                </div>
                @foreach (json_decode($row->user_types, true) as $type)
                    <div class="col-auto">
                        <small class="form-label ol-form-label">{{ get_phrase('Configure for ' . $type) }}
                        </small>
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="form-check-input" id="{{ $row->id . $type }}_system" @if ($system_notification[$type]) checked @endif @if ($row->is_editable != 1) disabled @endif>
                            <label onclick="notification_enable_disable('{{ $row->id }}', '{{ $type }}', 'system')" class="form-check-label" for="{{ $row->id . $type }}_system">{{ get_phrase('System notification') }}
                            </label>
                        </div>

                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="form-check-input" id="{{ $row->id . $type }}_email" @if ($email_notification[$type]) checked @endif @if ($row->is_editable != 1) disabled @endif>
                            <label onclick="notification_enable_disable('{{ $row->id }}', '{{ $type }}', 'email')" class="form-check-label" for="{{ $row['id'] . $type }}_email">{{ get_phrase('Email notification') }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
