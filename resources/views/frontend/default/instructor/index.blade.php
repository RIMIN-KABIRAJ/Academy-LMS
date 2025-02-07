@extends('layouts.default')
@push('title', get_phrase('Instructors'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Instructors') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('Instructors') }}</h3>
                    </div>
                </div>
            </div>
            <p class="showing-text mt-15">{{ get_phrase('Learn to train with the best personal trainer') }}</p>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->
    <!-------------- List Item Start   --------------->
    <div class="eNtery-item entry_instuctor">
        <div class="container">
            <div class="row mt-25 justify-content-center">
                @foreach ($instructors as $instructor)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                        <a href="{{ route('instructor.details', ['name' => slugify($instructor->name), 'id' => $instructor->id]) }}"
                            class="card Ecard eCard2">
                            <div class="card-head radius-10">
                                <img class="radius-10" src="{{ get_image($instructor->photo) }}" alt="instructor-photo">
                            </div>
                            <div class="card-body entry-details text-center mt-0 pb-0">
                                <h4>{{ ucfirst($instructor->name) }}</h4>
                                <span class="gradient color shadow-none">
                                    {{ $instructor->skills ? implode(', ', array_column(json_decode($instructor->skills, true), 'value')) : '' }}
                                </span>
                                <p class="mt-0">{{ $instructor->email }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if (count($instructors) > 0)
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $instructors->links() }}
                    </nav>
                </div>
            @endif
            <!-- Pagination -->
        </div>
    </div>
    <!-------------- List Item End  --------------->
@endsection
