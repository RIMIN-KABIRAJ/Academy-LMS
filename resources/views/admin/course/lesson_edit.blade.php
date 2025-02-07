@php
    $lessons = App\Models\Lesson::where('id', $id)->first();
    $sections = App\Models\Section::where('course_id', $lessons->course_id)
        ->orderBy('sort')
        ->get();
    $select_section = App\Models\Section::where('id', $lessons->section_id)->value('title');
@endphp

<div class="alert alert-info d-flex align-items-center py-2" role="alert">
    {{ get_phrase('Lesson type') }}:
    @if ($lessons->lesson_type == 'html5')
        <strong class="text-capitalize ms-1">{{ get_phrase('Video url') . ' [.mp4]' }}</strong>
    @elseif ($lessons->lesson_type == 'system-video')
        <strong class="text-capitalize ms-1">{{ get_phrase('Video file') }}</strong>
    @elseif ($lessons->video_type == 'youtube' || $lessons->video_type == 'vimeo')
        <strong class="text-capitalize ms-1">{{ get_phrase($lessons->video_type) }} {{ get_phrase('Video') }} </strong>
    @elseif($lessons->lesson_type == 'google_drive_video')
        <strong class="text-capitalize ms-1">{{ get_phrase('Google drive video') }}</strong>
    @elseif($lessons->lesson_type == 'document_type')
        <strong class="text-capitalize ms-1">{{ get_phrase('Document file') }}</strong>
    @else
        <strong class="text-capitalize ms-1">{{ $lessons->lesson_type }}</strong>
    @endif
</div>

<!-- ACTUAL LESSON ADDING FORM -->
<form class="ajaxFormSubmission" action="{{ route('admin.lesson.edit') }}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="id" value="{{ $id }}">
    <input type="hidden" name="lesson_type" value="{{ $lessons->lesson_type }}">
    <div class="form-group eForm-group mb-2">
        <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
        <input type="text" name="title" class="form-control ol-form-control" value="{{ $lessons->title }}" required>
    </div>

    <div class="form-group mb-2">
        <label class="form-label ol-form-label">{{ get_phrase('Section') }}</label>
        <select class="form-control ol-select2" data-toggle="select2" name="section_id" required>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}" @if ($lessons->section_id == $section->id) selected @endif>
                    {{ $section->title }}</option>
            @endforeach
        </select>
    </div>

    @if ($lessons->lesson_type == 'video-url')
        @include('admin.course.youtube_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'vimeo-url')
        @include('admin.course.vimeo_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'system-video')
        @include('admin.course.video_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'html5')
        @include('admin.course.html5_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'google_drive')
        @include('admin.course.google_drive_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'document_type')
        @include('admin.course.document_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'text')
        @include('admin.course.text_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'image')
        @include('admin.course.image_file_type_lesson_edit')
    @elseif ($lessons->lesson_type == 'iframe')
        @include('admin.course.iframe_type_lesson_edit')
    @endif

    <div class="form-group mb-2">
        <label class="form-label ol-form-label">{{ get_phrase('summary') }}</label>
        <textarea name="summary" class="form-control text_editor">{{ $lessons->summary }}</textarea>
    </div>

    <div class="form-group mb-2 d-none">
        <label class="form-label ol-form-label">{{ get_phrase('Do you want to keep it free as a preview lesson') }} ?</label>
        <br>
        <input type="checkbox" name="free_lesson" id="free_lesson" value="1">
        <label for="free_lesson">{{ get_phrase('Mark as free lesson') }}</label>
    </div>

    <div class="text-center">
        <button class="btn ol-btn-primary ol-btn-sm w-100 formSubmissionBtn" type="submit"
            name="button">{{ get_phrase('Update lesson') }}</button>
    </div>
</form>

<script>
    'use strict';

    function ajax_get_video_details(url) {
        $('#perloader').show();
        if (checkURLValidity(url)) {
            $.ajax({
                url: "{{ route('get.video.details') }}",
                type: 'POST',
                data: {
                    url: url
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    jQuery('#duration').val(response.duration);
                    $('#perloader').hide();
                    $('#invalid_url').hide();
                }
            });
        } else {
            $('#invalid_url').show();
            $('#perloader').hide();
            jQuery('#duration').val('');

        }
    }

    function checkURLValidity(video_url) {
        var youtubePregMatch =
            /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        var vimeoPregMatch = /^(http\:\/\/|https\:\/\/)?(www\.)?(vimeo\.com\/)([0-9]+)$/;
        if (video_url.match(youtubePregMatch)) {
            return true;
        } else if (vimeoPregMatch.test(video_url)) {
            return true;
        } else {
            return false;
        }
    }
</script>

@include('admin.init')
