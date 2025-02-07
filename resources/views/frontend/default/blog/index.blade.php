@extends('layouts.default')
@push('title', get_phrase('Blog'))
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
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Blog') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('Blogs') }}</h3>
                    </div>
                </div>
            </div>
            <p class="showing-text mt-15">{{ get_phrase('Blog that help beginner designers become true unicorns.') }}</p>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->
    <!-------------- List Item Start   --------------->
    <div class="eNtery-item">
        <div class="container">
            <div class="row mt-25">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach ($blogs as $key => $blog)
                            <div class="col-lg-6 col-md-6 col-sm-6 mb-30">
                                @include('frontend.default.blog.card')
                            </div>
                        @endforeach

                        @if ($blogs->count() == 0)
                            <div class="row bg-white radius-10">
                                <div class="com-md-12">
                                    @include('frontend.default.empty')
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Pagination -->
                    <div class="entry-pagination mt-4">
                        {{ $blogs->links() }}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('frontend.default.blog.filter')
                </div>
            </div>
        </div>
    </div>
    <!-------------- List Item End  --------------->
@endsection
@push('js')@endpush
