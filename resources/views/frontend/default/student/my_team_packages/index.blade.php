@extends('layouts.default')
@push('title', get_phrase('My Team Packages'))
@section('content')
    <section class="my-course-content mt-50">
        <div class="profile-banner-area"></div>
        <div class="profile-banner-area-container container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9">
                    <h4 class="g-title text-capitalize">{{ get_phrase('My Team Packages') }}</h4>
                    <div class="my-panel mt-5">
                        <div class="row">
                            @if (count($packages) > 0)
                                <ul class="my-bootcamps">
                                    @foreach ($packages as $package)
                                        <li class="p-0" id="package-{{ $package->id }}">
                                            <a href="{{ route('my.team.packages.details', $package->slug) }}" class="bootcamp d-block">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="package-thumbnail mb-md-0 mb-3">
                                                            <img src="{{ get_image($package->thumbnail) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-9">
                                                        <div class="bootcamp-details">
                                                            <div class="inner">
                                                                <h4 class="bootcamp-title mb-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $package->title }}">
                                                                    <span class="ellipsis-2">{{ $package->title }}</span>
                                                                    <i class="fi fi-br-angle-small-right"></i>
                                                                </h4>

                                                                <p class="fs-4 ellipsis-2">
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
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                @include('frontend.default.empty')
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if (count($packages) > 0)
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $packages->links() }}
                    </nav>
                </div>
            @endif
            <!-- Pagination -->
        </div>
    </section>
    <!------------ My wishlist area End  ------------>
@endsection
