@extends('layouts.instructor')
@push('title', get_phrase('Become an instructor'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $applications_count = App\Models\Application::where('user_id', Auth()->user()->id)->get();
    @endphp
    <div class="mainSection-title ps-2px d-flex justify-content-between">
        <h4>{{ get_phrase('Become an instructor') }}</h4>

    </div>


    @if (auth()->user()->role != 'instructor')
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        @if ($applications_count->count() == 0)
                            @include('instructor.become_an_instructor.application_form')
                        @else
                            @include('instructor.become_an_instructor.application_list')
                        @endif
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <h4 class="alert-heading">{{ get_phrase('Congratulations !') }}</h4>
            <p>{{ get_phrase('You are already an instructor') }}</p>
        </div>
    @endif




    <style media="screen">
        body {
            overflow-x: hidden;
        }
    </style>
@endsection
@push('js')@endpush
