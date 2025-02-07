@extends('layouts.default')
@push('title', $package->title)
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
                                <li class="breadcrumb-item active" aria-current="page">{{ $package->title }}
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="course-details pe-auto pe-lg-5">

                        <h2 class="g-title ellipsis-line-2">{{ $package->title }}</h2>
                        <ul class="course-motion-top">
                            <li>
                                <a class="d-flex align-items-center text-dark" href="{{ route('instructor.details', ['name' => slugify($package->creator_name), 'id' => $package->user_id]) }}">
                                    <img class="pro-32" src="{{ get_image($package->creator_photo) }}" alt="instructor-image">
                                    {{ $package->creator_name }}
                                </a>
                            </li>
                            <li>
                                {{ get_phrase('Members : ') }}
                                {{ reserved_team_members($package->id) }} /
                                {{ $package->allocation }}
                            </li>
                            <li>
                                {{ get_phrase('Sold : ') }}
                                {{ team_package_purchases($package->id) }}
                            </li>
                        </ul>
                        <ul class="course-motion-top bottom-motion mt-15 ms-0">
                            <li>
                                {{ get_phrase('Section : ') }}
                                {{ section_count($package->course_id) }}
                            </li>
                            <li>
                                {{ get_phrase('Lesson : ') }}
                                {{ lesson_count($package->course_id) }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 px-4">
                    <div class="hero-details pe-auto">
                        <img src="{{ get_image($package->thumbnail) }}" alt="...">
                    </div>

                    <div class="package-course mt-5">
                        @php
                            $course = App\Models\Course::find($package->course_id);
                        @endphp
                        <h4 class="g-title mb-3">{{ get_phrase('Package Course') }}</h4>
                        @include('frontend.default.course.course_list', ['course' => $course])
                    </div>


                    @include('frontend.default.team_training.feature_section')
                    @include('frontend.default.team_training.creator_section')
                </div>
                <div class="col-lg-4 px-4">
                    @include('frontend.default.team_training.pricing_card')
                </div>
            </div>
        </div>
    </section>
@endsection
