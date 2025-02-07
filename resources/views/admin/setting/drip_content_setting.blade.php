@extends('layouts.admin')
@push('title', get_phrase('Drip content settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $drip_info = json_decode(get_settings('drip_content_settings'));
    @endphp
    <div>
        <div class="mainSection-title ps-2px d-flex justify-content-between">
            <h4>{{ get_phrase('Drip Content Settings') }}</h4>
        </div>
        <div class="row">
            <div class="col-lg-7">
                <div class="ol-card p-4">
                    <div class="ol-card-body">
                        <div class="col-12 pt-3">
                            <p class="column-title">{{ get_phrase('Drip Content Settings') }}</p>
                        </div>
                        <form action="{{ route('admin.drip.settings.update') }}" method="post">
                            @csrf
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Lesson completion role') }}<span class="required">*</span></label>
                                <br>
                                <input class="form-check-input" type="radio" onchange="$('.toggleMinimumWatchField').toggleClass('d-hidden');" value="percentage" id="video_percentage_wise" name="lesson_completion_role" @if ($drip_info->lesson_completion_role == 'percentage') checked @endif>
                                <label class="form-label ol-form-label" for="video_percentage_wise">{{ get_phrase('Video percentage wise') }}</label>
                                &nbsp;&nbsp;
                                <input class="form-check-input" type="radio" onchange="$('.toggleMinimumWatchField').toggleClass('d-hidden');" value="duration" id="video_duration_wise" name="lesson_completion_role" @if ($drip_info->lesson_completion_role == 'duration') checked @endif>
                                <label class="form-label ol-form-label" for="video_duration_wise">{{ get_phrase('Video duration wise') }}</label>
                            </div>

                            <div class="fpb-7 mb-2 toggleMinimumWatchField @if ($drip_info->lesson_completion_role == 'percentage') d-hidden @endif  ">
                                <label class="form-label ol-form-label" for="minimum_duration">{{ get_phrase('Minimum duration to watch') }}<span>*</span></label>
                                <div class="input-group">
                                    <input type="text" value="{{ $drip_info->minimum_duration }}" id="minimum_duration" class="form-control ol-form-control" name="minimum_duration" data-toggle="timepicker" data-show-meridian="false">
                                    <div class="input-group-append">
                                        <span class="input-group-text ol-form-control">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M12 22.75C6.07 22.75 1.25 17.93 1.25 12C1.25 6.07 6.07 1.25 12 1.25C17.93 1.25 22.75 6.07 22.75 12C22.75 17.93 17.93 22.75 12 22.75ZM12 2.75C6.9 2.75 2.75 6.9 2.75 12C2.75 17.1 6.9 21.25 12 21.25C17.1 21.25 21.25 17.1 21.25 12C21.25 6.9 17.1 2.75 12 2.75Z" fill="#292D32" />
                                                <path d="M15.7101 15.93C15.5801 15.93 15.4501 15.9 15.3301 15.82L12.2301 13.97C11.4601 13.51 10.8901 12.5 10.8901 11.61V7.51001C10.8901 7.10001 11.2301 6.76001 11.6401 6.76001C12.0501 6.76001 12.3901 7.10001 12.3901 7.51001V11.61C12.3901 11.97 12.6901 12.5 13.0001 12.68L16.1001 14.53C16.4601 14.74 16.5701 15.2 16.3601 15.56C16.2101 15.8 15.9601 15.93 15.7101 15.93Z" fill="#292D32" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="fpb-7 mb-2 toggleMinimumWatchField @if ($drip_info->lesson_completion_role == 'duration') d-hidden @endif  ">
                                <label class="form-label ol-form-label" for="minimum_percentage">{{ get_phrase('Minimum percentage to watch') }}<span class="required">*</span></label>
                                <div class="input-group">
                                    <input type="text" value="{{ $drip_info->minimum_percentage }}" id="minimum_percentage" name="minimum_percentage" class="form-control ol-form-control">
                                    <div class="input-group-append">
                                        <span class="input-group-text ol-form-control">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m18.5 3.5l-15 15l2 2l15-15M7 4a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m10 10a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3Z" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="locked_lesson_message">{{ get_phrase('Message for locked lesson') }}</label>
                                <textarea name="locked_lesson_message" id = "locked_lesson_message" class="form-control ol-form-control" rows="5">{!! removeScripts($drip_info->locked_lesson_message) !!}</textarea>
                            </div>

                            <div class="fpb-7 mb-3">
                                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="alert alert-info" role="alert">
                    <h4 class="alert-heading">{{ get_phrase('Attention') }}!</h4>
                    <p class="mb-0">{{ get_phrase('The auto checkmark is only applicable for video lessons') }}.</p>
                    <a href="https://creativeitem.com/docs/academy-lms/drip-content-settings" target="_blank">{{ get_phrase('learn more') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        "use strict";
        $('#locked_lesson_message').summernote({
            height: 180, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true, // set focus to editable area after initializing summernote
            toolbar: [
                ['color', ['color']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['para', ['ul', 'ol']],
                ['table', ['table']],
                ['insert', ['link']]
            ]
        });
    </script>
@endpush
