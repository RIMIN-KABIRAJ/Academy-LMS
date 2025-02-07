@extends('layouts.default')
@push('title', get_phrase('My Bootcamps'))
@section('content')
    <section class="my-course-content mt-50">
        <div class="profile-banner-area"></div>
        <div class="profile-banner-area-container container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9">
                    <h4 class="g-title text-capitalize">{{ get_phrase('My Bootcamps') }}</h4>
                    <div class="my-panel mt-5">
                        <div class="row">
                            @if (count($my_bootcamps) > 0)
                                <ul class="my-bootcamps">
                                    @foreach ($my_bootcamps as $bootcamp)
                                        <li class="p-0" id="bootcamp-{{ $bootcamp->id }}">
                                            <a href="{{ route('my.bootcamp.details', $bootcamp->slug) }}" class="bootcamp d-flex gap-4">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="bootcamp-thumbnail">
                                                            <img src="{{ get_image($bootcamp->thumbnail) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-9">
                                                        <div class="bootcamp-details">
                                                            <div class="inner">
                                                                <h4 class="bootcamp-title">
                                                                    <span class="ellipsis-2">{{ $bootcamp->title }}</span>
                                                                    <i class="fi fi-br-angle-small-right"></i>
                                                                </h4>

                                                                <p class="d-inline-block me-4">
                                                                    <span>
                                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-0">
                                                                            <path d="M18.3307 10.0003C18.3307 14.6003 14.5974 18.3337 9.9974 18.3337C5.3974 18.3337 1.66406 14.6003 1.66406 10.0003C1.66406 5.40033 5.3974 1.66699 9.9974 1.66699C14.5974 1.66699 18.3307 5.40033 18.3307 10.0003Z"
                                                                                stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                                                            </path>
                                                                            <path d="M13.0875 12.65L10.5042 11.1083C10.0542 10.8416 9.6875 10.2 9.6875 9.67497V6.2583" stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                                                            </path>
                                                                        </svg>
                                                                    </span>
                                                                    {{ date('d M, Y', $bootcamp->publish_date) }}
                                                                </p>

                                                                <p class="d-inline-block me-4">
                                                                    <span>
                                                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-0">
                                                                            <path d="M1.67188 7.5V6.66667C1.67188 4.16667 3.33854 2.5 5.83854 2.5H14.1719C16.6719 2.5 18.3385 4.16667 18.3385 6.66667V13.3333C18.3385 15.8333 16.6719 17.5 14.1719 17.5H13.3385" stroke="#6B7385" stroke-width="1.25"
                                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                                            <path d="M3.07812 9.7583C6.92813 10.25 9.75313 13.0833 10.2531 16.9333" stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                            <path d="M2.1875 12.5586C5.0125 12.9169 7.08751 15.0003 7.45417 17.8253" stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                            <path d="M1.65234 15.7168C3.06068 15.9001 4.10235 16.9335 4.28568 18.3501" stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                                                                        </svg>
                                                                    </span>
                                                                    <span>{{ count_bootcamp_classes($bootcamp->id) }}</span>
                                                                    <span>{{ get_phrase('Live class') }}</span>
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
            @if (count($my_bootcamps) > 0)
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $my_bootcamps->links() }}
                    </nav>
                </div>
            @endif
            <!-- Pagination -->
        </div>
    </section>
    <!------------ My wishlist area End  ------------>
@endsection
