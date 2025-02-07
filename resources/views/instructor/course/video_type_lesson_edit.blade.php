<input type="hidden" name="lesson_type" value="system-video">
<input type="hidden" name="lesson_provider" value="system_video">

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Upload system video file') }}</label>
    <div class="input-group">
        <div class="custom-file w-100">
            <input type="file" class="form-control ol-form-control" id="system_video_file" name="system_video_file" onchange="changeTitleOfImageUploader(this)">
        </div>
    </div>
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Duration') }}</label>
    <input default-seconds="{{ duration_to_seconds($lessons->duration) }}" class="form-control ol-form-control duration-picker" id="duration" name="duration">
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Caption') }}( {{ get_phrase('.vtt') }})</label>
    <div class="input-group">
        <div class="custom-file w-100">
            <input type="file" class="form-control ol-form-control" id="caption" name="caption" onchange="changeTitleOfImageUploader(this)" accept=".vtt">
        </div>
    </div>
</div>

<script>
    "use strict";
    initializeDurationPickers([".duration-picker"]);
</script>
