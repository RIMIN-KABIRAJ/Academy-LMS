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
            <div class="kg-banner-area">
                <div class="row gy-4 mb-80px align-items-center">
                    <div class="col-lg-6 order-2 order-lg-1">
                        <div>
                            @php
                                $banner_title = get_frontend_settings('banner_title');
                                $arr = explode(' ', $banner_title);
                                $phrase_two = end($arr);
                                $phrase_one = str_replace($phrase_two, '', $banner_title);
                            @endphp
                            <p class="text-red-highlight1 mb-6px">{{ get_phrase('LEARN FROM TODAY') }}</p>
                            <h1 class="title-3 fs-48px lh-normal fw-medium mb-20px kg-banner-title">{{ $phrase_one }} <span class="title-purple fw-semibold kg-banner-title-last">{{ $phrase_two }}</span></h1>
                            <p class="speech-purple-bordered subtitle-2 fs-15px lh-24px mb-30px">{{ get_frontend_settings('banner_sub_title') }}</p>
                            <div class="d-flex align-items-center gap-4 mb-3 flex-wrap">
                                <a href="{{ route('courses') }}" class="btn btn-purple-1 btn-purple-sm d-flex align-items-center gap-2">
                                    <span>{{ get_phrase('Explore Courses') }}</span>
                                    <span class="fi-rr-arrow-right"></span>
                                </a>
                                <a href="javascript:void(0);" class="play-btn-1" type="button" data-bs-toggle="modal" data-bs-target="#promoVideo">
                                    <span class="icon"><img src="{{ asset('assets/frontend/default/image/play-white-12.svg') }}" alt=""></span>
                                    <span>{{ get_phrase('Watch Video') }}</span>
                                </a>
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
                        <div class="lms-banner-2 px-md-4">
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
                                <img src="{{ asset('assets/frontend/default/image/kg-banner.webp') }}" alt="">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Area End -->

    <!-- Counnter Area Start -->
    <section>
        <div class="container">
            <div class="counter-area-wrap1 mb-100px">
                <div class="row g-28px row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1">
                    <div class="col">
                        @php
                            $total_students = DB::table('users')->where('role', 'student')->get();
                            $total_instructors = DB::table('users')->where('role', 'instructor')->get();
                            $free_courses = DB::table('courses')->where('is_paid', 0)->get();
                            $premium_courses = DB::table('courses')->where('is_paid', 1)->get();
                        @endphp
                        <div class="d-flex align-items-center gap-3">
                            <div class="image-box-md">
                                <img src="{{ asset('assets/frontend/default/image/kg-counter-img1.png') }}" alt="">
                            </div>
                            <div>
                                <h2 class="kg-counter-title mb-2px"><span class="counter2">{{ count($premium_courses) }}</span>+</h2>
                                <p class="title-3 fs-17px lh-23px">{{ get_phrase('Premium courses') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center gap-3">
                            <div class="image-box-md">
                                <img src="{{ asset('assets/frontend/default/image/kg-counter-img2.png') }}" alt="">
                            </div>
                            <div>
                                <h2 class="kg-counter-title mb-2px"><span class="counter2">{{ count($total_instructors) }}</span>+</h2>
                                <p class="title-3 fs-17px lh-23px">{{ get_phrase('Expert Mentors') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center gap-3">
                            <div class="image-box-md">
                                <img src="{{ asset('assets/frontend/default/image/kg-counter-img3.png') }}" alt="">
                            </div>
                            <div>
                                <h2 class="kg-counter-title mb-2px"><span class="counter2">{{ count($total_students) }}</span>+</h2>
                                <p class="title-3 fs-17px lh-23px">{{ get_phrase('Students Globally') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex align-items-center gap-3">
                            <div class="image-box-md">
                                <img src="{{ asset('assets/frontend/default/image/free.svg') }}" alt="">
                            </div>
                            <div>
                                <h2 class="kg-counter-title mb-2px"><span class="counter2">{{ count($free_courses) }}</span>+</h2>
                                <p class="title-3 fs-17px lh-23px">{{ get_phrase('Cost Free Course') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counnter Area End -->

    <!-- Course Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-1 mb-50px">
                        <h1 class="title-3 mb-26px fs-40px lh-52px fw-medium text-center">{{ get_phrase('Top Courses') }}</h1>
                        <p class="subtitle-2 fs-15px lh-24px text-center">
                            {{ get_phrase('Awesome  site. on the top advertising a business online includes assembling Having the most keep.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row g-28px mb-100px">
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
                        <a href="{{ route('course.details', $row->slug) }}" class="d-block h-100 w-100 max-sm-350px">
                            <div class="lms-1-card rounded-4 rounded-4 lms-card-hover1">
                                <div class="lms-1-card-body">
                                    <div class="grid-view-banner1 card-banner-hover1 mb-20px">
                                        <img class="h-190px" src="{{ get_image($row->thumbnail) }}" alt="banner">
                                    </div>
                                    <div class="course-card1-details">
                                        <h5 class="title-3 fs-18px lh-26px fw-medium mb-10px ellipsis-line-2">{{ ucfirst($row->title) }}</h5>
                                        <div class="card-leason-rating1 d-flex gap-2 align-items-center justify-content-between">
                                            <div class="card-icon-text1 d-flex gap-2 align-items-center">
                                                <span class="fi-rr-book-open-cover"></span>
                                                <p class="info">{{ lesson_count($row->id) }} {{ get_phrase('lessons') }}</p>
                                            </div>
                                            <div class="card-rating1 d-flex gap-1 align-items-center">
                                                <p class="rating">{{ number_format($row->average_rating, 1) }}</p>
                                                <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                            </div>
                                        </div>
                                        <div class="kg-card-profile-price d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="card-author-sm">
                                                    <img src="{{ course_instructor_image($row->id) }}" alt="">
                                                </div>
                                                <div class="title-1 fs-13px lh-26px fw-bold">{{ course_by_instructor($row->id)->name }}</div>
                                            </div>

                                            @if (isset($row->is_paid) && $row->is_paid == 0)
                                                <h4 class="price title-1 fs-20px lh-26px fw-bold">{{ get_phrase('Free') }}</h4>
                                            @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                                <h4 class="price title-1 fs-18px lh-24px fw-bold">
                                                    {{ currency(number_format($row->discounted_price, 2)) }}
                                                </h4>
                                                {{-- <del class="fs-14px fw-400">{{ currency(number_format($row->price, 2)) }}</del> --}}
                                            @else
                                                <h4 class="price title-1 fs-20px lh-26px fw-bold">{{ currency(number_format($row->price, 2)) }}</h4>
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
    <!-- Course Area End -->

    <!-- Categories Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-1 mb-50px">
                        <h1 class="title-3 mb-26px fs-40px lh-52px fw-medium text-center">{{ get_phrase('Top Categories') }}</h1>
                        <p class="subtitle-2 fs-15px lh-24px text-center">
                            {{ get_phrase('Awesome  site. on the top advertising a business online includes assembling Having the most keep.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row g-28px mb-100px">
                @foreach (App\Models\Category::take(6)->get() as $category)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('courses', $category->slug) }}" class="w-100">
                            <div class="lms-1-card rounded-4 lms-card-hover1">
                                <div class="lms-1-card-body">
                                    <div class="d-flex align-items-center gap-20px">
                                        @if ($category->category_logo)
                                            <div class="bg-icon-card1 bg-color-e9f6ff">
                                                <img src="{{ get_image($category->category_logo) }}" alt="">
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="title-3 fs-20px lh-28px fw-medium">{{ $category->title }}</h4>
                                            <p class="subtitle-2 fs-15px lh-23px fw-medium">{{ count_category_courses($category->id) }} {{ get_phrase('courses') }}</p>
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
    <!-- Categories Area End -->

    <!-- Featured Course Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-1 mb-50px">
                        <h1 class="title-3 mb-26px fs-40px lh-52px fw-medium text-center">{{ get_phrase('Featured Courses') }}</h1>
                        <p class="subtitle-2 fs-15px lh-24px text-center">
                            {{ get_phrase('Awesome  site. on the top advertising a business online includes assembling Having the most keep.') }}</p>
                    </div>
                </div>
            </div>
            <div class="row g-28px mb-100px">
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
                        <a href="{{ route('course.details', $row->slug) }}" class="d-block h-100 w-100 max-sm-350px">
                            <div class="lms-1-card rounded-4 lms-card-hover1">
                                <div class="lms-1-card-body">
                                    <div class="grid-view-banner1 card-banner-hover1 mb-20px">
                                        <img class="h-190px" src="{{ get_image($row->thumbnail) }}" alt="">
                                    </div>
                                    <div class="course-card1-details">
                                        <h5 class="title-3 fs-18px lh-26px fw-medium ellipsis-line-2 mb-10px">{{ ucfirst($row->title) }}</h5>
                                        <div class="card-leason-rating1 d-flex gap-2 align-items-center justify-content-between">
                                            <div class="card-icon-text1 d-flex gap-2 align-items-center">
                                                <span class="fi-rr-book-open-cover"></span>
                                                <p class="info">{{ lesson_count($row->id) }} {{ get_phrase('lesson') }}</p>
                                            </div>
                                            <div class="card-rating1 d-flex gap-1 align-items-center">
                                                @if ($average_rating !== null)
                                                    <div class="card-rating1 d-flex gap-1 align-items-center">
                                                        <p class="rating">{{ number_format($average_rating, 1) }}</p>
                                                    </div>
                                                    <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="kg-card-profile-price d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="card-author-sm">
                                                    <img src="{{ course_instructor_image($row->id) }}" alt="">
                                                </div>
                                                <div class="title-1 fs-13px lh-26px fw-bold">{{ course_by_instructor($row->id)->name }}</div>
                                            </div>
                                            @if (isset($row->is_paid) && $row->is_paid == 0)
                                                <h4 class="price title-1 fs-20px lh-26px fw-bold">{{ get_phrase('Free') }}</h4>
                                            @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                                <h4 class="price title-1 fs-20px lh-26px fw-bold">
                                                    {{ currency(number_format($row->discounted_price, 2)) }}
                                                </h4>
                                                {{-- <del class="fs-14px fw-400">{{ currency(number_format($row->price, 2)) }}</del> --}}
                                            @else
                                                <h4 class="price title-1 fs-20px lh-26px fw-bold">{{ currency(number_format($row->price, 2)) }}</h4>
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
    <!-- Featured Course Area End -->

    <!-- Creating A Community Area Start -->
    @if ($stordetails = json_decode(get_homepage_settings('kindergarden')))
        <section>
            <div class="container">
                <div class="row g-28px align-items-center mb-100px">
                    <div class="col-lg-6">
                        <div class="community-banner1">
                            @if (isset($stordetails->image))
                                <img src="{{ asset('uploads/home_page_image/kindergarden/' . $stordetails->image) }}" alt="">
                            @else
                                <img src="{{ asset('assets/frontend/default/image/community-banner.webp') }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>
                            <h2 class="title-3 fs-32px lh-42px fw-medium mb-30px">{{ $stordetails->title }}</h2>
                            <p class="subtitle-3 fs-15px lh-25px mb-30px">{{ $stordetails->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Creating A Community Area End -->

    <!-- QNA Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title-1 mb-50px">
                        <h1 class="title-3 mb-26px fs-40px lh-52px fw-medium text-center">{{ get_phrase('Frequently Asked Questions') }}</h1>
                        <p class="subtitle-2 fs-15px lh-24px text-center">
                            {{ get_phrase('Awesome  site. on the top advertising a business online includes assembling Having the most keep.') }}</p>
                    </div>
                </div>
            </div>
            <div class="two-accordion-wrap">
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

                <div class="row mb-100px">
                    <div class="col-md-6">
                        <div class="accordion qnaaccordion-three" id="accordionExampleLeft">
                            @foreach ($odd_faqs as $key => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLeft{{ $key }}" aria-expanded="true" aria-controls="collapseLeft{{ $key }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h2>
                                    <div id="collapseLeft{{ $key }}" class="accordion-collapse px-0 collapse {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExampleLeft">
                                        <div class="accordion-body">
                                            <p class="accor-three-answer">{{ $faq['answer'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="accordion qnaaccordion-three" id="accordionExampleRight">
                            @foreach ($even_faqs as $key => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRight{{ $key }}" aria-expanded="true" aria-controls="collapseRight{{ $key }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h2>
                                    <div id="collapseRight{{ $key }}" class="accordion-collapse px-0 collapse {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExampleRight">
                                        <div class="accordion-body">
                                            <p class="accor-three-answer">{{ $faq['answer'] }}</p>
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
    <!-- QNA Course Area End -->

    <!-- Testimonial Area Start -->
    <section>
        <div class="container">
            <div class="row gx-0 gy-4 align-items-end mb-50px">
                <div class="col-xl-4">
                    <div class="lg-testimonial-titles mb-50px">
                        <h1 class="title-3 fs-40px lh-52px fw-medium mb-30px text-xl-start text-center">{{ get_phrase('What they’re saying about our courses') }}</h1>
                        <p class="subtitle-3 fs-15px lh-25px text-xl-start text-center">
                            {{ get_phrase('Having enjoyed a breathlessly successful 2015, there can be no DJ  dynamic set of teaching tools Billed to be deployed.') }}</p>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="swiper lms-testimonial-1 kindergarden-home">

                        <div class="swiper-wrapper">
                            @php
                                $reviews = DB::table('user_reviews')->get();

                            @endphp
                            @foreach ($reviews as $review)
                                @php
                                    $userDetails = DB::table('users')
                                        ->where('id', $review->user_id)
                                        ->first();
                                    $bgColor = '#fffccf';
                                    if ($review->rating >= 4) {
                                        $bgColor = '#ffe8eb';
                                    } elseif ($review->rating == 3) {
                                        $bgColor = '#ffedff';
                                    } else {
                                        $bgColor = '#fffccf';
                                    }
                                @endphp
                                <div class="swiper-slide">
                                    <div class="lms-single-testimonial1">
                                        <div class="single-testimonial1-inner" style="--bg-color: {{ $bgColor }}">
                                            <div class="testimonial1-profile-img">
                                                <img src="{{ get_image_by_id($userDetails->id) }}" alt="">
                                            </div>
                                            <div class="d-flex align-items-center gap-6px mb-20px">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                                    @else
                                                        <img src="{{ asset('assets/frontend/default/image/star.svg') }}" alt="">
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="subtitle-3 fs-15px lh-25px mb-4 text-dark">{{ $review->review }}</p>
                                            <h4 class="title-3 fs-20px lh-25px fw-normal mb-10px">{{ $userDetails->name }}</h4>
                                            <p class="testimonial1-user-role capitalize">{{ $userDetails->role }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Area End -->

    <!-- Blog Area Start -->
    @if (get_frontend_settings('blog_visibility_on_the_home_page'))
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title-1 mb-50px">
                            <h1 class="title-3 mb-26px fs-40px lh-52px fw-medium text-center">{{ get_phrase('Our Blog') }}</h1>
                            <p class="subtitle-2 fs-15px lh-24px text-center">
                                {{ get_phrase('Awesome  site. on the top advertising a business online includes assembling Having the most keep.') }}</p>
                        </div>
                    </div>
                </div>
                <div class="row g-20px mb-100px">
                    @foreach ($blogs as $key => $blog)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="blog-post1-link">
                                <div class="blog-post1-inner">
                                    <div class="banner">
                                        <img src="{{ get_image($blog->thumbnail) }}" alt="...">
                                    </div>
                                    <div class="blog-post1-details">
                                        <h3 class="title mb-3 pt-2 ellipsis-line-2">{{ ucfirst($blog->title) }}</h3>
                                        <p class="info ellipsis-line-2">{!! ellipsis(strip_tags($blog->description), 160) !!}</p>
                                        <p class="read-more d-flex align-items-center">
                                            <span>{{ get_phrase('Read More') }}</span>
                                            <img src="{{ asset('assets/frontend/default/image/angle-right-black-18.svg') }}" alt="">
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
    </script>


@endsection
