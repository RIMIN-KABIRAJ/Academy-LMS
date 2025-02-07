@extends('layouts.default')
@push('title', get_phrase('Home'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/sora/font.css') }}">
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        a,
        button {
            font-family: 'sora-regular' !important;
        }

        .btn-danger-1,
        .btn-whitelight,
        .info,
        input {
            font-family: 'sora-regular' !important;
        }

        .subtitle-1,
        .subtitle-2,
        .subtitle-3,
        .subtitle-4,
        .subtitle-5 {
            font-family: 'sora-semi-bold' !important;
            font-weight: 500;
        }

        .title,
        .title-1,
        .title-2,
        .title-3,
        .title-4,
        .title-5 {
            font-family: 'sora-bold' !important;
            font-weight: 700;
        }

        .form-control.sub1-form-control {
            padding: 9px 15px;
        }
    </style>
@endpush
@section('content')

    <!-- Banner Area Start -->
    @php
        $bannerData = json_decode(get_frontend_settings('banner_image'));
        $banneractive = get_frontend_settings('home_page');
        if ($bannerData !== null && is_object($bannerData) && property_exists($bannerData, $banneractive)) {
            $banner = asset(json_decode(get_frontend_settings('banner_image'))->$banneractive);
        } else {
            $defaultBanner = asset('assets/frontend/default/image/bannerM.jpg');
        }
        $total_students = DB::table('users')->where('role', 'student')->get();
    @endphp
    <section>
        <div class="container">
            <div class="row mb-50px">
                <div class="col-md-12">
                    <div class="lms-banner-area-3" style="background-image: url({{ isset($banner) ? $banner : $defaultBanner }});">
                        <!-- Swiper -->
                        <div class="swiper banner-swiper-1">
                            @php
                                $settings = get_homepage_settings('marketplace');
                                $marketplace_banner = json_decode($settings);
                                if ($marketplace_banner && isset($marketplace_banner->slider)) {
                                    $sliders = $marketplace_banner->slider;
                                }
                            @endphp
                            @if ($marketplace_banner)
                                <div class="swiper-wrapper">
                                    @foreach ($sliders as $key => $slider)
                                        <div class="swiper-slide">
                                            <div class="lms-banner-slide">
                                                <p class="text-white-highlight1 mb-12px">{{ $slider->banner_title }}</p>
                                                <h1 class="title-4 fs-56px lh-normal fw-bold text-white text-center mb-50px">{{ $slider->banner_description }}</h1>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            @endif
                            <a href="{{ route('courses') }}" class="btn btn-white1 slider_btn">
                                <span>{{ get_phrase('Explore Courses') }}</span>
                                <span class="fi-rr-arrow-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- Categories Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-4 fs-34px lh-44px fw-semibold mb-50px">{{ get_phrase('Top Categories') }}</h1>
                </div>
            </div>
            <div class="row g-28px row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2 mb-100px">
                @foreach (App\Models\Category::take(5)->get() as $category)
                    <div class="col">
                        <a href="{{ route('courses', $category->slug) }}">
                            @if ($category->category_logo)
                                <div class="icon-box-md mb-20px">
                                    <img src="{{ get_image($category->category_logo) }}" alt="">
                                </div>
                            @endif
                            <h5 class="title-4 fs-20px lh-28px fw-semibold mb-2">{{ $category->title }}</h5>
                            <p class="subtitle-4 fs-15px lh-23px">{{ count_category_courses($category->id) }} {{ get_phrase('courses') }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Categories Area End -->

    <!-- Courses Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-4 fs-34px lh-44px fw-semibold mb-50px">{{ get_phrase('Top Courses') }}</h1>
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
                            <div class="lms-1-card rounded-4 lms-card-hover2">
                                <div class="lms-1-card-body p-0">
                                    <div class="grid-view-banner2 position-relative">
                                        <img class="h-190px radious-0" src="{{ get_image($row->thumbnail) }}" alt="">
                                    </div>
                                    <div class="p-4">
                                        <div class="mb-6px d-flex gap-2 align-items-center justify-content-between">
                                            <div class="card-icon-text2 d-flex gap-2 align-items-center">
                                                <span class="fi-rr-book-open-cover"></span>
                                                <p class="subtitle-4 fs-13px lh-26px">{{ lesson_count($row->id) }} {{ get_phrase('lessons') }}</p>
                                            </div>
                                            <div class="card-rating2 d-flex gap-1 align-items-center">
                                                @if ($row->average_rating)
                                                    <p class="rating">{{ number_format($row->average_rating, 1) }}</p>
                                                    <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="">
                                                @endif
                                            </div>
                                        </div>
                                        <h5 class="title-4 fs-18px lh-26px fw-semibold my-4 ellipsis-line-2">{{ ucfirst($row->title) }}</h5>
                                        <div class="d-flex align-items-center gap-2 justify-content-between flex-wrap mb-2">
                                            <div class="mk-card-price d-flex align-items-end gap-1 ">
                                                @if (isset($row->is_paid) && $row->is_paid == 0)
                                                    <p class="title-4 fs-20px lh-26px fw-bold">{{ get_phrase('Free') }}</p>
                                                @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                                    <p class="title-4 fs-20px lh-26px fw-bold">{{ currency(number_format($row->discounted_price, 2)) }}
                                                    </p>
                                                    <p class="mk-old-price text-12px">{{ currency(number_format($row->price, 2)) }}</p>
                                                @else
                                                    <p class="title-4 fs-20px lh-26px fw-bold">{{ currency(number_format($row->price, 2)) }}</p>
                                                @endif
                                            </div>
                                            <p class="btn btn-dark-1 px-3">{{ get_phrase('Learn More') }}</p>
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
    <!-- Courses Area End -->

    <!-- Counter Area Start -->
    <section class="counter-section-2">
        <div class="container">
            <div class="row mb-100px">
                <div class="col-md-12">
                    @php
                        $total_students = DB::table('users')->where('role', 'student')->get();
                        $total_instructors = DB::table('users')->where('role', 'instructor')->get();
                        $free_courses = DB::table('courses')->where('is_paid', 0)->get();
                        $premium_courses = DB::table('courses')->where('is_paid', 1)->get();
                    @endphp
                    <div class="counter-area-wrap2">
                        <div class="counter-single-item2">
                            <h1 class="title-4 fs-82px lh-107px fw-semibold text-white text-center mb-5px"><span class="counter2">{{ count($total_students) }}</span>+</h1>
                            <p class="subtitle-3 fs-18px lh-25px fw-normal text-white text-center">{{ get_phrase('Happy Student') }}</p>
                        </div>
                        <div class="counter-single-item2">
                            <h1 class="title-4 fs-82px lh-107px fw-semibold text-white text-center mb-5px"><span class="counter2">{{ count($total_instructors) }}</span></h1>
                            <p class="subtitle-3 fs-18px lh-25px fw-normal text-white text-center">{{ get_phrase('Quality educators') }}+</p>
                        </div>
                        <div class="counter-single-item2">
                            <h1 class="title-4 fs-82px lh-107px fw-semibold text-white text-center mb-5px"><span class="counter2">{{ count($premium_courses) }}</span>+</h1>
                            <p class="subtitle-3 fs-18px lh-25px fw-normal text-white text-center">{{ get_phrase('Premium courses') }}</p>
                        </div>
                        <div class="counter-single-item2">
                            <h1 class="title-4 fs-82px lh-107px fw-semibold text-white text-center mb-5px"><span class="counter2">{{ count($free_courses) }}</span>+</h1>
                            <p class="subtitle-3 fs-18px lh-25px fw-normal text-white text-center">{{ get_phrase('Cost-free course') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Area End -->

    <!-- Become An Instructor Area Start -->

    @php
        $settings = get_homepage_settings('marketplace');
        $marketplace = json_decode($settings);
        if ($marketplace && isset($marketplace->instructor)) {
            $instructor = $marketplace->instructor;
        }
    @endphp
    @if ($marketplace)
        <section>
            <div class="container">
                <div class="row g-28px align-items-center mb-100px">
                    <div class="col-lg-5 col-md-6">
                        <div class="video-banner-area1">
                            @if (isset($instructor->image))
                                <img src="{{ asset('uploads/home_page_image/marketplace/' . $instructor->image) }}" alt="">
                                <a href="javascript:void(0);" class="play-btn-2" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#becomeInstructor">
                                    <img src="{{ asset('assets/frontend/default/image/play-white-22.svg') }}" alt="">
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <div class="ms-xl-3">
                            <h4 class="title-4 fs-34px lh-44px fw-semibold mb-28px">{{ $instructor->title }}</h4>
                            <p class="subtitle-4 fs-15px lh-25px mb-28px">{{ $instructor->description }}</p>
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
                                <iframe src="{{ $instructor->video_url }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Video Popup Modal Area End -->
    @endif
    <!-- Become An Instructor Area End -->

    <!-- QNA Area Start -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-4 fs-34px lh-44px fw-semibold text-center mb-50px">{{ get_phrase('Frequently Asked Questions') }}</h1>
                </div>
            </div>
            <!-- QNA Accordion -->
            <div class="row mb-100px">
                <div class="col-md-12">
                    <div class="accordion qnaaccordion-four" id="accordionExample4">
                        @php
                            $faqs = count(json_decode(get_frontend_settings('website_faqs'), true)) > 0 ? json_decode(get_frontend_settings('website_faqs'), true) : [['question' => '', 'answer' => '']];
                        @endphp
                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" {{ $key }}>
                                    <button class="accordion-button {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#qnaOne{{ $key }}" aria-expanded="true" aria-controls="qnaOne">
                                        {{ $faq['question'] }}
                                    </button>
                                </h2>
                                <div id="qnaOne{{ $key }}" class="accordion-collapse collapse px-0 {{ $key == 0 ? 'show' : '' }}" data-bs-parent="#accordionExample4" aria-labelledby="{{ $key }}">
                                    <div class="accordion-body">
                                        <p class="subtitle-4 fs-15px lh-30px">{{ $faq['answer'] }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- QNA Area End -->

    <!-- Testimonial Area End -->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="title-4 fs-34px lh-44px fw-semibold text-center mb-30px">{{ get_phrase('What the people Thinks About Us') }}</h1>
                </div>
            </div>
            <div class="row mb-50px">
                <div class="col-md-12">
                    <div class="swiper lms-testimonial-2">
                        <div class="swiper-wrapper">
                            @php
                                $reviews = DB::table('user_reviews')->get();
                            @endphp
                            @foreach ($reviews as $review)
                                @php
                                    $userDetails = App\Models\User::where('id', $review->user_id)->firstOrNew();
                                @endphp
                                <div class="swiper-slide">
                                    <div class="lms-1-card rounded-4">
                                        <div class="lms-single-testimonial2">
                                            <div class="d-flex justify-content-between gap-2 mb-14px">
                                                <div class="testimonial-profile-wrap2 d-flex align-items-center ">
                                                    <div class="testimonial-profile-2">
                                                        <img src="{{ get_image_by_id($userDetails->id) }}" alt="">
                                                    </div>
                                                    <div>
                                                        <h4 class="title-4 fs-18px lh-25px fw-semibold mb-5px">{{ $userDetails->name }}</h4>
                                                        <p class="subtitle-4 fs-14px lh-24px">{{ date('h:i A', strtotime($review->created_at)) }}</p>
                                                    </div>
                                                </div>
                                                <div class="testimonial-quate-1">
                                                    <img src="assets/images/icons/quote.svg" alt="">
                                                </div>
                                            </div>
                                            <p class="subtitle-4 fs-15px lh-24px mb-14px">{{ $review->review }}</p>
                                            <div class="d-flex align-items-center gap-1">
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
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Area End -->

    <!-- Subscribe Area Start -->
    <section>
        <div class="container">
            <div class="subscribe-area-wrap1 mb-100px">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="subscribe-area-banner1">
                            <img src="{{ asset('assets/frontend/default/image/education.jpg') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="subscribe-area-1">
                            <h3 class="title-4 fs-28px lh-36px fw-bold text-center text-white mb-14px">
                                {{ get_phrase('Subscribe to our newsletter to get latest updates') }}</h3>

                            <p class="text-white fw-400 text-center">{{ get_phrase("Subscribe to stay tuned for new latest updates and offer. Let's do it! ") }}</p>
                            <form action="{{ route('newsletter.store') }}" method="post" class="mt-5">
                                @csrf
                                <div class="subscribe-form-inner d-flex align-items-center justify-content-center">
                                    <input type="email" class="form-control sub1-form-control" name="email" placeholder="Enter your email">
                                    <button type="submit" class="btn btn-white1 btn-white1-sm">{{ get_phrase('Subscribe') }}</button>
                                </div>
                            </form>
                            <p class="text-white text-13px fw-300 text-center mt-4 pt-3" style="color: #9CA3AC !important;">{{ get_phrase('Read our privacy policy') }} <a href="{{ route('privacy.policy') }}"><u>{{ get_phrase('Here') }}</u>.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Subscribe Area End -->

    <!-- Blog Area Start -->
    @if (get_frontend_settings('blog_visibility_on_the_home_page'))
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title-4 fs-34px lh-44px fw-semibold text-center mb-30px">{{ get_phrase('Our Latest Blog') }}</h1>
                    </div>
                </div>
                <div class="row g-28px mb-100px">
                    @foreach ($blogs as $key => $blog)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="max-sm-350px">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="mk-blog-banner">
                                    <img class="h-230px" src="{{ get_image($blog->thumbnail) }}" alt="">
                                </a>
                                <a href="{{ route('blog.details', $blog->slug) }}" class="mk-blog-body">
                                    <div class="lms-1-card rounded-3 lms-card-hover2">
                                        <div class="lms-1-card-body">
                                            <h3 class="title-4 fs-18px lh-26px fw-semibold mb-14px ellipsis-line-2">{{ ucfirst($blog->title) }}</h3>
                                            <p class="subtitle-4 fs-15px lh-24px mb-18px ellipsis-line-2">{{ ellipsis(strip_tags($blog->description), 160) }}</p>
                                            <div class="card-icon-text3 mk-blog-icontext d-flex align-items-center">
                                                <span class="fi-rr-time-oclock"></span>
                                                <p class="subtitle-4 fs-12px lh-normal">{{ $blog->created_at->format('d M, Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Blog Area End -->

@endsection

@push('js')
    <script>
        "use strict";
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
@endpush
