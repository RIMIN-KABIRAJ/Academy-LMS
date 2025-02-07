@extends('layouts.default')
@push('title', get_phrase('Home'))
@push('meta')@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/ubuntu/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/lexend-deca/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/outfit/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/mulish/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/Poppins/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/dm-sens/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/rubik/stylesheet.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/default/fonts/montserrat/stylesheet.css') }}">
@endpush
@section('content')
    <!-- Homepage 1 Banner Area Start -->
    <section class="home1-banner-section">
        <div class="container">
            <div class="row mb-80 align-items-center">
                <div class="col-md-6 order-2 order-md-1">
                    <div class="home1-banner-content">
                        @php
                            $banner_title = get_frontend_settings('banner_title');
                            $arr = explode(' ', $banner_title);
                            $phrase_two = end($arr);
                            $phrase_one = str_replace($phrase_two, '', $banner_title);
                        @endphp
                        <p class="light">{{ get_phrase('The Leader in online learning') }}</p>
                        <h1 class="title">{{ $phrase_one }} <span class="highlight">{{ $phrase_two }}</span></h1>
                        <p class="info mb-20">{{ get_frontend_settings('banner_sub_title') }}</p>
                        <div class="buttons d-flex align-items-center flex-wrap">
                            <a href="{{ route('courses') }}" class="theme-btn1">{{ get_phrase('Get Started') }}</a>
                            <a data-bs-toggle="modal" data-bs-target="#promoVideo" href="#" class="border-btn1">
                                {{ get_phrase('Learn More') }}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <div class="home1-banner-image">
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
                            <img src="{{ asset('assets/frontend/default/image/home1-banner.webp') }}" alt="">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Homepage 1 Banner Area End -->

    <!-- Crash Course Area Start -->
    <section>
        <div class="container mb-80">
            <!-- Section title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="home1-section-title">
                        <h1 class="title mb-20 fw-500">{{ get_phrase('Special Featured Course') }}</h1>
                        <p class="info">
                            {{ get_phrase("Those course highlights a handpicked course with exceptional content or exclusive offerings.") }}</p>
                    </div>
                </div>
            </div>
            <!-- Courses -->
            <div class="row row-20 mb-30">
                @php
                    $featured_courses = DB::table('courses')->where('status', 'active')->latest('id')->get();
                @endphp
                @foreach ($featured_courses->take(4) as $key => $row)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <a href="{{ route('course.details', $row->slug) }}" class="course-card1-link">
                            <div class="course-card1-inner">
                                <div class="banner">
                                    <img src="{{ get_image($row->thumbnail) }}" alt="">
                                </div>
                                <div class="course-card1-details">
                                    <div class="rating-reviews d-flex align-items-center flex-wrap">
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
                                            <div class="rating d-flex align-items-center">
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
                                            <p class="reviews">({{ $review_count }} {{ get_phrase('Reviews') }})</p>
                                        @endif
                                    </div>
                                    <div class="title-info">
                                        <h4 class="title">{{ ucfirst($row->title) }}</h4>
                                        <p class="info">{{ $row->short_description ?? '' }}</p>
                                    </div>
                                    <div class="course-card1-leasons-students d-flex align-items-center flex-wrap">
                                        <div class="leasons-students d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/default/image/book-open-16.svg') }}" alt="">
                                            <p class="total fw-500">{{ lesson_count($row->id) }} {{ get_phrase('lesson') }}</p>
                                        </div>
                                        <div class="leasons-students d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/default/image/user-square.svg') }}" alt="">
                                            <p class="total fw-500">{{ course_enrollments($row->id) }} {{ get_phrase('Students') }}</p>
                                        </div>
                                    </div>
                                    <div class="course-card1-author-price d-flex align-items-end justify-content-between">
                                        <div class="author d-flex align-items-center">
                                            <div class="profile">
                                                <img src="{{ course_instructor_image($row->id) }}" alt="">
                                            </div>
                                            <p class="name">{{ course_by_instructor($row->id)->name }}</p>
                                        </div>
                                        <div class="prices">
                                            @if (isset($row->is_paid) && $row->is_paid == 0)
                                                <p class="new-price">{{ get_phrase('Free') }}</p>
                                            @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                                <p class="old-price">{{ currency(number_format($row->price, 2)) }}</p>
                                                <p class="new-price">{{ currency(number_format($row->discounted_price, 2)) }}</p>
                                            @else
                                                <p class="new-price">{{ currency(number_format($row->price, 2)) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if (count($featured_courses) > 4)
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('courses') }}" class="border-btn1">{{ get_phrase('View More') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- Crash Course Area End -->

    <!-- Why Choose Area Start -->
    <section class="why-choose-section1 mb-80">
        <div class="container py-3">
            <div class="row">
                <div class="why-choose-area1">
                    <h2 class="title mb-30 fw-500">{{ get_phrase('Why Choose Us') }}</h2>
                    @php
                        $total_students = DB::table('users')->where('role', 'student')->get();
                        $total_instructors = DB::table('users')->where('role', 'instructor')->get();
                        $free_courses = DB::table('courses')->where('is_paid', 0)->get();
                        $premium_courses = DB::table('courses')->where('is_paid', 1)->get();
                    @endphp
                    <div class="why-choose-wrap1">
                        <div class="why-choose1-single">
                            <h1 class="total fw-500">{{ count($total_students) }} +</h1>
                            <p class="info">{{ get_phrase('Happy student') }}</p>
                        </div>
                        <div class="why-choose1-single">
                            <h1 class="total fw-500">{{ count($total_instructors) }} +</h1>
                            <p class="info">{{ get_phrase('Quality educators') }}</p>
                        </div>
                        <div class="why-choose1-single">
                            <h1 class="total fw-500">{{ count($premium_courses) }}+</h1>
                            <p class="info">{{ get_phrase('Premium courses') }}</p>
                        </div>
                        <div class="why-choose1-single">
                            <h1 class="total fw-500">{{ count($free_courses) }}+</h1>
                            <p class="info">{{ get_phrase('Cost-free course') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Why Choose Area End -->

    <!-- Top Rated Course Area Start -->
    <section>
        <div class="container mb-80">
            <!-- Section title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="home1-section-title">
                        <h1 class="title mb-20 fw-500">{{ get_phrase('Top Rated Course') }}</h1>
                        <p class="info">
                            {{ get_phrase("Top rated course showcases the highest-rated course based on student reviews and performance metrics.") }}</p>
                    </div>
                </div>
            </div>
            <!-- Courses -->
            <div class="row row-20 mb-30">
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
                        <a href="{{ route('course.details', $row->slug) }}" class="course-card1-link">
                            <div class="course-card1-inner">
                                <div class="banner">
                                    <img src="{{ get_image($row->thumbnail) }}" alt="">
                                </div>
                                <div class="course-card1-details">
                                    <div class="rating-reviews d-flex align-items-center flex-wrap">
                                        <div class="rating d-flex align-items-center">
                                            @php
                                                $rating = $row->average_rating;
                                                $full_stars = floor($rating);
                                                $has_half_star = $rating - $full_stars >= 0.5;
                                            @endphp

                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $full_stars)
                                                    <img src="{{ asset('assets/frontend/default/image/star-yellow-14.svg') }}" alt="Full Star">
                                                @elseif ($i == $full_stars && $has_half_star)
                                                    <img src="{{ asset('assets/frontend/default/image/star-yellow-half-14.svg') }}" alt="Half Star">
                                                @else
                                                    <img src="{{ asset('assets/frontend/default/image/star.svg') }}" alt="...">
                                                @endif
                                            @endfor

                                        </div>
                                        <p class="reviews">({{ DB::table('reviews')->where('course_id', $row->id)->count() }} {{ get_phrase('Reviews') }})</p>
                                    </div>
                                    <div class="title-info">
                                        <h4 class="title ellipsis-line-2">{{ ucfirst($row->title) }}</h4>
                                        <p class="info">{{ $row->short_description ?? '' }}</p>
                                    </div>
                                    <div class="course-card1-leasons-students d-flex align-items-center flex-wrap">
                                        <div class="leasons-students d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/default/image/book-open-16.svg') }}" alt="">
                                            <p class="total fw-500">{{ lesson_count($row->id) }} {{ get_phrase('lesson') }}</p>
                                        </div>
                                        <div class="leasons-students d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/default/image/user-square.svg') }}" alt="">
                                            <p class="total fw-500">{{ course_enrollments($row->id) }} {{ get_phrase('Students') }}</p>
                                        </div>
                                    </div>
                                    <div class="course-card1-author-price d-flex align-items-end justify-content-between">
                                        <div class="author d-flex align-items-center">
                                            <div class="profile">
                                                <img src="{{ course_instructor_image($row->id) }}" alt="">
                                            </div>
                                            <p class="name">{{ course_by_instructor($row->id)->name }}</p>
                                        </div>
                                        <div class="prices">
                                            @if (isset($row->is_paid) && $row->is_paid == 0)
                                                <p class="new-price">{{ get_phrase('Free') }}</p>
                                            @elseif (isset($row->discount_flag) && $row->discount_flag == 1)
                                                <p class="old-price">{{ currency(number_format($row->price, 2)) }}</p>
                                                <p class="new-price">{{ currency(number_format($row->discounted_price, 2)) }}</p>
                                            @else
                                                <p class="new-price">{{ currency(number_format($row->price, 2)) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            @if (count($top_courses) > 3)
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('courses') }}" class="border-btn1">{{ get_phrase('View More') }}</a>
                        </div>
                    </div>
            @endif
        </div>
        </div>
    </section>
    <!-- Top Rated Course Area End -->

    <!-- Testimonials Area Start -->
    <section>
        <div class="container">
            <!-- Section title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="home1-section-title elegant-testimonial-title">
                        <h1 class="title mb-20 fw-500">{{ get_phrase('What the people Thinks About Us') }}</h1>
                        <p class="info">
                            {{ get_phrase("It highlights feedback and testimonials from users, reflecting their experiences and satisfaction.") }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonials -->
        <div class="elegant-testimonials-wrap mb-50">
            <div class="swiper elegant-testimonial-1">
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
                                        <img src="{{ get_image($userDetails->photo) }}" alt="">
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
            </div>

        </div>
    </section>
    <!-- Testimonials Area End -->

    <!-- Question and Answer Area Start -->
    <section>
        <div class="container mb-80 pt-4">
            <!-- Section title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="home1-section-title">
                        <h1 class="title fw-500">{{ get_phrase('Frequently Asked Questions') }}</h1>
                    </div>
                </div>
            </div>
            <!-- QNA Accordion -->
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion qnaaccordion-one" id="accordionExample1">
                        @php
                            $faqs = count(json_decode(get_frontend_settings('website_faqs'), true)) > 0 ? json_decode(get_frontend_settings('website_faqs'), true) : [['question' => '', 'answer' => '']];
                        @endphp
                        @foreach ($faqs as $key => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{ $key }}">
                                    <button class="accordion-button  {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#qnaOne{{ $key }}" aria-expanded="true" aria-controls="qnaOne">
                                        {{ $faq['question'] }}
                                    </button>
                                </h2>
                                <div id="qnaOne{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }} px-0" aria-labelledby="{{ $key }}" data-bs-parent="#accordionExample1">
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
    </section>
    <!-- Question and Answer Area End -->

    <!-- Top Rated Course Area Start -->
    @if (get_frontend_settings('blog_visibility_on_the_home_page'))
        <section>
            <div class="container mb-60">
                <!-- Section title -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="home1-section-title">
                            <h1 class="title mb-20 fw-500">{{ get_phrase('Our Latest Blog') }}</h1>
                            <p class="info">
                                {{ get_phrase("The latest blog highlights the most recent articles, updates, and insights from our platform.") }}</p>
                        </div>
                    </div>
                </div>
                <!-- Courses -->
                <div class="row row-20">

                    @foreach ($blogs as $key => $blog)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <a href="{{ route('blog.details', $blog->slug) }}" class="blog-post1-link">
                                <div class="blog-post1-inner">
                                    <div class="banner">
                                        <img src="{{ get_image($blog->thumbnail) }}" alt="...">
                                    </div>
                                    <div class="blog-post1-details">
                                        <h3 class="title fw-500 mb-3 pt-2 ellipsis-line-2">{{ ucfirst($blog->title) }}</h3>
                                        <p class="info ellipsis-line-2">{{ ellipsis(strip_tags($blog->description), 160) }}</p>
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

    <!-- Top Rated Course Area End -->
    @if (get_frontend_settings('mobile_app_link'))
        <!-- Download Area Start -->
        <section class="home1-download-section">
            <div class="container">
                <div class="row mb-60">
                    <div class="col-md-12">
                        <div class="home1-download-area">
                            <h1 class="title">{{ get_phrase('Download our mobile app, start learning today') }}</h1>
                            <p class="info mb-30">{{ get_phrase('Includes all Course && Features') }}</p>
                            <div class="buttons d-flex align-items-center justify-content-center flex-wrap">
                                <a href="{{ get_frontend_settings('mobile_app_link') }}" target="_blank" class="theme-btn1">{{ get_phrase('Get Bundle') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Download Area End -->
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

        function scrollToSmoothly(pos, time) {
            if (isNaN(pos)) {
                throw "Position must be a number";
            }
            if (pos < 0) {
                throw "Position can not be negative";
            }
            var currentPos = window.scrollY || window.screenTop;
            if (currentPos < pos) {
                var t = 10;
                for (let i = currentPos; i <= pos; i += 10) {
                    t += 10;
                    setTimeout(function() {
                        window.scrollTo(0, i);
                    }, t / 2);
                }
            } else {
                time = time || 2;
                var i = currentPos;
                var x;
                x = setInterval(function() {
                    window.scrollTo(0, i);
                    i -= 10;
                    if (i <= pos) {
                        clearInterval(x);
                    }
                }, time);
            }
        }
    </script>

@endsection
