@extends('layouts.default')
@push('title', $package->title)

@section('content')
    <section class="my-course-content mt-50">
        <div class="profile-banner-area"></div>
        <div class="profile-banner-area-container container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')


                <div class="col-lg-9">
                    <h4 class="g-title text-capitalize">{{ get_phrase('My Team Packages') }}</h4>
                    @if ($package)
                        <div class="team-package my-panel mt-5">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="package-thumbnail mb-md-0 mb-3">
                                        <img src="{{ get_image($package->thumbnail) }}">
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="bootcamp-details">
                                        <div class="inner">
                                            <h4 class="package-title bootcamp-title mb-2">
                                                <span class="ellipsis-2">{{ $package->title }}</span>
                                            </h4>

                                            <p class="ellipsis-2">
                                                {{ get_phrase('Course : ') }}
                                                {{ $package->course_title }}
                                            </p>


                                            <p class="d-inline-block me-4">
                                                {{ get_phrase('Expiry : ') }}
                                                @if ($package->expiry == 'lifetime')
                                                    {{ get_phrase('Lifetime') }}
                                                @else
                                                    {{ date('d-M-Y', $package->expiry_date) }}
                                                @endif
                                            </p>

                                            <p class="d-inline-block me-4">
                                                {{ get_phrase('Members : ') }}
                                                {{ $package->allocation }} /
                                                {{ reserved_team_members($package->id) }}
                                            </p>

                                            <p class="d-inline-block me-4">
                                                {{ get_phrase('Sections : ') }}
                                                {{ section_count($package->course_id) }}
                                            </p>

                                            <p class="d-inline-block me-4">
                                                {{ get_phrase('Lessons : ') }}
                                                {{ lesson_count($package->course_id) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-pills border-bottom mb-3 mt-5 pb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="members-tab" data-bs-toggle="pill" data-bs-target="#members" type="button" role="tab" aria-controls="members" aria-selected="true">{{ get_phrase('Members') }}</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="invoice-tab" data-bs-toggle="pill" data-bs-target="#invoice" type="button" role="tab" aria-controls="invoice" aria-selected="false">{{ get_phrase('Invoice') }}</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        @include('frontend.default.student.my_team_packages.members')
                                        @include('frontend.default.student.my_team_packages.invoice')
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        @include('frontend.default.empty')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
