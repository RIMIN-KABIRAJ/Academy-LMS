@extends('layouts.default')
@push('title', get_phrase('Instructor details'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <style>
        .eBar-card .courses-img img {
            height: 221px !important;
        }
    </style>
    <!------------------- Breadcum Area Start  ------>
    <section class="instructor-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Instructor Details') }}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->
    <!-------------- List Item Start   --------------->
    <section class="instructor-wrapper">
        <div class="container">
            <div class="single-details">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="left-profile">
                            <div class="instruct-img">
                                <div class="instructor-photo">
                                    <img src="{{ get_image($instructor_details->photo) }}" alt="instructor-photo">
                                </div>
                            </div>
                            <div class="btn-wrap">
                                <a href="javascript: void(0);" class="eBtn learn-btn">
                                    {{ count_student_by_instructor($instructor_details->id) }}
                                </a>
                                <a href="javascript: void(0);" class="eBtn gradient">
                                    {{ count_course_by_instructor($instructor_details->id) }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="right-profile">
                            <h3 class="g-title">{{ get_phrase('Hi, I’m') }} {{ $instructor_details->name }}</h3>
                            <span class="gradient color shadow-none">{{ $instructor_details->skill }}</span>
                            <p class="description">{{ $instructor_details->boigraphy }}</p>
                            <ul class="instruct-add">
                                <li>
                                    <p>{{ get_phrase('Experience') }}</p>
                                    <span>: {{ instructor_experience($instructor_details->id) }}</span>
                                </li>
                                @if ($instructor_details->email)
                                    <li>
                                        <p>{{ get_phrase('Email') }}</p><span>: {{ $instructor_details->email }}</span>
                                    </li>
                                @endif
                                @if ($instructor_details->phone)
                                    <li>
                                        <p>{{ get_phrase('Phone') }}</p><span>: {{ $instructor_details->phone }}</span>
                                    </li>
                                @endif
                                @if ($instructor_details->details)
                                    <li>
                                        <p>{{ get_phrase('Location') }}</p><span>:
                                            {{ $instructor_details->details }}</span>
                                    </li>
                                @endif
                            </ul>
                            <ul class="f-socials d-flex">
                                <li>
                                    <a href="{{ $instructor_details->twitter ?? 'javascript: void(0);' }}">
                                        <i class="fa-brands fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $instructor_details->facebook ?? 'javascript: void(0);' }}">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $instructor_details->linkedin ?? 'javascript: void(0);' }}">
                                        <i class="fa-brands fa-linkedin-in"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="group-overly">
                    <span><img class="top-overly" src="{{ asset('assets/frontend/default/image/top-overly.png') }}"
                            alt="..."></span>
                    <span><img class="bottom-overly" src="{{ asset('assets/frontend/default/image/bottom.png') }}"
                            alt="..."></span>
                </div>
            </div>
        </div>
    </section>
    <!-------------- List Item End  --------------->
    <!-------------- My Course Item Start  --------------->
    @if (count($instructor_courses) > 0)
        <section class="feature-wrapper section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="res-control d-flex align-items-center justify-content-between">
                            <div class="section-title mb-0">
                                <h2 class="title">{{ get_phrase('My Courses') }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-50">
                    @foreach ($instructor_courses as $course)
                        @include('frontend.default.course.course_grid', ['course' => $course])
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $instructor_courses->links() }}
                    </nav>
                </div>
                <!-- Pagination -->
            </div>
        </section>
    @endif
    <!-------------- My Course  Item End  --------------->
@endsection
