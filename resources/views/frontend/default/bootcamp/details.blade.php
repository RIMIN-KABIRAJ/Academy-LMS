@extends('layouts.default')
@push('title', get_phrase('Bootcamp Details'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area playing-breadcum">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 px-4">
                    <div class="eNtry-breadcum mt-5">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $bootcamp_details->title }}
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="course-details pe-auto pe-lg-5">

                        <h2 class="g-title ellipsis-line-2">{{ $bootcamp_details->title }}</h2>
                        <p class="g-text text-dark ellipsis-line-2">
                            {{ $bootcamp_details->short_description }}
                        </p>

                        @php
                            $user = get_user_info($bootcamp_details->user_id);
                        @endphp

                        <ul class="course-motion-top">
                            <li>
                                <a class="d-flex align-items-center text-dark"
                                    href="{{ route('instructor.details', ['name' => slugify($user->name), 'id' => $user->id]) }}">
                                    <img class="pro-32" src="{{ get_image($user->photo) }}" alt="instructor-image">
                                    {{ $user->name }}
                                </a>
                            </li>
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="m-0 me-3">
                                    <path
                                        d="M18.3307 10.0003C18.3307 14.6003 14.5974 18.3337 9.9974 18.3337C5.3974 18.3337 1.66406 14.6003 1.66406 10.0003C1.66406 5.40033 5.3974 1.66699 9.9974 1.66699C14.5974 1.66699 18.3307 5.40033 18.3307 10.0003Z"
                                        stroke="#192335" stroke-width="1.25" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M13.0875 12.65L10.5042 11.1083C10.0542 10.8416 9.6875 10.2 9.6875 9.67497V6.2583"
                                        stroke="#192335" stroke-width="1.25" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                {{ date('d-M-Y', $bootcamp_details->publish_date) }}
                            </li>
                        </ul>
                        <ul class="course-motion-top bottom-motion mt-15">
                            <li>
                                <i class="fi fi-rr-book-alt color-2 d-inline-flex me-3 text-18"></i>
                                {{ $count_modules = count_bootcamp_modules($bootcamp_details->id) }}
                                {{ get_phrase($count_modules > 1 ? 'Modules' : 'Module') }}
                            </li>
                            <li>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="m-0 me-3">
                                    <path
                                        d="M1.67188 7.5V6.66667C1.67188 4.16667 3.33854 2.5 5.83854 2.5H14.1719C16.6719 2.5 18.3385 4.16667 18.3385 6.66667V13.3333C18.3385 15.8333 16.6719 17.5 14.1719 17.5H13.3385"
                                        stroke="#192335" stroke-width="1.25" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M3.07812 9.7583C6.92813 10.25 9.75313 13.0833 10.2531 16.9333" stroke="#192335"
                                        stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M2.1875 12.5586C5.0125 12.9169 7.08751 15.0003 7.45417 17.8253"
                                        stroke="#192335" stroke-width="1.25" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M1.65234 15.7168C3.06068 15.9001 4.10235 16.9335 4.28568 18.3501"
                                        stroke="#192335" stroke-width="1.25" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                {{ $count_modules = count_bootcamp_classes($bootcamp_details->id) }}
                                {{ get_phrase($count_modules > 1 ? 'Classes' : 'Class') }}
                            </li>
                            <li>
                                <img class="pro-20" src="{{ asset('assets/frontend/default/image/g2.png') }}"
                                    alt="...">
                                {{ total_enroll($bootcamp_details->id) }} {{ get_phrase('Students') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->


    <!-- Modal -->
    <div class="modal eModal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="g-title">{{ ucfirst($bootcamp_details->title) }}</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="player-body">
                        <div class="plyr__video-embed" id="player">
                            <video width="100%" height="440" poster="" id="videoPlayer" playsinline controls>
                                <source src="{{ asset($bootcamp_details->preview) }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------- Player Feature Area Start  --------->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 px-4">
                    <div class="hero-details pe-auto pe-lg-5">
                        <img src="{{ get_image($bootcamp_details->thumbnail) }}" alt="...">
                    </div>

                    <div class="row ">
                        <div class="col-lg-12 pe-auto pe-lg-5">
                            <div class="fDetails-tab static-menu mt-5 w-100">
                                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-overview-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-overview" type="button" role="tab"
                                            aria-controls="pills-overview"
                                            aria-selected="true">{{ get_phrase('Overview') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-course-content-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-course-content" type="button" role="tab"
                                            aria-controls="pills-course-content"
                                            aria-selected="false">{{ get_phrase('Course Content') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-details-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-details" type="button" role="tab"
                                            aria-controls="pills-details"
                                            aria-selected="false">{{ get_phrase('Details') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-instructor-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-instructor" type="button" role="tab"
                                            aria-controls="pills-instructor"
                                            aria-selected="false">{{ get_phrase('Instructor') }}</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content" id="pills-tabContent">
                                @include('frontend.default.bootcamp.overview_area')
                                @include('frontend.default.bootcamp.content_area')
                                @include('frontend.default.bootcamp.faq_area')
                                @include('frontend.default.bootcamp.requirement_outcome_area')
                                @include('frontend.default.bootcamp.instructor_area')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 px-4">
                    @include('frontend.default.bootcamp.pricing_card')
                </div>
            </div>
            <!------------------- Player Feature Area End  --------->
        </div>
    </section>
    <!------------------- Player Feature Area End  --------->
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#more_description').click(function(e) {
                e.preventDefault();

                let ellipsis = $('.description').attr('id');
                $('.description').toggleClass(ellipsis);

                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $(this).text('See less');
                } else {
                    $(this).html('See more <i class="fa-solid fa-angle-right me-2"></i>');
                }
            });

            $('#exampleModal').on('hidden.bs.modal', function() {
                $('#videoPlayer').get(0).pause();
            });
        });
    </script>
@endpush
