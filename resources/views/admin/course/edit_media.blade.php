<div class="row mb-3">
    <label for="thumbnail" class="form-label ol-form-label col-sm-2 col-form-label">{{get_phrase('Thumbnail')}}</label>
    <div class="col-sm-10">
        <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
    </div>
</div>

<div class="row mb-3">
    <label for="banner" class="form-label ol-form-label col-sm-2 col-form-label">{{get_phrase('Banner')}}</label>
    <div class="col-sm-10">
        <input type="file" name="banner" class="form-control ol-form-control" id="banner" accept="image/*" />
    </div>
</div>

<hr class="bg-secondary my-4">

<div class="row mb-3">
    @php
        $preview_video_type = str_contains($course_details->preview, 'youtu') ? 'youtube' : '';
        $preview_video_type = str_contains($course_details->preview, 'vimeo') && $preview_video_type == '' ? 'vimeo' : '';
        $preview_video_type = str_contains($course_details->preview, 'http') && $preview_video_type == '' ? 'html5' : '';
    @endphp
    <label for="preview_video_link" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Preview Video') }}</label>
    <div class="col-sm-10">
        <input type="radio" onchange="$('#preview_link_input').toggleClass('d-hidden'); $('#preview_file_input').toggleClass('d-hidden');" class="form-check-input" value="link" name="preview_video_provider" id="preview_video_link" @if($preview_video_type != '') checked @endif>&nbsp;<label for="preview_video_link">{{ get_phrase('Video Link') }}</label>
        &nbsp;&nbsp;
        <input type="radio" onchange="$('#preview_link_input').toggleClass('d-hidden'); $('#preview_file_input').toggleClass('d-hidden');" class="form-check-input" value="file" name="preview_video_provider" id="preview_video_file" @if($preview_video_type == '') checked @endif>&nbsp;<label for="preview_video_file">{{ get_phrase('Video File') }}
    </div>
</div>

<div class="row mb-3 @if($preview_video_type == '') d-hidden @endif" id="preview_link_input">
    <label for="preview_link" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Video link') }}</label>
    <div class="col-sm-10">
        <input type="text" name = "preview_link" id = "preview_link" class="form-control ol-form-control" value="{{ $course_details->preview }}">
        <small class="text-muted">{{get_phrase('Supported URL')}}: <b>{{get_phrase('Youtube')}}</b> {{get_phrase('or')}} <b>{{get_phrase('Vimeo')}}</b> {{get_phrase('or')}} <b>{{get_phrase('HTML5')}}</b></small>
    </div>
</div>

<div class="row mb-3 @if($preview_video_type != '') d-hidden @endif" id="preview_file_input">
    <label for="preview" class="form-label ol-form-label col-sm-2 col-form-label">{{get_phrase('Preview Video File')}}</label>
    <div class="col-sm-10">
        <input type="file" name="preview" class="form-control ol-form-control" id="preview" accept="video/*" />
        <small class="text-muted">{{get_phrase('Supported Video file')}}: <b>.{{get_phrase('mp4')}}</b> {{get_phrase('or')}} <b>.{{get_phrase('webm')}}</b> {{get_phrase('or')}} <b>.{{get_phrase('ogg')}}</b></small>
    </div>
</div>