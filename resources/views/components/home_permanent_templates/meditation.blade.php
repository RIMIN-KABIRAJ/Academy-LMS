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
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/montserrat/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/ubuntu/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/lato/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/manrope/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/mica-valo/stylesheet.css') }}">
@endpush
@section('content')

    <!-- Banner Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @php
                        $bannerData = json_decode(get_frontend_settings('banner_image'));
                        $banneractive = get_frontend_settings('home_page');

                        if ($bannerData !== null && is_object($bannerData) && property_exists($bannerData, $banneractive)) {
                            $banner = json_decode(get_frontend_settings('banner_image'))->$banneractive;
                        }
                    @endphp
                    <div class="maditation-banner-typography">
                        <img src="{{ asset('assets/frontend/default/image/meditation-typophy.svg') }}" alt="">
                    </div>
                    <div class="maditation-banner-content mb-80 d-flex">
                        <div class="maditation-banner-left">
                            <p class="info">{{ get_frontend_settings('banner_sub_title') }}</p>
                            <a href="{{ route('courses') }}" class="explore-btn1">
                                <span class="text">{{ get_phrase('Explore Courses') }}</span>
                                <span class="icon">
                                    <img src="{{ asset('assets/frontend/default/image/arrow-send-white.svg') }}" alt="">
                                </span>
                            </a>
                        </div>
                        <div class="maditation-banner-image">
                            @if (isset($banner))
                                <img src="{{ asset($banner) }}" alt="">
                            @else
                                <img src="{{ asset('assets/frontend/default/image/maditation-banner.svg') }}" alt="">
                            @endif
                        </div>
                        <div class="maditation-banner-right">
                            <ul class="maditation-video-profiles d-flex align-items-center">
                                @php
                                    $students = DB::table('users')->where('role', 'student')->take(4)->get();
                                    $total_student = DB::table('users')->where('role', 'student')->get();
                                    $free_courses = DB::table('courses')->where('is_paid', 0)->get();
                                @endphp
                                @foreach ($students as $student)
                                    <li>
                                        <img src="{{ get_image($student->photo) }}" alt="">
                                    </li>
                                @endforeach
                            </ul>
                            <div class="maditation-class-participant mb-20 d-flex flex-wrap">
                                <div class="class-participant">
                                    <h2 class="total fw-500">{{ count($total_student) }}+</h2>
                                    <p class="info">{{ get_phrase('Participant') }}</p>
                                </div>
                                <div class="class-participant">
                                    <h2 class="total fw-500">{{ count($free_courses) }}+</h2>
                                    <p class="info">{{ get_phrase('Online Free Courses') }}</p>
                                </div>
                            </div>
                            <div class="maditation-beginner-lesson">
                                <h2 class="total fw-500">{{ get_phrase('10%') }}</h2>
                                <p class="info">{{ get_phrase('Lessons for beginner') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- Harmony Area Start -->
    <section class="harmony-main-section mb-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="harmony-title-area d-flex align-items-start justify-content-between flex-wrap">
                        <h1 class="title">{{ get_phrase('Featured Courses') }}</h1>
                        <a href="{{ route('admin.courses') }}" class="explore-btn2">
                            <span class="text">{{ get_phrase('Explore Courses') }}</span>
                            <span class="icon">
                                <img src="{{ asset('assets/frontend/default/image/arrow-send-white.svg') }}" alt="">
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row row-30">
                @php
                    $feature_courses = DB::table('courses')->where('status', 'active')->limit(4)->latest('id')->get();
                    $hover_colors = ['linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(0, 255, 143, 0.91) 100%);', 'linear-gradient(180deg, rgba(255, 197, 211, 0) 10%, #FF90AA 100%);', 'linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(249, 232, 50, 0) 0.01%, #EEEE22 100%);', 'linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgb(57 220 254) 100%);'];
                @endphp
                @foreach ($feature_courses->take(8) as $key => $row)
                    <a href="{{ route('course.details', $row->slug) }}" class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="single-harmony-yoga">
                            <div class="banner">
                                <img src="{{ get_image($row->thumbnail) }}" alt="">
                            </div>
                            <div class="overlay" style="background: {{ $hover_colors[$key] }};">
                                <p class="name">{{ ucfirst($row->title) }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Harmony Area End -->

    <!-- Pose's Journey Area Start -->
    <section class="mb-80">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="posesjourney-title-area d-flex align-items-start justify-content-between flex-wrap">
                        <h1 class="title">{{ get_phrase('Top Course') }}</h1>
                        <a href="{{ route('courses') }}" class="explore-btn1">
                            <span class="text">{{ get_phrase('See All Courses') }}</span>
                            <span class="icon">
                                <img src="{{ asset('assets/frontend/default/image/arrow-send-white.svg') }}" alt="">
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row row-30">
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
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ route('course.details', $row->slug) }}" class="pose-journey-link">
                            <div class="single-posesjourney-yoga">
                                <div class="banner">
                                    <img src="{{ get_image($row->thumbnail) }}" alt="">
                                </div>
                                @if (isset($row->is_paid) && $row->is_paid == 0)
                                    <p class="price">{{ get_phrase('Free') }}</p>
                                @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                    <p class="price">
                                        {{ currency(number_format($row->discounted_price, 2)) }}
                                        <del class="fs-12px text-12px text-light">{{ currency($row->price) }}</del>
                                    </p>
                                @else
                                    <p class="price">{{ currency(number_format($row->price, 2)) }}</p>
                                @endif
                                @php
                                    $backgroundImage = asset('assets/frontend/default/image/pose-journey-shadow' . (($key % 3) + 1) . '.svg');
                                @endphp
                                <div class="overlay" style="--bgShape: url('{{ $backgroundImage }}')">
                                    <div class="posejourney-overley d-flex justify-content-between align-items-center">
                                        <div class="title-area mb-5">
                                            <h5 class="title">{{ ucfirst($row->title) }}</h5>
                                            <p class="info">{{ $row->level ?? '' }}</p>
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
    <!-- Pose's Journey Area End -->

    <!-- Yoga Benefit Area Start -->
    @php
        $bigImage = json_decode(get_homepage_settings('meditation'));
        $settings = get_homepage_settings('meditation');
        if (!$settings) {
            $settings = '{"meditation":[{"banner_title":"","banner_description":"", "image":""}]}';
        }
        $meditation_text = json_decode($settings);
        $meditations = [];
        $maxkey = 0;
        if ($meditation_text && isset($meditation_text->meditation)) {
            $meditations = $meditation_text->meditation;
            $maxkey = count($meditations) > 0 ? max(array_keys((array) $meditations)) : 0;
        }
    @endphp
    <section>
        <div class="container">
            <div class="row mb-80">
                <div class="col-md-12">
                    <div class="yoga-benefit-area">
                        <h2 class="title mb-5">{{ get_phrase('The benefit of Yoga Expedition') }}</h2>
                        <div class="yoga-benefits-wrap d-flex align-items-center">
                            <ul class="yoga-benefit-left yoga-benefit-list">
                                @foreach ($meditations as $key => $slider)
                                    @if ($key % 2 == 0)
                                        <li>
                                            <div class="yoga-benefit-details">
                                                <h6 class="title">{{ $slider->banner_title }}</h6>
                                                <p class="info">{{ $slider->banner_description }}</p>
                                            </div>
                                            <div class="yoga-benefit-image">
                                                <img src="{{ asset('uploads/home_page_image/meditation/' . $slider->image ?? '') }}" alt="">
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                            <div class="yoga-benefit-banner">
                                @if (isset($bigImage->big_image))
                                    <img src="{{ asset('uploads/home_page_image/meditation/' . $bigImage->big_image) }}" alt="">
                                @endif
                            </div>
                            <ul class="yoga-benefit-right yoga-benefit-list">
                                @foreach ($meditations as $key => $slider)
                                    @if ($key % 2 != 0)
                                        <li>
                                            <div class="yoga-benefit-image">
                                                <img src="{{ asset('uploads/home_page_image/meditation/' . $slider->image ?? '') }}" alt="">
                                            </div>
                                            <div class="yoga-benefit-details">
                                                <h6 class="title">{{ $slider->banner_title }}</h6>
                                                <p class="info">{{ $slider->banner_description }}</p>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Yoga Benefit Area End -->

    <!-- Testimonials Area Start -->
    <section style="background-color: background: rgba(255, 248, 246, 1);background-color: rgba(255, 248, 246, 1); padding-top: 60px; padding-bottom: 1px; margin-bottom: 50px;">
        <div class="container">
            <!-- Section title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="posesjourney-title-area home1-section-title elegant-testimonial-title">
                        <h1 class="title mb-20 fw-500 pb-4">{{ get_phrase('What our client say') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonials -->
        <div class="elegant-testimonials-wrap mb-50">
            <div class="swiper meditation-testimonial-1">
                <div class="swiper-wrapper">
                    @php
                        $reviews = DB::table('user_reviews')->get();
                    @endphp
                    @foreach ($reviews as $review)
                        @php
                            $userDetails = DB::table('users')
                                ->where('id', $review->user_id)
                                ->first();
                        @endphp
                        <div class="swiper-slide">
                            <div class="elegant-testimonial-slide">
                                <div class="ele-testimonial-profile-area d-flex">
                                    <div class="profile">
                                        <img src="{{ get_image_by_id($userDetails->id) }}" alt="">
                                    </div>
                                    <div class="ele-testimonial-profile-name">
                                        <h6 class="name">{{ $userDetails->name }}</h6>
                                        <p class="time">{{ date('h:i A', strtotime($review->created_at)) }}</p>
                                        <div class="rating d-flex align-items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                                @else
                                                    <img src="{{ asset('assets/frontend/default/image/star.svg') }}" alt="">
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="review fw-400">{{ $review->review }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- If we need navigation buttons -->
                <div class="row justify-content-center mt-5 pt-5">
                    <div class="col-md-6 col-lg-5 col-xl-4 position-relative">
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-scrollbar ms-auto me-auto MT-2"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Testimonials Area End -->

    <!-- Blog Area Start -->
    @if (get_frontend_settings('blog_visibility_on_the_home_page'))
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="meditation-blog-title-area d-flex align-items-center justify-content-between flex-wrap">
                            <h2 class="title">{{ get_phrase('Blogs') }}</h2>
                            <a href="{{ route('blogs') }}" class="explore-btn1">
                                <span class="text">{{ get_phrase('See All Blogs') }}</span>
                                <span class="icon">
                                    <img src="{{ asset('assets/frontend/default/image/arrow-send-white.svg') }}" alt="">
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row row-30 mb-80">
                    @foreach ($blogs as $key => $blog)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="meditation-blog-link">
                                <div class="meditation-blog-inner">
                                    <div class="banner">
                                        <img src="{{ get_image($blog->thumbnail) }}" alt="">
                                    </div>
                                    <div class="meditation-blog-details">
                                        <h3 class="title info ellipsis-line-2">{{ ucfirst($blog->title) }}</h3>
                                        <p class="info ellipsis-line-2">{{ ellipsis(strip_tags($blog->description), 160) }}</p>
                                        <p class="read-more d-flex align-items-center">
                                            <span>{{ get_phrase('Read More') }}</span>
                                            <img src="{{ asset('assets/frontend/default/image/arrow-right-black-20.svg') }}" alt="">
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Blog Area End -->


@endsection
