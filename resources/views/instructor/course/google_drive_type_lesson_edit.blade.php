<input type="hidden" name="lesson_type" value="google_drive">
<input type="hidden" name="lesson_provider" value="drive_video">

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Video url') }}</label>
    <input type="text" value="{{ $lessons->lesson_src }}" id="video_url" name="lesson_src" class="form-control ol-form-control">
    <small class="form-label text-danger text-12px d-hidden mb-0" id="invalid_url">{{ get_phrase('Invalid url') }}.
        {{ get_phrase('Your video source has to be either Google drive') }}</small>
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Duration') }}</label>
    <input default-seconds="{{ duration_to_seconds($lessons->duration) }}" id="duration" name="duration" class="form-control ol-form-control">
</div>

<script>
    "use strict";
    initializeDurationPickers(["#duration"]);
</script>
