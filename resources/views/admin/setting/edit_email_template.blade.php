@php
    $notification = App\Models\NotificationSetting::where('id', $id)->first();
@endphp
<form
    action="{{ route('admin.notification.settings.store', ['param1' => 'edit_email_template', 'id' => $notification->id]) }}"
    method="post">
    @csrf


    @foreach (json_decode($notification->subject, true) as $user_type => $subject)
        <div class="fpb-7 mb-3">
            <label class="form-label ol-form-label" for="{{ 'subject_label_' . $user_type }}">{{ get_phrase('Email subject') }}
                <small>({{ get_phrase('To ' . $user_type) }})</small></label>
            <input type="text" name="subject[{{ $user_type }}]" id="{{ 'subject_label_' . $user_type }}"
                value="{{ $subject }}" class="form-control ol-form-control">
        </div>
    @endforeach

    @foreach (json_decode($notification->template, true) as $user_type => $template)
        <div class="fpb-7 mb-3">
            <label class="form-label ol-form-label" for="{{ 'template_label_' . $user_type }} ">{{ get_phrase('Email template') }}
                <small>({{ get_phrase('To ' . $user_type) }})</small></label>

            <textarea name="template[{{ $user_type }}]" id="{{ 'template_label_' . $user_type }}"
                class="form-control ol-form-control text_editor" rows="4">{!! removeScripts($template) !!}</textarea>
        </div>
    @endforeach

    <div class="fpb-7 mb-3">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
    </div>
</form>

@include('admin.init')
