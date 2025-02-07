@extends('layouts.default')
@push('title', get_phrase('Team Packages'))

@section('content')
    <!------------------- Breadcum Area Start  ------>
    <section class="breadcum-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eNtry-breadcum">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">{{ get_phrase('Home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Team Pcakages') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('Team Packages') }}</h3>
                    </div>
                </div>
            </div>
            <div class="row align-items-center mt-3">
                <div class="col-lg-8 col-md-6 col-sm-6 col-6">
                    <p class="showing-text">
                        {{ get_phrase('Showing') . ' ' . count($packages) . ' ' . get_phrase('of') . ' ' . $packages->total() . ' ' . get_phrase('data') }}
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->



    <!-------------- List Item Start   --------------->
    <div class="eNtery-item">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('frontend.default.team_training.filter')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        @foreach ($packages as $package)
                            @include('frontend.default.team_training.card')
                        @endforeach
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
    </div>
    <!-------------- List Item End  --------------->
@endsection
@push('js')@endpush
