@extends('layouts.default')
@push('title', get_phrase('My Courses'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @include('frontend.default.my_courses.my_course_banner')
    <!------------ My Courses  Area End  ------------>
    <section class="course-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('frontend.default.my_courses.left_sidebar')
                </div>
                <div class="col-lg-9">
                    <h4 class="g-title">{{ get_phrase('My Courses') }}</h4>
                    <div class="row mt-5">
                        @foreach ($courses as $row)
                            @php $course_progress = progress_bar($row->course_id); @endphp
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-30">
                                <div class="card ol-card p-4 g-card c-card">
                                    <div class="card-head">
                                        <img src="{{ get_course_image($row->course_id) }}" alt="...">
                                    </div>
                                    <div class="card-body entry-details">
                                        <div class="info-card mb-15">
                                            <div class="creator">
                                                <img src="{{ get_image_by_id(course_by_instructor($row->course_id)->id) }}" alt="...">
                                                <h5>{{ course_by_instructor($row->course_id)->name }}</h5>
                                            </div>
                                        </div>
                                        <div class="entry-title">
                                            <h3 class="w-100 ellipsis-line-2">{{ ellipsis(get_course_info($row->course_id)->title, 160) }}</h3>
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

                                        @if ($course_progress > 0)
                                            <a href="#" class="eBtn learn-btn w-100 text-center mt-20 f-500">{{ get_phrase('Continue') }}</a>
                                        @else
                                            <a href="#" class="eBtn learn-btn w-100 text-center mt-20 f-500">{{ get_phrase('Start Now') }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ My Courses  Area End  ------------>
@endsection
@push('js')@endpush
