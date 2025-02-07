@extends('layouts.default')
@push('title', get_phrase('Course Details'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $instructor_review = App\Models\Instructor_review::where('instructor_id', get_course_creator_id($course_details->id)->id)
            ->orderBy('id', 'DESC')
            ->get();

        $review = App\Models\Review::where('course_id', $course_details->id)
            ->orderBy('id', 'DESC')
            ->get();

        $total = $review->count();
        $rating = array_sum(array_column($review->toArray(), 'rating'));

        $average_rating = 0;
        if ($total != 0) {
            $average_rating = $rating / $total;
        }
    @endphp
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area page-content-pb-100 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 px-4">
                    <div class="eNtry-breadcum mt-4">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb d-flex flex-nowrap">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item ellipsis-line-1 active" aria-current="page">{{ $course_details->title }}
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="course-details pe-auto pe-lg-5">

                        <h2 class="g-title ellipsis-line-4">{{ $course_details->title }}</h2>
                        <p class="g-text text-dark ellipsis-line-2">
                            {{ ellipsis($course_details->short_description, 160) }}
                        </p>

                        <div class="row row-gap-4">
                            <div class="col-6 col-sm-6 col-md-4">
                                <a class="d-flex align-items-center text-dark" href="{{ route('instructor.details', ['name' => slugify($course_details->creator->name), 'id' => $course_details->creator->id]) }}">
                                    <img class="pro-32 me-2" src="{{ get_image(course_by_instructor($course_details->id)->photo) }}" alt="instructor-image">
                                    {{ course_by_instructor($course_details->id)->name }}
                                </a>
                            </div>
                            <div class="col-6 col-sm-6 col-md-4 text-dark">
                                <p class="d-flex align-items-center">
                                    @if ($total > 0)
                                        <span class="d-inline-block mx-2">{{ number_format(round($average_rating), 1) }}</span>
                                        @for ($i = 0; $i < $average_rating; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                    @else
                                        <i class="fi-rr-circle-star text-16px text-dark mt-2 ms-1"></i>
                                        <span class="d-inline-block mx-2">0</span>
                                        <i class="fa fa-star text-secondary"></i>
                                    @endif
                                </p>
                            </div>
                            <div class="col-6 col-sm-6 col-md-4 d-flex align-items-center text-dark">
                                <img class="pro-20 me-2" src="{{ asset('assets/frontend/default/image/language.png') }}" alt="...">
                                {{ ucfirst($course_details->language) }}
                            </div>
                            <div class="col-6 col-sm-6 col-md-4 d-flex align-items-center text-dark">
                                <img class="pro-20 me-2" src="{{ asset('assets/frontend/default/image/g3.png') }}" alt="...">
                                {{ get_phrase('Certificate Course') }}
                            </div>
                            <div class="col-6 col-sm-6 col-md-4 d-flex align-items-center text-dark">
                                <img class="pro-20 me-2" src="{{ asset('assets/frontend/default/image/g2.png') }}" alt="...">
                                {{ total_enroll($course_details->id) }} {{ get_phrase('Students') }}
                            </div>
                            <div class="col-6 col-sm-6 col-md-4 d-flex align-items-center text-dark">
                                <img class="pro-20 me-2" src="{{ asset('assets/frontend/default/image/g1.png') }}" alt="...">
                                {{ total_durations($course_details->id) }}
                            </div>
                        </div>

                        

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order-2 order-lg-1">

                     <div class="details-page-content">
                        <div class="ps-box static-menu mt-5 w-100">
                            <ul class="nav nav-bordered" id="pills-tab" role="tablist">
                                <li class="nav-item active" role="presentation">
                                    <button class="nav-link active" id="pills-overview-tab" data-bs-toggle="pill" data-bs-target="#pills-overview" type="button" role="tab" aria-controls="pills-overview" aria-selected="true">{{ get_phrase('Overview') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-course-content-tab" data-bs-toggle="pill" data-bs-target="#pills-course-content" type="button" role="tab" aria-controls="pills-course-content" aria-selected="false">{{ get_phrase('Curriculum') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-details-tab" data-bs-toggle="pill" data-bs-target="#pills-details" type="button" role="tab" aria-controls="pills-details" aria-selected="false">{{ get_phrase('Details') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-instructor-tab" data-bs-toggle="pill" data-bs-target="#pills-instructor" type="button" role="tab" aria-controls="pills-instructor" aria-selected="false">{{ get_phrase('Instructor') }}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">{{ get_phrase('Reviews') }}</button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-overview" role="tabpanel" aria-labelledby="pills-overview-tab" tabindex="0">
                                    @include('frontend.default.course.overview_area')
                                </div>
                                <div class="tab-pane fade" id="pills-course-content" role="tabpanel" aria-labelledby="pills-course-content-tab" tabindex="0">
                                    @include('frontend.default.course.content_area')
                                </div>
                                <div class="tab-pane fade" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab" tabindex="0">
                                    @include('frontend.default.course.requirement_outcome_area')
                                </div>
                                <div class="tab-pane fade" id="pills-instructor" role="tabpanel" aria-labelledby="pills-instructor-tab" tabindex="0">
                                    @include('frontend.default.course.instructor_area')
                                </div>
                                <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab" tabindex="0">
                                    @include('frontend.default.course.review_area')
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
                <div class="col-lg-4 order-1 order-lg-2">
                    @include('frontend.default.course.pricing_card')
                </div>
            </div>
            <!------------------- Player Feature Area End  --------->
        </div>
    </section>

    <!------------------- Breadcum Area End  --------->


    <!-- Vertically centered modal -->
    <div class="modal fade-in-effect" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <link rel="stylesheet" href="{{ asset('assets/global/plyr/plyr.css') }}">
                    @php
                        $preview_video_type = str_contains($course_details->preview, 'youtu') ? 'youtube' : '';
                        $preview_video_type = str_contains($course_details->preview, 'vimeo') && $preview_video_type == '' ? 'vimeo' : $preview_video_type;
                        $preview_video_type = str_contains($course_details->preview, 'http') && $preview_video_type == '' ? 'html5' : $preview_video_type;
                    @endphp

                    @if ($preview_video_type == 'youtube')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" src="{{ $course_details->preview }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @elseif ($preview_video_type == 'vimeo')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" id="promoPlayer" src="https://player.vimeo.com/video/{{ $course_details->preview }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @elseif($preview_video_type == 'html5')
                        <video id="promoPlayer" playsinline controls>
                            <source src="{{ $course_details->preview }}" type="video/mp4">
                        </video>
                    @else
                        <video id="promoPlayer" playsinline controls>
                            <source src="{{ asset($course_details->preview) }}" type="video/mp4">
                        </video>
                    @endif

                    <script src="{{ asset('assets/global/plyr/plyr.js') }}"></script>
                    <script>
                        "use strict";
                        const promoPlayer = new Plyr('#promoPlayer');
                    </script>

                </div>
            </div>
        </div>
    </div>

    <script>
        "use strict";
        const myModalElement = document.getElementById('exampleModal')
        myModalElement.addEventListener('hidden.bs.modal', event => {
            promoPlayer.pause();
            $('#exampleModal').toggleClass('in');
        });
        myModalElement.addEventListener('shown.bs.modal', event => {
            promoPlayer.play();
            $('#exampleModal').toggleClass('in');
        });
    </script>

@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('#more_description').on('click', function(e) {
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
        });
    </script>
@endpush
