<input type="hidden" name="lesson_type" value="vimeo-url">
<input type="hidden" name="lesson_provider" value="vimeo">

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Video url') }}</label>
    <input value="{{ $lessons->lesson_src }}" type="text" id="video_url" onblur="ajax_get_video_details(this.value)" name="lesson_src" class="form-control ol-form-control">
    <small class="form-label text-danger text-12px d-hidden mb-0" id="invalid_url">{{ get_phrase('Invalid url') }}. {{ get_phrase('Your video source has to be either Vimeo') }}</small>
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Duration') }}</label>
    <small class="form-label text-12px d-hidden mb-0" id="perloader"><i class="fi-rr-loading mdi-loading "></i> {{ get_phrase('Analyzing') }}....</small>
    <input value="@if (duration_to_seconds($lessons->duration) > 0) {{ $lessons->duration }}@else{{ '00:00:00' }} @endif" type="text" name="duration" id="duration" class="form-control ol-form-control" readonly>
</div>


<script>
    "use strict";
    initializeDurationPickers(["#duration"]);
</script>