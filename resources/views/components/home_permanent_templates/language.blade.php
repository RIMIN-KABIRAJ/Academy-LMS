@extends('layouts.default')
@push('title', get_phrase('Home'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/lexend-deca/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/outfit/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/mulish/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/Poppins/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/dm-sens/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/rubik/stylesheet.css') }}">
@endpush
@section('content')
    @php
        $total_students = DB::table('users')->where('role', 'student')->get();
        $total_instructors = DB::table('users')->where('role', 'instructor')->get();
        $free_courses = DB::table('courses')->where('is_paid', 0)->get();
        $premium_courses = DB::table('courses')->where('is_paid', 1)->get();
    @endphp
    <!-- Banner Area Start -->
    <section>
        <div class="container">
            <div class="lms-banner-wrap-1">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        @php
                            $banner_title = get_frontend_settings('banner_title');
                            $arr = explode(' ', $banner_title);
                            $first_word = $arr[0];
                            $second_word = $arr[1] ?? '';
                            array_shift($arr);
                            array_shift($arr);
                            $remaining_text = implode(' ', $arr);
                        @endphp
                        <div class="lms-banner-content-1">
                            <p class="text-bordered-1 mb-6px">{{ get_phrase('Education For Eeveryone') }}</p>
                            <h1 class="title-1 fs-44px lh-60px mb-14px fw-600">{{ $first_word }} <span class="italic-1 fw-semibold">{{ $second_word }}</span> {{ $remaining_text }}
                            </h1>
                            <p class="subtitle-1 fs-16px lh-24px mb-3">{{ get_frontend_settings('banner_sub_title') }}</p>
                            <form action="{{ route('courses') }}" method="get">
                                <div class="lms-subscribe-form-1 d-flex gap-2 align-items-center flex-wrap">
                                    <input type="text" name="search" class="form-control form-control-1" placeholder="{{ get_phrase('Search here') }}" @if (request()->has('search')) value="{{ request()->input('search') }}" @endif>
                                    <button type="submit" class="btn btn-primary-1">{{ get_phrase('Search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <div class="lms-banner-area-1 d-flex flex-sm-row flex-column">
                            <div class="lms-banner-1">
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
                                    <img src="{{ asset('assets/frontend/default/image/language-banner.webp') }}" alt="">
                                @endif
                            </div>
                            <div class="mt-auto mb-30px lms-banner-items1">
                                <div class="mb-40px">
                                    <h2 class="title-1 fs-44px lh-60px fw-semibold mb-1">{{ count($total_students) }}+</h2>
                                    <p class="subtitle-1 fs-16px lh-24px">{{ get_phrase('User already register and signing up for using it') }}</p>
                                </div>
                                <div>
                                    <h2 class="title-1 fs-44px lh-60px fw-semibold mb-1">{{ count($total_instructors) }}+</h2>
                                    <p class="subtitle-1 fs-16px lh-24px">{{ get_phrase('Online Instructor have a new ideas every week.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- Service Area Start -->
    <section>
        <div class="container">
            <div class="row g-4 mb-100px">
                <div class="col-lg-4 col-md-6">
                    <div class="lms-service-card-1">
                        <img class="service-card-icon1" src="{{ asset('assets/frontend/default/image/bulb-blue-75.svg') }}" alt="">
                        <h5 class="title-2 fs-18px lh-28px fw-semibold text-center mb-12">{{ get_phrase('Latest Top Skills') }}</h5>
                        <p class="subtitle-1 fs-16px lh-24px text-center">{{ get_phrase('Awesome  site the top advertising been business.') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="lms-service-card-1">
                        <img class="service-card-icon1" src="{{ asset('assets/frontend/default/image/peoples-star-blue-76.svg') }}" alt="">
                        <h5 class="title-2 fs-18px lh-28px fw-semibold text-center mb-12">{{ get_phrase('Industry Experts ') }}</h5>
                        <p class="subtitle-1 fs-16px lh-24px text-center">{{ get_phrase('Awesome  site the top advertising been business.') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="lms-service-card-1">
                        <img class="service-card-icon1" src="{{ asset('assets/frontend/default/image/world-blue-69.svg') }}" alt="">
                        <h5 class="title-2 fs-18px lh-28px fw-semibold text-center mb-12">{{ get_phrase('Learning From Anywhere') }}</h5>
                        <p class="subtitle-1 fs-16px lh-24px text-center">{{ get_phrase('Awesome  site the top advertising been business.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Service Area End -->

    <!-- Course Area Start -->
    <section>
        <div class="container">
            <!-- Section Title -->
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-1 fs-32px lh-36px text-center mb-30">{{ get_phrase('Special Featured Course.') }}</h1>
                </div>
            </div>
            <div class="row row-20 mb-100px">
                @php
                    $featured_courses = DB::table('courses')->where('status', 'active')->latest('id')->get();
                @endphp

                @foreach ($featured_courses->take(4) as $key => $row)
                    <div class="col-lg-6">
                        <a href="{{ route('course.details', $row->slug) }}" class="d-block h-100 w-100 max-sm-350px">
                            <div class="lms-1-card">
                                <div class="lms-1-card-body">
                                    <div class="d-flex gap-3 align-items-center flex-sm-row flex-column">
                                        <div class="list-view-banner1">
                                            <img src="{{ get_image($row->thumbnail) }}" alt="">
                                        </div>
                                        <div class="list-view-details1 w-100">
                                            <h5 class="title-1 fs-20px lh-28px fw-semibold mb-6px title-1 fs-20px lh-28px fw-semibold mb-6px ellipsis-line-2">{{ ucfirst($row->title) }}</h5>
                                            <div class="card-rating-reviews1 mb-20 d-flex align-items-center flex-wrap">
                                                @php
                                                    $ratings = DB::table('reviews')
                                                        ->where('course_id', $row->id)
                                                        ->pluck('rating')
                                                        ->toArray();
                                                    $average_rating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;
                                                    $full_stars = floor($average_rating);
                                                    $has_half_star = $average_rating - $full_stars >= 0.5;
                                                    $review_count = count($ratings);
                                                @endphp
                                                @if ($review_count > 0)
                                                    <div class="d-flex align-items-center gap-1">
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $full_stars)
                                                                <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="Full Star">
                                                            @elseif ($i == $full_stars && $has_half_star)
                                                                <img src="{{ asset('assets/frontend/default/image/star-yellow-half-14.svg') }}" alt="Half Star">
                                                            @else
                                                                <img src="{{ asset('assets/frontend/default/image/star.svg') }}" alt="Empty Star">
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <p class="subtitle-1 fs-14px lh-20px">({{ $review_count }} {{ get_phrase('Reviews') }})</p>
                                                @endif
                                            </div>
                                            <div class="card-programs-1 mb-20 d-flex align-items-center gap-2">
                                                <div class="card-flug-sm">
                                                    <i class="fi-rr-book-open-cover"></i>
                                                </div>
                                                <p class="subtitle-1 fs-14px lh-20px">{{ lesson_count($row->id) }} {{ get_phrase('lesson') }}</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="card-author-sm">
                                                        <img src="{{ course_instructor_image($row->id) }}" alt="">
                                                    </div>
                                                    <div class="title-1 fs-14px fw-medium">{{ course_by_instructor($row->id)->name }}</div>
                                                </div>
                                                @if (isset($row->is_paid) && $row->is_paid == 0)
                                                    <h4 class="title-1 fs-20px lh-28px fw-semibold">{{ get_phrase('Free') }}</h4>
                                                @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                                    <h4 class="title-1 fs-20px lh-28px fw-semibold">
                                                        {{ currency(number_format($row->discounted_price, 2)) }}
                                                        <del class="fs-14px text-secondary">{{ currency($row->price) }}</del>
                                                    </h4>
                                                @else
                                                    <h4 class="title-1 fs-20px lh-28px fw-semibold">{{ currency(number_format($row->price, 2)) }}</h4>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="col-lg-12">
                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('courses') }}" class="btn btn-outline-primary-1">{{ get_phrase('View More') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Course Area End -->

    <!-- About Us Area Start -->
    <section>
        <div class="container">
            <div class="row g-20px mb-100px align-items-center">
                <div class="col-xl-5 col-lg-6 order-2 order-lg-1">
                    <div>
                        <p class="text-bordered-1 mb-12px">{{ get_phrase('ABOUT US') }}</p>
                        <h1 class="title-1 fs-32px lh-38px mb-20px">{{ get_phrase('Know About Academy LMS Learning Platform') }}</h1>
                        <p class="subtitle-1 fs-16px lh-24px mb-26px">
                            {{ get_phrase('Far far away, behind the word mountains, far from the away countries Vokalia and Consonantia, there live the blind texts.') }}</p>
                        <div class="about-text-items ellipsis-line-12 mb-26px">
                            {!! ellipsis(removeScripts(get_frontend_settings('about_us')), 160) !!}
                        </div>
                        <a href="{{ route('about.us') }}" class="btn btn-primary-2">{{ get_phrase('Learn More') }}</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 order-1 order-lg-2">
                    <div class="about-area-banner1">
                        <img src="{{ asset('assets/frontend/default/image/language-banner2.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us Area End -->

    <!-- Form and Why choose Area Start -->
    <section>
        <div class="container">
            <div class="row g-20px mb-100px align-items-center">
                <div class="col-lg-6">
                    <div class="me-lg-3 signup-form-wrap">
                        <!-- Card -->
                        <div class="">
                            <img src="{{ asset('assets/frontend/default/image/learning_vector.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div>
                        <p class="text-bordered-1 mb-12px">{{ get_phrase('WHY CHOOSE US') }}</p>
                        <h1 class="title-1 fs-32px lh-38px mb-20px">{{ get_phrase('Free Resources Learning English for Beginner') }}</h1>
                        <p class="subtitle-1 fs-16px lh-24px mb-30px">
                            {{ get_phrase('Far far away, behind the word mountains, far from the away countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.') }}
                        </p>
                        <div class="d-flex justify-content-center gap-20px flex-wrap flex-sm-nowrap">
                            <div class="bgcolor-card-1 bg-color-ffeff8-f6f0f4">
                                <h2 class="title-1 fs-44px lh-60px fw-semibold mb-1">{{ count($total_students) }}+</h2>
                                <p class="title-1 fs-16px lh-24px fw-normal">{{ get_phrase('User already register and signing up for using it') }}</p>
                            </div>
                            <div class="bgcolor-card-1 bg-color-e8f7fc-f1f9fc">
                                <h2 class="title-1 fs-44px lh-60px fw-semibold mb-1">{{ count($total_instructors) }}+</h2>
                                <p class="title-1 fs-16px lh-24px fw-normal">{{ get_phrase('Instructor have a new ideas every week.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Form and Why choose Area End -->

    <!-- Member Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-1 fs-32px lh-36px text-center mb-30">{{ get_phrase('Meet Our Team') }}</h1>
                </div>
            </div>
            <div class="row g-20px mb-100px">
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
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="lms-1-card max-sm-350px">
                            <div class="lms-1-card-body p-12px">
                                <div class="grid-view-banner1 mb-12px">
                                    <a href="{{ route('instructor.details', ['name' => slugify($instructorDetails->name), 'id' => $instructorDetails->id]) }}">
                                        <img src="{{ get_image($instructorDetails->photo) }}" alt="">
                                    </a>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between gap-1">
                                        <a href="{{ route('instructor.details', ['name' => slugify($instructorDetails->name), 'id' => $instructorDetails->id]) }}">
                                            <h5 class="title-1 fs-16px lh-24px fw-semibold mb-1">{{ $instructorDetails->name }}</h5>
                                            <p class="subtitle-1 fs-14px lh-20px">{{ get_phrase('Instructor') }}</p>
                                        </a>
                                        <div class="d-flex gap-1">
                                            <a href="{{ $instructorDetails->facebook }}" class="social-link-1">
                                                <img src="{{ asset('assets/frontend/default/image/lg-facebook.svg ') }}" alt="">
                                            </a>
                                            <a href="{{ $instructorDetails->twitter }}" class="social-link-1">
                                                <img src="{{ asset('assets/frontend/default/image/lg-twiter.svg') }}" alt="">
                                            </a>
                                            <a href="{{ $instructorDetails->linkedin }}" class="social-link-1">
                                                <i class="fa-brands fa-linkedin"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Member Area End -->

    <!-- Testimonials Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-1 fs-32px lh-36px text-center mb-30">{{ get_phrase('What the people Thinks About Us') }}</h1>
                </div>
            </div>
            <div class="row mb-100px">
                <div class="col-xl-10 offset-xl-1">
                    <div class="testimonial-wrap1">
                        @php
                            $reviews = DB::table('user_reviews')->get();
                        @endphp
                        <div class="testimonial-profile-wrap1 mb-12px">
                            <div class="testimonial-profile-area1 slider-nav">
                                @foreach ($reviews as $review)
                                    @php
                                        $userDetails = DB::table('users')
                                            ->where('id', $review->user_id)
                                            ->first();
                                    @endphp
                                    <div class="testimonial-profile1">
                                        <div class="testimonial-profile-img1">
                                            <img src="{{ get_image($userDetails->photo) }}" alt="">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="testimonial-details-wrap1 slide-show">
                            @foreach ($reviews as $review)
                                @php
                                    $userDetails = DB::table('users')
                                        ->where('id', $review->user_id)
                                        ->first();
                                @endphp
                                <div class="single-testimonial-details1">
                                    <h2 class="title-1 fs-20px lh-28px fw-semibold mb-12px text-center">{{ $userDetails->name }}</h2>
                                    <div class="testimonial-ratings-1 mb-2 d-flex align-items-center justify-content-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                            @else
                                                <img src="{{ asset('assets/frontend/default/image/star.svg') }}" alt="">
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="subtitle-1 fs-16px lh-24px text-center mb-20px">{{ $review->review }}</p>
                                    <div class="quotation d-flex justify-content-center">
                                        <i class="fi-rr-quote-right text-18px" style="color: #264871;"></i>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials Area End -->

    <!-- News Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-1 fs-32px lh-36px text-center mb-30">{{ get_phrase('Our Latest Blog') }}</h1>
                </div>
            </div>
            <div class="row g-20px mb-100px">
                @foreach ($blogs as $key => $blog)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="d-block h-100 w-100 max-sm-350px">
                            <div class="lms-1-card">
                                <div class="lms-1-card-body">
                                    <div class="grid-view-banner1 mb-14px">
                                        <img class="h-230px" src="{{ get_image($blog->thumbnail) }}" alt="">
                                    </div>
                                    <div>
                                        <h5 class="title-1 fs-20px lh-28px mb-2 ellipsis-line-2">{{ ucfirst($blog->title) }}</h5>
                                        <p class="subtitle-1 fs-16px lh-24px mb-3 ellipsis-line-2">{{ ellipsis(strip_tags($blog->description), 160) }}</p>
                                        <p class="link-icon-btn1">
                                            <span>{{ get_phrase('Learn More') }}</span>
                                            <span class="fi-rr-angle-small-right"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- News Area End -->
@endsection
