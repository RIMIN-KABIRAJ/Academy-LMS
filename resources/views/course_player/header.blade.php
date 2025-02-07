<div class="my-container">
    <div class="row">
        <div class="col-md-12">
            <div class="course-playing-header d-flex align-items-center justify-content-between py-1">
                <div class="course-play-logo">
                    <a href="{{ route('home') }}">
                        <img class="d-none d-lg-block" src="{{ asset(get_frontend_settings('light_logo')) }}"
                            alt="" height="40px">
                    </a>
                </div>
                <div class="playing-video-title py-2">
                    <p class="title text-16px mb-0">{{ ucfirst($course_details->title) }}</p>
                </div>
                <div class="playing-header-btns d-flex align-items-center">
                    <a href="javascript:void(0);" class="video-zoom-btn p-2" id="fullscreen">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_3_915)">
                                <path
                                    d="M8.08917 11.9108C8.415 12.2367 8.415 12.7633 8.08917 13.0892L2.845 18.3333H6.66667C7.1275 18.3333 7.5 18.7067 7.5 19.1667C7.5 19.6267 7.1275 20 6.66667 20H2.5C1.12167 20 0 18.8783 0 17.5V13.3333C0 12.8733 0.3725 12.5 0.833333 12.5C1.29417 12.5 1.66667 12.8733 1.66667 13.3333V17.155L6.91083 11.9108C7.23667 11.585 7.76333 11.585 8.08917 11.9108ZM17.5 0H13.3333C12.8725 0 12.5 0.373333 12.5 0.833333C12.5 1.29333 12.8725 1.66667 13.3333 1.66667H17.155L11.9108 6.91083C11.585 7.23667 11.585 7.76333 11.9108 8.08917C12.0733 8.25167 12.2867 8.33333 12.5 8.33333C12.7133 8.33333 12.9267 8.25167 13.0892 8.08917L18.3333 2.845V6.66667C18.3333 7.12667 18.7058 7.5 19.1667 7.5C19.6275 7.5 20 7.12667 20 6.66667V2.5C20 1.12167 18.8783 0 17.5 0Z"
                                    fill="#C7C7C7" />
                            </g>
                            <defs>
                                <clipPath id="clip0_3_915">
                                    <rect width="20" height="20" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </a>

                    @if(is_course_instructor($course_details->id) || auth()->user()->role == 'admin')
                        <a href="{{ route(auth()->user()->role.'.course.edit', ['id' => $course_details->id, 'tab' => 'curriculum']) }}" class="my-courses-btn d-none d-lg-block py-1 px-2">{{ get_phrase('Manage Course') }}</a>
                    @else
                        <a href="{{ route('my.courses') }}" class="my-courses-btn d-none d-lg-block py-1 px-2">{{ get_phrase('My Courses') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
