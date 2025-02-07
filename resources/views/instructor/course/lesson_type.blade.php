@php
    $course = App\Models\Course::where('id', $id)->first();

    $selected_lesson = 'youtube';
    if (isset($param3) && !empty($param3)) {
        $selected_lesson = $param3;
    }
@endphp

<div class="alert alert-primary ol-alert-primary ol-alert-sm mb-3" role="alert">
    <p class="title2 fs-14px">{{ get_phrase('Course') }}:
        <span class="title">{{ $course->title }}</span>
    </p>
</div>

<form action="">
    <input id="course_id_for_lesson" type="hidden" value="" name="course_id_for_lesson">
    <div class="ol-modal-form">
        <h6 class="title fs-16px mb-3">{{ get_phrase('Select lesson type') }}</h6>
        <div class="row row-12px row-cols-1 row-cols-sm-2 mb-20px">
            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-youtube">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/video-square-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('YouTube Video') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-youtube" value="youtube" @if ($selected_lesson == 'youtube') checked @endif>
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-vimeo">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/video-circle-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Vimeo Video') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-vimeo" value="vimeo" @if ($selected_lesson == 'vimeo') checked @endif>
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-videofile">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/video-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Video file') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-videofile" value="video" @if ($selected_lesson == 'video') checked @endif>
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-url">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/link-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Video url [ .mp4 ]') }}</p>
                    </div>
                    <input value="html5" class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-url">
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-drive">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/document-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Google drive video') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-drive" value="google_drive_video" @if ($selected_lesson == 'google_drive_video') {{ get_phrase('checked') }} @endif>
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-document">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/document-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Document file') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-document" value="document" @if ($selected_lesson == 'document') checked @endif>
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-text">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/text-block-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Text') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-text" value="text" @if ($selected_lesson == 'text') {{ get_phrase('checked') }} @endif>
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-image">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/volume-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Image') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-image" value="image" @if ($selected_lesson == 'image') {{ get_phrase('checked') }} @endif>
                </label>
            </div>


            <div class="col">
                <label class="ol-radiobox-1 d-flex align-items-center justify-content-between flex-wrap" for="radio-iframe">
                    <div class="title-icon d-flex align-items-center">
                        <img src="assets/images/icons/volume-black-18.svg" alt="">
                        <p class="title">{{ get_phrase('Iframe embed') }}</p>
                    </div>
                    <input class="form-check-input form-check-input-radio" type="radio" name="lesson_type" id="radio-iframe" value="iframe" @if ($selected_lesson == 'iframe') {{ get_phrase('checked') }} @endif>
                </label>
            </div>
        </div>
        <div class="mt-3">
            <a href="javascript:void(0)" type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" id="lesson-add-modal" onclick="showLessonAddModal()">{{ get_phrase('Next') }}
                <i class="fi-rr-angle-small-right"></i> </a>
        </div>
    </div>
</form>

<script type="text/javascript">
    "use strict";

    function showLessonAddModal() {
        var url = $("input[name=lesson_type]:checked").val();
        ajaxModal('{{ route('modal', ['instructor.course.lesson_add', 'id' => $course->id]) }}&lesson_type=' + url,
            '{{ get_phrase('Add new lesson') }}')
    }
</script>
