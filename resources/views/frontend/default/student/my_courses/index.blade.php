@extends('layouts.default')
@push('title', get_phrase('My courses'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <section class="my-course-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9 px-4">
                    <h4 class="g-title">{{ get_phrase('My Courses') }}</h4>
                    <div class="row mt-5">
                        @foreach ($my_courses as $course)
                            @php
                                $course_progress = progress_bar($course->course_id);
                            @endphp
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-30">
                                <div class="card Ecard g-card c-card">
                                    <div class="card-head">
                                        <img src="{{ get_image($course->thumbnail) }}" alt="course-thumbnail">
                                    </div>
                                    <div class="card-body entry-details">
                                        <div class="info-card mb-15">
                                            <div class="creator">
                                                <img src="{{ get_image($course->user_photo) }}" alt="author-image">
                                                <h5>{{ $course->user_name }}</h5>
                                            </div>
                                        </div>
                                        <div class="entry-title">
                                            <a href="{{ route('course.details', $course->slug) }}">
                                                <h3 class="w-100 ellipsis-line-2">{{ ucfirst($course->title) }}</h3>
                                            </a>
                                        </div>
                                        <div class="single-progress">
                                            <div class="d-flex justify-content-between align-items-center mb-10">
                                                <h5>{{ get_phrase('Progress') }}</h5>
                                                <p>{{ $course_progress }}%</p>
                                            </div>
                                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar" style="width: {{ $course_progress }}%"></div>
                                            </div>
                                        </div>


                                        @php
                                            $watch_history = App\Models\Watch_history::where('course_id', $course->course_id)
                                                ->where('student_id', auth()->user()->id)
                                                ->first();

                                            $lesson = App\Models\Lesson::where('course_id', $course->course_id)
                                                ->orderBy('sort', 'asc')
                                                ->first();

                                            if (!$watch_history && !$lesson) {
                                                $url = route('course.player', ['slug' => $course->slug]);
                                            } else {
                                                if ($watch_history) {
                                                    $lesson_id = $watch_history->watching_lesson_id;
                                                } elseif ($lesson) {
                                                    $lesson_id = $lesson->id;
                                                }
                                                $url = route('course.player', ['slug' => $course->slug, 'id' => $lesson_id]);
                                            }

                                        @endphp
                                        @if ($course_progress > 0)
                                            <a href="{{ $url }}" class="eBtn learn-btn w-100 text-center mt-20 f-500">
                                                {{ get_phrase('Continue') }}
                                            </a>
                                        @else
                                            <a href="{{ $url }}" class="eBtn learn-btn w-100 text-center mt-20 f-500">
                                                {{ get_phrase('Start Now') }}
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if ($my_courses->count() == 0)
                            <div class="row bg-white radius-10">
                                <div class="com-md-12">
                                    @include('frontend.default.empty')
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if (count($my_courses) > 0)
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $my_courses->links() }}
                    </nav>
                </div>
            @endif
            <!-- Pagination -->
        </div>
    </section>
    <!------------ My wishlist area End  ------------>
@endsection
@push('js')

@endpush
