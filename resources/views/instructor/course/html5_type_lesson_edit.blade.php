<input type="hidden" name="lesson_provider" value="html5">
<input type="hidden" name="lesson_type" value="html5">

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Video url') }}</label>
    <input value="{{ $lessons->lesson_src }}" type="text" id="html5_video_url" name="lesson_src" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter your html5 video url') }}">
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Duration') }}</label>
    <input default-seconds="{{ duration_to_seconds($lessons->duration) }}" class="form-control ol-form-control duration_picker" name="duration">
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Thumbnail') }}<small>({{ get_phrase('The image size should be') }})</small> </label>
    <div class="input-group">
        <div class="custom-file w-100">
            <input type="file" class="form-control ol-form-control" id="thumbnail" name="thumbnail" onchange="changeTitleOfImageUploader(this)">
        </div>
    </div>
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Caption') }}( {{ get_phrase('.vtt') }} )</label>
    <div class="input-group">
        <div class="custom-file w-100">
            <input type="file" class="form-control ol-form-control" id="caption" name="caption" onchange="changeTitleOfImageUploader(this)" accept=".vtt">
        </div>
    </div>
</div>

<script>
    "use strict";
    initializeDurationPickers([".duration_picker"]);
</script>
