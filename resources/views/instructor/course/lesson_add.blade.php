@php
    $sections = App\Models\Section::where('course_id', $id)->orderBy('sort')->get();
@endphp

<div class="alert alert-primary ol-alert-primary ol-alert-sm mb-3" role="alert">
    <p class="title2 fs-14px d-flex align-items-center">{{ get_phrase('Lesson type') }}:
        @if ($lesson_type == 'html5')
            {{ get_phrase('Video url') . ' [.mp4]' }}
        @elseif ($lesson_type == 'video')
            {{ get_phrase('Video file') }}
        @elseif ($lesson_type == 'youtube' || $lesson_type == 'academy cloud' || $lesson_type == 'vimeo')
            {{ ucfirst(get_phrase($lesson_type)) }} {{ get_phrase('Video') }}
        @elseif($lesson_type == 'google_drive_video')
            {{ get_phrase('Google drive video') }}
        @elseif($lesson_type == 'document')
            {{ get_phrase('Document file') }}
        @else
            {{ ucfirst($lesson_type) }}
        @endif
        <a onclick="ajaxModal('{{ route('modal', ['instructor.course.lesson_type', 'id' => $id]) }}', '{{ get_phrase('Sort sections') }}')" class="btn text-primary ms-auto p-0" href="javascript:void(0)">{{ get_phrase('Change') }} <i class="fi-rr-arrow-alt-circle-right"></i></a>
    </p>
</div>

<!-- ACTUAL LESSON ADDING FORM -->
<form class="ajaxFormSubmission" action="{{ route('instructor.lesson.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="course_id" value="{{ $id }}">
    <input type="hidden" name="lesson_type" value="{{ $lesson_type }}">
    <div class="form-group mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
        <input type="text" name="title" class="form-control ol-form-control" required>
    </div>

    <div class="form-group mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Section') }}</label>
        <select class="form-control select2" data-toggle="select2" name="section_id" required>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}">{{ $section->title }}</option>
            @endforeach
        </select>
    </div>

    @if ($lesson_type == 'youtube')
        @include('instructor.course.youtube_type_lesson_add')
    @elseif ($lesson_type == 'academy_cloud')
        @include('instructor.course.academy_cloud_type_lesson_add')
    @elseif ($lesson_type == 'vimeo')
        @include('instructor.course.vimeo_type_lesson_add')
    @elseif ($lesson_type == 'html5')
        @include('instructor.course.html5_type_lesson_add')
    @elseif ($lesson_type == 'video')
        @include('instructor.course.video_type_lesson_add')
    @elseif ($lesson_type == 'amazon-s3')
        @include('amazon_s3_type_lesson_add.php')
    @elseif ($lesson_type == 'google_drive_video')
        @include('instructor.course.google_drive_type_lesson_add')
    @elseif ($lesson_type == 'document')
        @include('instructor.course.document_type_lesson_add')
    @elseif ($lesson_type == 'text')
        @include('instructor.course.text_type_lesson_add')
    @elseif ($lesson_type == 'image')
        @include('instructor.course.image_file_type_lesson_add')
    @elseif ($lesson_type == 'iframe')
        @include('instructor.course.iframe_type_lesson_add')
    @endif

    <div class="form-group mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Summary') }}</label>
        <textarea name="summary" class="form-control text_editor"></textarea>
    </div>


    <div class="form-group mb-3 d-none">
        <label class="form-label ol-form-label">{{ get_phrase('Do you want to keep it free as a preview lesson') }}
            ?</label>
        <br>
        <input type="checkbox" name="free_lesson" id="free_lesson" value="1" class="form-check-input">
        <label for="free_lesson">{{ get_phrase('Mark as free lesson') }}</label>
    </div>

    <div class="text-center">
        <button class="btn ol-btn-primary ol-btn-sm w-100 formSubmissionBtn" type="submit" name="button">{{ get_phrase('Add lesson') }}</button>
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
@include('instructor.init')
