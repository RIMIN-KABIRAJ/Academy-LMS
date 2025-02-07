@extends('layouts.frontend')
@push('title', get_phrase(''))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $section = App\Models\Section::where('course_id', $course_details->id)->get();
    @endphp
    <!-- Start Breadcrumb -->

    <section class="h-219" data-background="{{ asset('assets/frontend/images/breadcrumb-2.png') }}">
        <div class="container"></div>
    </section>
    <!-- End Breadcrumb -->

    <!-- Start Course Playing -->
    <section class="mt-n-170">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="max-w-364 m-auto bs-one bd-one bg-white bd-6e798a-10 bd-r-10 p-30">
                        <!-- Content List -->
                        <ul class="ul-ol list-style-one">
                            @foreach ($section as $sections)
                                @php
                                    $lesson = App\Models\Lesson::where('section_id', $sections->id)->get();
                                @endphp
                                <li>
                                    <h4 class="fz-16 fw-600 text-1e293b pb-20">{{ $sections->title }}</h4>
                                    <ul class="ul-ol course-content-items">
                                        @foreach ($lesson as $lessons)
                                            <a href="{{ route('course.player', ['slug' => $course_details->slug, 'id' => $lessons->id]) }}"
                                                class="item @if (Route::currentRouteName() == 'course.player') active @endif">
                                                <div class="left">
                                                    <div class="icon"><span class="courseNo">1</span></div>
                                                    <p class="title">{{ $lessons->title }}</p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- Content -->
                <div class="col-lg-8">
                    <div class="course-playing-content">
                        @isset($lesson_details->lesson_type)
                            @include('frontend.course_player.course_content_body')
                        @endisset
                    </div>
                    <!-- Rating - type -->
                    @php
                        $review_count = App\Models\Review::where('course_id', $course_details->id)
                            ->orderBy('id', 'DESC')
                            ->get();

                        $total = $review_count->count();
                        $rating = array_sum(array_column($review_count->toArray(), 'rating'));

                        $average_rating = 0;
                        if ($total != 0) {
                            $average_rating = $rating / $total;
                        }
                    @endphp
                    <div class="d-flex align-items-center cg-16 pb-20">
                        <div class="d-flex align-items-center cg-8">
                            <ul class="ul-ol d-flex align-items-center cg-5">
                                @if ($review_count->count() > 0)
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $average_rating)
                                            <li class="d-flex align-items-center">
                                                <img src="{{ asset('assets/frontend/images/icon/star-rating.svg') }}"
                                                    alt="" />
                                            </li>
                                        @else
                                            <li class="d-flex align-items-center">
                                                <img src="{{ asset('assets/frontend/images/icon/star-rating-2.svg') }}"
                                                    alt="" />
                                            </li>
                                        @endif
                                    @endfor
                                @else
                                    @for ($i = 0; $i < 5; $i++)
                                        <li class="d-flex align-items-center">
                                            <img src="{{ asset('assets/frontend/images/icon/star-rating-2.svg') }}"
                                                alt="" />
                                        </li>
                                    @endfor
                                @endif
                            </ul>
                            <p class="fz-14 fw-400 lh-18 text-6e798a">({{ $review_count->count() }}
                                {{ get_phrase('Reviews') }})</p>
                        </div>
                        <p class="d-inline-flex bg-f25c88-20 py-5 px-17 bd-r-10 fz-12 fw-400 lh-18 text-f25c88">
                            {{ $course_details->level }}</p>
                    </div>
                    <!-- Content -->

                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- End Course Playing -->
@endsection
@push('js')@endpush
