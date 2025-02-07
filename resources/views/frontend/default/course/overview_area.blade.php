<div class="ps-box p-0 shadow-none">
    <h4 class="g-title">{{ get_phrase('Course Overview') }}</h4>
    <div class="description ellipsis-4" id="ellipsis-4">
        @if (isset($course_details->description))
            {!! removeScripts($course_details->description) !!}
        @else
            <p class="text-center">{{ get_phrase('No Course Description') }}</p>
        @endif
    </div>
    @if (isset($course_details->description))
        <a href="#" class="s_stext" id="more_description">
            {{ get_phrase('See more') }} <i class="fa-solid fa-angle-right me-2"></i>
        </a>
    @endif


</div>
@include('frontend.default.course.faq_area')