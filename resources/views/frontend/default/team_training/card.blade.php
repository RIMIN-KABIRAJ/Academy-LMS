<div class="col-lg-12 col-sm-6 mb-30">
    <div class="single-feature w-100">
        <div class="row">
            <div class="col-lg-4">
                <a href="{{ route('team.package.details', $package->slug) }}" class="package-img-container">
                    <img src="{{ get_image($package->thumbnail) }}" alt="package-thumbnail">
                    <div class="package-price">
                        <h3>
                            @if ($package->pricing_type == 0)
                                {{ get_phrase('Free') }}
                            @else
                                {{ currency(number_format($package->price, 2)) }}
                                <del>{{ currency(number_format($package->allocation * $package->course_price, 2)) }}</del>
                            @endif
                        </h3>
                    </div>
                </a>
            </div>
            <div class="col-lg-8">
                <div class="entry-details">
                    <div class="entry-title en-title">
                        <h3>
                            <a href="{{ route('team.package.details', $package->slug) }}" class="ellipsis-2"
                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-title="{{ $package->title }}">
                                {{ ucfirst($package->title) }}
                            </a>
                        </h3>
                    </div>

                    <div class="package-detail d-flex justify-content-between">
                        <div class="creator">
                            <img src="{{ get_image($package->creator_photo) }}" alt="author-image">
                            <p><span>{{ $package->creator_name }}</span></p>
                        </div>
                    </div>

                    <div class="description mb-0">
                        <a href="{{ route('course.details', $package->course_slug) }}" class="ellipsis-2"
                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-title="{{ $package->course_title }}">
                            {{ get_phrase('Course : ') }}
                            {{ ellipsis($package->course_title, 150) }}
                        </a>

                        <div class="package-course-details">
                            <ul class="mb-3">
                                <li>
                                    <small>
                                        {{ get_phrase('Members : ') }}
                                        {{ reserved_team_members($package->id) }} /
                                        {{ $package->allocation }}
                                    </small>
                                </li>
                                <li>
                                    <small>
                                        {{ get_phrase('Sold : ') }}
                                        {{ team_package_purchases($package->id) }}
                                    </small>
                                </li>
                                <li>
                                    <small>
                                        {{ get_phrase('Section : ') }}
                                        {{ section_count($package->course_id) }}
                                    </small>
                                </li>
                                <li>
                                    <small>
                                        {{ get_phrase('Lesson : ') }}
                                        {{ lesson_count($package->course_id) }}
                                    </small>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="learn-creator d-flex justify-content-end">
                        <div class="learn-more">
                            <a href="{{ route('team.package.details', $package->slug) }}">
                                {{ get_phrase('Learn more') }}
                                <i class="fa-solid fa-arrow-right-long ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
