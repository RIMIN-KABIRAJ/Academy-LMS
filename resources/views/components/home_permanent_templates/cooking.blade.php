@extends('layouts.default')
@push('title', get_phrase('Home'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/lexend-deca/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/outfit/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/mulish/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/Poppins/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/dm-sens/stylesheet.css') }}">
    <style>
        .cooking-course-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .cooking-course-card-body {
            display: flex;
            flex-direction: column;
            height: 100%;
            justify-content: space-between;
        }
        .theme-text-color{
            color: #00907f;
        }
    </style>
@endpush
@section('content')
    @php
        $total_students = DB::table('users')->where('role', 'student')->get();
        $total_instructors = DB::table('users')->where('role', 'instructor')->get();
        $free_courses = DB::table('courses')->where('is_paid', 0)->get();
        $premium_courses = DB::table('courses')->where('is_paid', 1)->get();
    @endphp
    <!-- Banner Area Start -->
    <section class="cooking-banner-section">
        <div class="container">
            <div class="row row-28">
                <div class="col-lg-6 order-2 order-lg-1">
                    @php
                        $banner_title = get_frontend_settings('banner_title');
                        $arr = explode(' ', $banner_title);
                        $first_word = $arr[0];
                        $second_word = $arr[1] ?? '';
                        array_shift($arr);
                        array_shift($arr);
                        $remaining_text = implode(' ', $arr);
                    @endphp
                    <div class="cooking-banner-details">
                        <p class="light mb-0">{{ get_phrase('WELLCOME TO CHEF') }}</p>
                        <h1 class="title mb-20"><span class="highlight">{{ $first_word }}</span> <span class="small">{{ $second_word }} {{ $remaining_text }}</span></h1>
                        <p class="info mb-30 pe-5">{{ get_frontend_settings('banner_sub_title') }}</p>

                        <div class="d-flex align-items-center">
                            <a href="{{ route('courses') }}" class="rectangle-btn1">{{ get_phrase('Visit Courses') }}</a>
                            <a class="rectangle-btn2 ms-5 theme-text-color" data-bs-toggle="modal" data-bs-target="#promoVideo" href="#"><i class="ms-4 me-3 fa-solid fa-play"></i>
                                {{ get_phrase('Learn More') }}</a>
                        </div>

                        <ul class="cooking-banner-sponsors owl-carousel owl-theme cook_slider d-flex align-items-center flex-wrap">
                            <li>
                                <div class="item">
                                    <h1>{{ count($total_students) }}+</h1>
                                    <p>{{ get_phrase('Enrolled Learners') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <h1>{{ count($total_instructors) }}+</h1>
                                    <p>{{ get_phrase('Online Instructors') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <h1>{{ count($premium_courses) }}+</h1>
                                    <p>{{ get_phrase('Premium courses') }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <h1>{{ count($free_courses) }}+</h1>
                                    <p>{{ get_phrase('Cost-free course') }}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2">
                    <div class="cooking-banner-image">
                        @php
                            $bannerData = json_decode(get_frontend_settings('banner_image'));
                            $banneractive = get_frontend_settings('home_page');

                            if ($bannerData !== null && is_object($bannerData) && property_exists($bannerData, $banneractive)) {
                                $banner = json_decode(get_frontend_settings('banner_image'))->$banneractive;
                            }

                        @endphp
                        @if (isset($banner))
                            <img src="{{ asset($banner) }}" alt="">
                        @else
                            <img src="{{ asset('assets/frontend/default/image/cooking-banner.png') }}" alt="">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- Service Area Start -->
    <section>
        <div class="container">
            <div class="row mb-110">
                <div class="col-md-12">
                    <div class="cooking-services-area">
                        <div class="cooking-single-service">
                            <img src="{{ asset('assets/frontend/default/image/bulb-large.svg') }}" alt="">
                            <h5 class="title">{{ get_phrase('Latest Top Skills') }}</h5>
                            <p class="info">{{ get_phrase('Awesome  site the top advertising been business.') }}</p>
                        </div>
                        <div class="cooking-single-service">
                            <img src="{{ asset('assets/frontend/default/image/experts-large.svg') }}" alt="">
                            <h5 class="title">{{ get_phrase('Industry Experts') }}</h5>
                            <p class="info">{{ get_phrase('Awesome  site the top advertising been business.') }}</p>
                        </div>
                        <div class="cooking-single-service">
                            <img src="{{ asset('assets/frontend/default/image/world-large.svg') }}" alt="">
                            <h5 class="title">{{ get_phrase('Learning From Anywhere') }}</h5>
                            <p class="info">{{ get_phrase('Awesome  site the top advertising been business.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service Area End -->

    <!-- Top Rated Course Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cooking-section-title">
                        <h3 class="title-5 fs-32px lh-42px fw-600 text-center mb-20">{{ get_phrase('Top Rated Courses') }}</h3>
                        <p class="info">
                            {{ get_phrase('Top rated course showcases the highest-rated course based on student reviews and performance metrics.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row row-28 mb-110">
                @php
                    $top_courses = DB::table('courses')
                        ->leftJoin('payment_histories', 'courses.id', '=', 'payment_histories.course_id')
                        ->select('courses.id', 'courses.slug', 'courses.thumbnail', 'courses.title', 'courses.average_rating', 'courses.discount_flag', 'courses.is_paid', 'courses.price', 'courses.discounted_price', DB::raw('COUNT(payment_histories.id) as total_sales'))
                        ->groupBy('courses.id', 'courses.slug', 'courses.thumbnail', 'courses.title', 'courses.average_rating', 'courses.discount_flag', 'courses.is_paid', 'courses.price', 'courses.discounted_price')
                        ->orderByDesc('total_sales')
                        ->take(4) // Number of courses you want to get, e.g., top 4
                        ->get();
                @endphp
                @foreach ($top_courses as $key => $row)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ route('course.details', $row->slug) }}" class="cooking-course-link">
                            <div class="cooking-course-card">
                                <div class="banner">
                                    <img src="{{ get_image($row->thumbnail) }}" alt="">
                                </div>
                                <div class="cooking-course-card-body">
                                    <h5 class="title ellipsis-line-2">{{ ucfirst($row->title) }}</h5>
                                    <div class="time-rating d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="time-wrap d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/default/image/clock-gray-20.svg') }}" alt="">
                                            <p class=time>{{ total_durations('duration') }}</p>
                                        </div>
                                        <div class="rating-wrap d-flex align-items-center">
                                            <p class="rating">{{ number_format($row->average_rating, 1) }}</p>
                                            <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="author-price d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="author-wrap d-flex align-items-center">
                                            <img src="{{ course_instructor_image($row->id) }}" alt="">
                                            <p class="name">{{ course_by_instructor($row->id)->name }}</p>
                                        </div>
                                        @if (isset($row->is_paid) && $row->is_paid == 0)
                                            <h4 class="theme-text-color title-5 fs-20px lh-26px fw-600">{{ get_phrase('Free') }}</h4>
                                        @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                            <h4 class="theme-text-color title-5 fs-20px lh-26px fw-600">
                                                {{ currency(number_format($row->discounted_price, 2)) }}
                                            </h4>
                                            {{-- <del class="fs-14px fw-400">{{ currency(number_format($row->price, 2)) }}</del> --}}
                                        @else
                                            <h4 class="theme-text-color title-5 fs-20px lh-26px fw-600">{{ currency(number_format($row->price, 2)) }}</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Top Rated Course Area End -->

    <!-- Upcoming Course Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cooking-section-title">
                        <h3 class="title-5 fs-32px lh-42px fw-600 text-center mb-20">{{ get_phrase('Upcoming Courses') }}</h3>
                        <p class="info">
                            {{ get_phrase('Highlights the latest courses set to launch, giving students a sneak peek at new opportunities for learning and skill development. Stay ahead with our curated selection of upcoming educational offerings!') }}</p>
                    </div>
                </div>
            </div>

            <div class="row row-28 mb-110">
                @php
                    $upcoming_courses = DB::table('courses')->where('status', 'upcoming')->latest('id')->take(4)->get();
                @endphp
                @foreach ($upcoming_courses as $key => $row)
                    <div class="col-md-12">
                        <a href="{{ route('course.details', $row->slug) }}" class="cooking-course-list-link">
                            <div class="cooking-course-list-card d-flex align-items-center justify-content-between">
                                <div class="cooking-course-list-banner-title d-flex align-items-center">
                                    <div class="banner">
                                        <img src="{{ get_image($row->thumbnail) }}" alt="">
                                    </div>
                                    <div class="title-wrap">
                                        <h5 class="title">{{ $row->title }}</h5>
                                        <div class="author-wrap d-flex align-items-center">
                                            <img src="{{ course_instructor_image($row->id) }}" alt="">
                                            <p class="name">{{ course_by_instructor($row->id)->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="cooking-course-list-other d-flex">
                                    <div class="date-time">
                                        <div>
                                            <p class="info">{{ get_phrase('Lesson') }}</p>
                                            <p class="value">{{ lesson_count($row->id) }}</p>
                                        </div>
                                    </div>
                                    <div class="date-time">
                                        <div>
                                            <p class="info">{{ get_phrase('Duration') }}</p>
                                            <p class="value">{{ total_durations('duration') }}</p>
                                        </div>
                                    </div>
                                    <div class="date-time-price">
                                        <div>
                                            <p class="info">{{ get_phrase('Price') }}</p>
                                            @if (isset($row->discount_flag) && $row->discount_flag == 1)
                                                <p class="value">{{ currency(number_format($row->price - $row->discounted_price, 2)) }}</p>
                                            @elseif (isset($row->is_paid) && $row->is_paid == 0)
                                                <p class="value">{{ get_phrase('Free') }}</p>
                                            @else
                                                <p class="value">{{ currency(number_format($row->price, 2)) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Upcoming Course Area End -->

    <!-- Featured Course Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cooking-section-title">
                        <h3 class="title-5 fs-32px lh-42px fw-600 text-center mb-20">{{ get_phrase('Featured Courses') }}</h3>
                        <p class="info">
                            {{ get_phrase('Those course highlights a handpicked course with exceptional content or exclusive offerings.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row row-28 mb-110">
                @php
                    $featured_courses = DB::table('courses')->where('status', 'active')->latest('id')->take(4)->get();
                @endphp
                @foreach ($featured_courses->take(4) as $key => $row)
                    @php
                        $ratings = DB::table('reviews')
                            ->where('course_id', $row->id)
                            ->pluck('rating')
                            ->toArray();
                        $average_rating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : null;
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ route('course.details', $row->slug) }}" class="cooking-course-link">
                            <div class="cooking-course-card">
                                <div class="banner">
                                    <img src="{{ get_image($row->thumbnail) }}" alt="">
                                </div>
                                <div class="cooking-course-card-body">
                                    <h5 class="title ellipsis-line-2">{{ $row->title }}</h5>
                                    <div class="time-rating d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="time-wrap d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/default/image/clock-gray-20.svg') }}" alt="">
                                            <p class=time>{{ total_durations('duration') }}</p>
                                        </div>
                                        <div class="rating-wrap d-flex align-items-center">
                                            @if ($average_rating !== null)
                                                <p class="rating">{{ number_format($average_rating, 1) }}</p>
                                                <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="author-price d-flex align-items-center justify-content-between flex-wrap">
                                        <div class="author-wrap d-flex align-items-center">
                                            <img src="{{ course_instructor_image($row->id) }}" alt="">
                                            <p class="name">{{ course_by_instructor($row->id)->name }}</p>
                                        </div>
                                        @if (isset($row->is_paid) && $row->is_paid == 0)
                                            <h4 class="theme-text-color title-5 fs-20px lh-26px fw-600">{{ get_phrase('Free') }}</h4>
                                        @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                            <h4 class="theme-text-color title-5 fs-20px lh-26px fw-600">
                                                {{ currency(number_format($row->discounted_price, 2)) }}
                                            </h4>
                                            {{-- <del class="fs-14px fw-400">{{ currency(number_format($row->price, 2)) }}</del> --}}
                                        @else
                                            <h4 class="theme-text-color title-5 fs-20px lh-26px fw-600">{{ currency(number_format($row->price, 2)) }}</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Featured Course Area End -->

    <!-- Counter Area Start -->
    <section>
        <div class="container">
            <div class="row mb-110">
                <div class="col-md-12">

                    <div class="cooking-counter-area d-flex">
                        <div class="cooking-counter-single">
                            <h2 class="total fw-500"><span class="counter1">{{ count($total_students) }}</span>+</h2>
                            <p class="info">{{ get_phrase('Enrolled Learners') }}</p>
                        </div>
                        <div class="cooking-counter-single">
                            <h2 class="total fw-500"><span class="counter1">{{ count($total_instructors) }}</span></h2>
                            <p class="info">{{ get_phrase('Online Instructors') }}</p>
                        </div>
                        <div class="cooking-counter-single">
                            <h2 class="total fw-500"><span class="counter1">{{ count($premium_courses) }}</span>+</h2>
                            <p class="info">{{ get_phrase('Premium courses') }}</p>
                        </div>
                        <div class="cooking-counter-single">
                            <h2 class="total fw-500"><span class="counter1">{{ count($free_courses) }}</span>+</h2>
                            <p class="info">{{ get_phrase('Cost-free course') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Area End -->


    <!-- Motivational  Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title-2 mb-50px">
                        <h1 class="title-5 fs-32px lh-42px fw-600 mb-20px text-center">{{ get_phrase('Think more clearly') }}</h1>
                        <p class="subtitle-5 fs-15px lh-24px text-center">
                            {{ get_phrase('Awesome  site. on the top advertising a business online includes assembling Having the most keep.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row mb-50px">
                <div class="col-12">
                    <div class="lms-event-wrap1 eThink">
                        @php
                            $motivational_speeches = json_decode(get_frontend_settings('motivational_speech'), true);
                            $increment = 1;
                        @endphp
                        @foreach ($motivational_speeches as $key => $motivational_speech)
                            <div class="lms-event-single1 d-flex gap-2">
                                <div class="lms-event-number">
                                    @php
                                        $admininfo = DB::table('users')->where('role', 'admin')->first();

                                    @endphp
                                    <h1 class="title-5 fs-44px lh-29px fw-500">{{ $increment++ }}</h1>
                                </div>
                                <div class="event-details-banner-wrap w-100 d-flex">
                                    <div>
                                        <h3 class="title-5 fs-20px lh-26px fw-500 mb-14px">{{ $motivational_speech['title'] }}</h3>
                                        <div class="d-flex align-items-center gap-12px mb-20px">
                                            <div class="lms-author-sm">
                                                @if ($admininfo->photo)
                                                    <img src="{{ get_image($admininfo->photo) }}" alt="">
                                                @else
                                                    <img src="{{ asset('uploads/users/admin/placeholder/placeholder.png') }}" alt="">
                                                @endif
                                            </div>
                                            <div class="title-5 fs-13px lh-26px fw-medium">{{ $admininfo->name }}</div>
                                        </div>
                                        <p class="subtitle-5 fs-15px lh-25px">{{ $motivational_speech['description'] }}</p>
                                    </div>
                                    <div class="lms-event1-banner">
                                        @if ($motivational_speech['image'])
                                            <img class="rounded-0" src="{{ get_image($motivational_speech['image']) }}" alt="">
                                        @else
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Motivational Area End -->

    <!-- About Us Area Start -->
    <section class="pt-4">
        <div class="container pt-5">
            <div class="row g-20px mb-100px align-items-center">
                <div class="col-xl-5 col-lg-6 order-2 order-lg-1">
                    <div class="">
                        <h1 class="title-5 fs-32px lh-42px fw-600 mb-20px">{{ get_phrase('Know About Academy LMS Learning Platform') }}</h1>
                        <div>{!! ellipsis(removeScripts(get_frontend_settings('about_us')), 300) !!}</div>
                        <a href="{{ route('about.us') }}" class="rectangle-btn1 mt-5">{{ get_phrase('Learn More') }}</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 order-1 order-lg-2">
                    <div class="about-area-banner1">
                        <img src="{{ asset('assets/frontend/default/image/cooking-about-us.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Area End -->

    <!-- Become An Instructor Area Start -->
    @if ($instructor_speech = json_decode(get_homepage_settings('cooking')))
        <section>
            <div class="container">
                <div class="row mb-110">
                    <div class="col-md-12">
                        <div class="become-instructor-area d-flex align-items-center justify-content-between">
                            <div class="become-instructor-video-area">
                                @if (isset($instructor_speech->image))
                                    <img src="{{ asset('uploads/home_page_image/cooking/' . $instructor_speech->image) }}" alt="">
                                @else
                                @endif
                                <a href="javascript:void(0);" class="play-icon" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#becomeInstructor">
                                    <img src="{{ asset('assets/frontend/default/image/play-white-large.svg') }}" alt="">
                                </a>
                            </div>
                            <div class="become-instructor-details">
                                <h3 class="title-5 fs-32px lh-42px fw-600 mb-20">{{ $instructor_speech->title }}</h3>
                                <p class="info mb-30">{{ $instructor_speech->description }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Video Popup Modal Area Start -->
        <div class="modal fade instructor-video-modal" id="becomeInstructor" tabindex="-1" aria-labelledby="becomeInstructorLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="becomeInstructorLabel">{{ get_phrase('Video title') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="instructor-modal-video">
                            <div class="plyr__video-embed" id="becomeInstructorPlyr">
                                <iframe src="{{ $instructor_speech->video_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Video Popup Modal Area End -->
    @endif
    <!-- Become An Instructor Area End -->

    <!-- Popular Instructor Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="cooking-section-title">
                        <h3 class="title-5 fs-32px lh-42px fw-600 text-center mb-20">{{ get_phrase('Our Popular Instructor') }}</h3>
                        <p class="info">
                            {{ get_phrase('Highlights our most sought-after educator, recognized for their engaging teaching style and exceptional course content. Discover their expertise and join the many students who have benefited from their classes!') }}</p>
                    </div>
                </div>
            </div>
            <div class="row row-28 mb-110">
                @php
                    $popular_instaructors = DB::table('courses')->select('enrollments.user_id', DB::raw('count(*) as enrol_number'))->join('enrollments', 'courses.id', '=', 'enrollments.course_id')->groupBy('enrollments.user_id')->orderBy('enrollments.user_id', 'DESC')->limit(10)->get();
                @endphp
                @foreach ($popular_instaructors as $key => $instructor)
                    @php
                        $instructorDetails = App\Models\User::where('id', $instructor->user_id)->first();
                        if (!$instructorDetails) {
                            continue;
                        }
                    @endphp
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="cooking-popular-instructor">
                            <div class="profile-img">
                                <img src="{{ get_image($instructorDetails->photo) }}" alt="">
                            </div>
                            <div class="details">
                                <a href="{{ route('instructor.details', ['name' => slugify($instructorDetails->name), 'id' => $instructorDetails->id]) }}" class="w-100">
                                    <h5 class="name" style="line-height: 26px;">{{ $instructorDetails->name }}</h5>
                                    <p class="role">{{ get_phrase('Instructor') }}</p>
                                </a>
                                <ul class="popular-instructor-socila d-flex align-items-center justify-content-center flex-wrap">
                                    <li>
                                        <a href="{{ $instructorDetails->facebook }}">
                                            <svg width="8" height="15" viewBox="0 0 8 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <mask id="mask0_111_1949" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="8" height="15">
                                                    <path d="M7.53321 0.875488H0V14.812H7.53321V0.875488Z" fill="white" />
                                                </mask>
                                                <g mask="url(#mask0_111_1949)">
                                                    <path
                                                        d="M7.30463 0.875488C7.37937 0.902297 7.44278 0.953716 7.48445 1.02131C7.52612 1.0889 7.54357 1.16865 7.53395 1.24747C7.52782 1.9004 7.53395 2.5542 7.53395 3.20713C7.53395 3.47846 7.43679 3.57036 7.16284 3.57298C6.70509 3.57736 6.24646 3.58174 5.78871 3.59224C5.69363 3.59713 5.59968 3.61509 5.50951 3.64563C5.36852 3.68817 5.24635 3.77774 5.16338 3.89941C5.08041 4.02109 5.04163 4.16752 5.05351 4.31431C5.03863 4.83071 5.05351 5.34797 5.05351 5.88975H5.19705C5.82285 5.88975 6.44952 5.88975 7.07532 5.88975C7.13858 5.88831 7.2017 5.89627 7.26262 5.91338C7.30963 5.928 7.35136 5.95597 7.38275 5.99389C7.41414 6.03181 7.43383 6.07803 7.43942 6.12694C7.44422 6.16291 7.44627 6.19919 7.44555 6.23547C7.44555 6.95725 7.44555 7.67845 7.44555 8.39907C7.44712 8.46664 7.43429 8.53377 7.40791 8.596C7.37972 8.64837 7.33619 8.69086 7.28315 8.71777C7.23011 8.74468 7.17011 8.75472 7.1112 8.74654C6.53967 8.74654 5.96814 8.74654 5.39661 8.74654H5.04651V14.3341C5.04651 14.3656 5.04651 14.3971 5.04651 14.4295C5.04651 14.7131 4.94498 14.8137 4.66228 14.8137H2.47942C2.42509 14.8153 2.37075 14.8106 2.3175 14.7997C2.2613 14.7884 2.21035 14.759 2.17242 14.716C2.13449 14.673 2.11167 14.6188 2.10745 14.5616C2.10218 14.5076 2.10043 14.4532 2.10219 14.3989C2.10219 12.5748 2.10219 10.7511 2.10219 8.92771V8.74479H0.383219C0.337932 8.74605 0.292611 8.74429 0.247557 8.73954C0.185913 8.73335 0.128323 8.70598 0.0845949 8.66209C0.040867 8.6182 0.0137067 8.56051 0.0077405 8.49885C0.00184599 8.44918 -0.000785379 8.39919 -0.000136677 8.34918C-0.000136677 7.65949 -0.000136677 6.97009 -0.000136677 6.28098C-0.000136677 6.25385 -0.000136677 6.22672 -0.000136677 6.19958C-0.00334378 6.15743 0.00265811 6.11508 0.0174527 6.07548C0.0322472 6.03588 0.0554803 5.99997 0.0855401 5.97024C0.1156 5.94051 0.151767 5.91768 0.191532 5.90333C0.231298 5.88898 0.27371 5.88345 0.315826 5.88712C0.465492 5.88275 0.615158 5.88712 0.764825 5.88712H2.10044V5.73046C2.10044 5.19043 2.09519 4.65041 2.10832 4.11038C2.11458 3.5092 2.2736 2.91948 2.57045 2.39666C2.91731 1.78713 3.47374 1.32432 4.13626 1.0943C4.41868 0.992845 4.71273 0.927272 5.0115 0.89912C5.04158 0.893774 5.07116 0.885868 5.0999 0.875488L7.30463 0.875488Z"
                                                        fill="#00907F" />
                                                </g>
                                            </svg>
                                        </a>
                                    </li>
                                    <li><a href="{{ $instructorDetails->twitter }}">
                                            <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.8394 4.24582C15.214 9.86399 11.0943 14.3584 5.85069 14.3584C4.12691 14.4184 2.41057 14.1043 0.819802 13.4376C0.751673 13.4056 0.696919 13.3507 0.665049 13.2825C0.63318 13.2143 0.626209 13.1371 0.645348 13.0643C0.664487 12.9914 0.708526 12.9276 0.769815 12.8839C0.831104 12.8402 0.905771 12.8193 0.980846 12.8249C2.48538 12.8467 3.94769 12.3274 5.10149 11.3615C1.04474 10.0093 0.344545 4.99502 1.071 2.37893C1.09419 2.31371 1.13619 2.25683 1.1917 2.21548C1.24721 2.17412 1.31373 2.15015 1.38285 2.14659C1.45198 2.14304 1.52061 2.16005 1.58007 2.19548C1.63953 2.23091 1.68716 2.28318 1.71692 2.34567C2.96414 4.47338 5.3308 5.66196 8.29612 5.38801C8.02006 4.62049 8.0316 3.77892 8.32861 3.01926C8.62562 2.25961 9.18795 1.63338 9.91139 1.25665C10.6348 0.879922 11.4703 0.778231 12.263 0.970427C13.0557 1.16262 13.7518 1.63567 14.2224 2.3019L15.5125 2.11723C15.5841 2.10695 15.6571 2.11761 15.7228 2.14795C15.7885 2.17828 15.844 2.22697 15.8826 2.28815C15.9212 2.34933 15.9412 2.42038 15.9403 2.49271C15.9394 2.56504 15.9176 2.63557 15.8775 2.69576L14.8394 4.24582Z"
                                                    fill="#00907F" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $instructorDetails->linkedin }}">
                                            <i class="fa-brands fa-linkedin"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- Popular Instructor Area End -->

    <!-- Frequently Asked Questions Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 pb-5">
                    <h1 class="title-5 fs-32px lh-42px fw-600 mb-5">{{ get_phrase('Frequently Asked Questions?') }}</h1>
                </div>
            </div>
            <div class="two-accordion-wrap">
                <div class="row mb-110">
                    @php
                        $faqs = json_decode(get_frontend_settings('website_faqs'), true);
                        $faqs = count($faqs) > 0 ? $faqs : [['question' => '', 'answer' => '']];
                        $odd_faqs = array_filter(
                            $faqs,
                            function ($v, $k) {
                                return $k % 2 == 0;
                            },
                            ARRAY_FILTER_USE_BOTH,
                        );
                        $even_faqs = array_filter(
                            $faqs,
                            function ($v, $k) {
                                return $k % 2 != 0;
                            },
                            ARRAY_FILTER_USE_BOTH,
                        );
                    @endphp
                    <div class="col-md-6">
                        <div class="accordion qnaaccordion-two" id="accordionExampleLeft">
                            @foreach ($odd_faqs as $key => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeft{{ $key }}" aria-expanded="true" aria-controls="collapseLeft{{ $key }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h2>
                                    <div id="collapseLeft{{ $key }}" class="accordion-collapse collapse px-0 {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExampleLeft">
                                        <div class="accordion-body">
                                            <p class="answer">{{ $faq['answer'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="accordion qnaaccordion-two" id="accordionExampleRight">
                            @foreach ($even_faqs as $key => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRight{{ $key }}" aria-expanded="true" aria-controls="collapseRight{{ $key }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h2>
                                    <div id="collapseRight{{ $key }}" class="accordion-collapse collapse px-0 {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExampleRight">
                                        <div class="accordion-body">
                                            <p class="answer">{{ $faq['answer'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Frequently Asked Questions Area End -->
    @php
        use Carbon\Carbon;
    @endphp
    @if (get_frontend_settings('blog_visibility_on_the_home_page'))
        <!-- Latest News Area Start -->
        <section class="cooking-news-section">
            <div class="container">
                <div class="cooking-news-main-area">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cooking-section-title">
                                <h3 class="title-5 fs-32px lh-42px fw-600 text-center mb-20">{{ get_phrase('Follow The Latest News') }}</h3>
                                <p class="info">
                                    {{ get_phrase('The latest blog highlights the most recent articles, updates, and insights from our platform.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row row-28">

                        @foreach ($blogs as $key => $blog)
                            <div class="col-lg-6">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="list-news1-link">
                                    <div class="list-link1-card d-flex align-items-center">
                                        <div class="banner">
                                            <img class="h-230px" src="{{ get_image($blog->thumbnail) }}" alt="">
                                        </div>
                                        <div class="list-news1-card-body">
                                            <div class="date-wrap d-flex align-items-center">
                                                <img src="{{ asset('assets/frontend/default/image/calendar-green-14.svg') }}" alt="">
                                                <p class="date">{{ Carbon::parse($blog->created_at)->format('F j, Y') }}</p>
                                            </div>
                                            <h4 class="title">{{ ucfirst($blog->title) }}</h4>
                                            <p class="info mb-0 ellipsis-line-2">{{ ellipsis(strip_tags($blog->description), 160) }}</p>
                                            <div class="arrow mt-4">
                                                <img src="{{ asset('assets/frontend/default/image/arrow-right-green-20.svg') }}" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </section>
        <!-- Latest News Area End -->
    @endif


    <!-- Vertically centered modal -->
    <div class="modal fade-in-effect" id="promoVideo" tabindex="-1" aria-labelledby="promoVideoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <link rel="stylesheet" href="{{ asset('assets/global/plyr/plyr.css') }}">

                    @if (get_frontend_settings('promo_video_provider') == 'youtube')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" src="{{ get_frontend_settings('promo_video_link') }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @elseif (get_frontend_settings('promo_video_provider') == 'vimeo')
                        <div class="plyr__video-embed" id="promoPlayer">
                            <iframe height="500" id="promoPlayer" src="https://player.vimeo.com/video/{{ get_frontend_settings('promo_video_link') }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
                        </div>
                    @else
                        <video id="promoPlayer" playsinline controls>
                            <source src="{{ get_frontend_settings('promo_video_link') }}" type="video/mp4">
                        </video>
                    @endif

                    <script src="{{ asset('assets/global/plyr/plyr.js') }}"></script>
                    <script>
                        "use strict";
                        var promoPlayer = new Plyr('#promoPlayer');
                    </script>

                </div>
            </div>
        </div>
    </div>

    <script>
        "use strict";
        const myModalEl = document.getElementById('promoVideo')
        myModalEl.addEventListener('hidden.bs.modal', event => {
            promoPlayer.pause();
            $('#promoVideo').toggleClass('in');
        });
        myModalEl.addEventListener('shown.bs.modal', event => {
            promoPlayer.play();
            $('#promoVideo').toggleClass('in');
        });


        //instructor promo video modal
        var becomeInstructorPlyr = new Plyr('#becomeInstructorPlyr');
        const instructorModalEl = document.getElementById('becomeInstructor')
        instructorModalEl.addEventListener('hidden.bs.modal', event => {
            becomeInstructorPlyr.pause();
            $('#becomeInstructor').toggleClass('in');
        });
        instructorModalEl.addEventListener('shown.bs.modal', event => {
            becomeInstructorPlyr.play();
            $('#becomeInstructor').toggleClass('in');
        });
    </script>


@endsection
