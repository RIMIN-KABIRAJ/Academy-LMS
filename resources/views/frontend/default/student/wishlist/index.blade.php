@extends('layouts.default')
@push('title', get_phrase('Wishlist'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <section class="wishlist-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')



                <div class="col-lg-9">
                    <h4 class="g-title">{{ get_phrase('Wishlisted courses') }}</h4>
                    <div class="row mt-5">
                        @foreach ($wishlist as $wishitem)
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-30">
                                <a href="{{ route('course.details', $wishitem->slug) }}" class="">
                                    <div class="card Ecard g-card wish-card">
                                        <div class="card-head">
                                            <img src="{{ get_image($wishitem->course_thumbnail) }}" alt="{{ get_phrase('course_thumbnail') }}">
                                        </div>
                                        <div class="card-body entry-details">
                                            <div class="info-card">
                                                <div class="creator">
                                                    <img src="{{ get_image($wishitem->user_photo) }}" alt="{{ get_phrase('user_photo') }}">
                                                    <h5>{{ $wishitem->user_name }}</h5>
                                                </div>
                                                <span data-bs-toggle="tooltip" data-bs-title="{{get_phrase('Remove from wishlist')}}" class="heart fill-heart toggleWishItem" id="item-{{ $wishitem->course_id }}"><i class="fa-solid fa-heart"></i></span>
                                            </div>
                                            <div class="entry-title">
                                                <h3 class="w-100 ellipsis-line-2">{{ $wishitem->title }}</h3>
                                            </div>
                                            <div class="ct-text">
                                                <h4>
                                                    @if ($wishitem->is_paid == 0)
                                                        {{ get_phrase('Free') }}
                                                    @else
                                                        @if ($wishitem->discount_flag == 1)
                                                            @php $discounted_price = number_format(($wishitem->discounted_price), 2) @endphp
                                                            {{ currency($discounted_price) }}
                                                        @else
                                                            {{ currency(number_format($wishitem->price, 2)) }}
                                                        @endif
                                                    @endif
                                                </h4>
                                                <p><span>4.8</span><i class="fa fa-star"></i></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach

                    </div>
                    @if ($wishlist->count() == 0)
                        <div class="row bg-white radius-10 mx-2">
                            <div class="com-md-12">
                                @include('frontend.default.empty')
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if (count($wishlist) > 0)
            <div class="entry-pagination">
                <nav aria-label="Page navigation example">
                    {{ $wishlist->links() }}
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
