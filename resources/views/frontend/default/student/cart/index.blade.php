@extends('layouts.default')
@push('title', get_phrase('Cart'))
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
                                <li class="breadcrumb-item active" aria-current="page">{{ get_phrase('Shopping cart') }}</li>
                            </ol>
                        </nav>
                        <h3 class="g-title">{{ get_phrase('Shopping cart') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------- Breadcum Area End  --------->


    <!-------------- Cart list Item Start   --------------->
    <div class="eNtery-item cart-items">
        <div class="container">
            <div class="entry_panel">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-20">
                            <h4 class="g-title text-20">{{ get_phrase('Cart items') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-lg-8">
                        @php $count_items_price = 0; @endphp
                        @if (count($cart_items) > 0)
                            <div class="row">
                                @foreach ($cart_items as $course)
                                    <div class="col-lg-12 col-md-12 col-sm-6 mb-30 pb-4">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3">
                                                <img class="radius-10 object-fit-cover w-100" height="160px" src="{{ get_image($course->thumbnail) }}" alt="course-thumbnail">
                                            </div>
                                            <div class="col-lg-9 col-md-9">
                                                <div class="entry-details">
                                                    <div class="entry-title en-title">
                                                        <h3 class="ellipsis-2">{{ ucfirst($course->title) }}</h3>
                                                    </div>
                                                    <p class="description ellipsis-2">{{ ellipsis($course->description, 150) }}</p>
                                                    <div class="learn-creator">
                                                        <div class="creator">
                                                            <h4>
                                                                @if ($course->is_paid == 0)
                                                                    <b class="text-dark">{{ get_phrase('Free') }}</b>
                                                                @else
                                                                    @if ($course->discount_flag == 1)
                                                                        @php
                                                                            $count_items_price += $course->discounted_price;
                                                                        @endphp
                                                                        @php $discounted_price = number_format(($course->discounted_price), 2) @endphp
                                                                        <b class="text-dark">{{ currency($discounted_price) }}</b>
                                                                        <del class="text-12px">{{ currency(number_format($course->price, 2)) }}</del>
                                                                    @else
                                                                        @php
                                                                            $count_items_price += $course->price;
                                                                        @endphp
                                                                        <b class="text-dark">{{ currency(number_format($course->price, 2)) }}</b>
                                                                    @endif
                                                                @endif
                                                            </h4>
                                                        </div>
                                                        <div class="learn-more">
                                                            <a data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" href="{{ route('cart.delete', ['id' => $course->id]) }}">
                                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path
                                                                        d="M21 4H17.9C17.6679 2.87141 17.0538 1.85735 16.1613 1.12872C15.2687 0.40009 14.1522 0.00145452 13 0L11 0C9.8478 0.00145452 8.73132 0.40009 7.83875 1.12872C6.94618 1.85735 6.3321 2.87141 6.1 4H3C2.73478 4 2.48043 4.10536 2.29289 4.29289C2.10536 4.48043 2 4.73478 2 5C2 5.26522 2.10536 5.51957 2.29289 5.70711C2.48043 5.89464 2.73478 6 3 6H4V19C4.00159 20.3256 4.52888 21.5964 5.46622 22.5338C6.40356 23.4711 7.67441 23.9984 9 24H15C16.3256 23.9984 17.5964 23.4711 18.5338 22.5338C19.4711 21.5964 19.9984 20.3256 20 19V6H21C21.2652 6 21.5196 5.89464 21.7071 5.70711C21.8946 5.51957 22 5.26522 22 5C22 4.73478 21.8946 4.48043 21.7071 4.29289C21.5196 4.10536 21.2652 4 21 4ZM11 2H13C13.6203 2.00076 14.2251 2.19338 14.7316 2.55144C15.2381 2.90951 15.6214 3.41549 15.829 4H8.171C8.37858 3.41549 8.7619 2.90951 9.26839 2.55144C9.77487 2.19338 10.3797 2.00076 11 2ZM18 19C18 19.7956 17.6839 20.5587 17.1213 21.1213C16.5587 21.6839 15.7956 22 15 22H9C8.20435 22 7.44129 21.6839 6.87868 21.1213C6.31607 20.5587 6 19.7956 6 19V6H18V19Z"
                                                                        fill="#192335" />
                                                                    <path d="M10 18C10.2652 18 10.5196 17.8946 10.7071 17.7071C10.8946 17.5196 11 17.2652 11 17V11C11 10.7348 10.8946 10.4804 10.7071 10.2929C10.5196 10.1054 10.2652 10 10 10C9.73478 10 9.48043 10.1054 9.29289 10.2929C9.10536 10.4804 9 10.7348 9 11V17C9 17.2652 9.10536 17.5196 9.29289 17.7071C9.48043 17.8946 9.73478 18 10 18Z" fill="#192335" />
                                                                    <path d="M14 18C14.2652 18 14.5196 17.8946 14.7071 17.7071C14.8946 17.5196 15 17.2652 15 17V11C15 10.7348 14.8946 10.4804 14.7071 10.2929C14.5196 10.1054 14.2652 10 14 10C13.7348 10 13.4804 10.1054 13.2929 10.2929C13.1054 10.4804 13 10.7348 13 11V17C13 17.2652 13.1054 17.5196 13.2929 17.7071C13.4804 17.8946 13.7348 18 14 18Z" fill="#192335" />
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            @include('frontend.default.empty')
                        @endif
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-total-price px-0 px-lg-4">
                            <h2 class="text-20">{{ get_phrase('Payment summary') }}</h2>

                            <h4 class="price_type sub_total mb-4">
                                <span>{{ get_phrase('Sub total') }}</span>
                                <span>{{ currency(number_format($count_items_price, 2)) }}</span>
                            </h4>

                            @php
                                $coupon_discount = $count_items_price * ($discount / 100);
                                $tax = (get_settings('course_selling_tax') / 100) * ($count_items_price - $coupon_discount);
                            @endphp

                            @if ($discount)
                                <h4 class="price_type tax mb-4">
                                    <span>
                                        {{ get_phrase('Discount') }}
                                        ({{ $discount }}{{ get_phrase('%') }})
                                    </span>
                                    <span>- {{ currency(number_format($coupon_discount, 2)) }}</span>
                                </h4>
                            @endif

                            <h4 class="price_type tax mb-4">
                                <span>
                                    {{ get_phrase('Tax') }}
                                    ({{ get_settings('course_selling_tax') }}{{ get_phrase('%') }})
                                </span>
                                <span>+ {{ currency(number_format($tax, 2)) }}</span>
                            </h4>

                            <h4 class="price_type total mb-4">
                                <span>{{ get_phrase('Total') }}</span>
                                @php $payable = $count_items_price - ($coupon_discount) + $tax; @endphp
                                <span>{{ currency(number_format($payable, 2)) }}</span>
                            </h4>

                            <form action="{{ route('payout') }}" method="post" class="mt-20">@csrf
                                <input type="hidden" name="payable" value="{{ $payable }}">
                                <input type="hidden" name="coupon_code" value="{{ request()->query('coupon') }}">
                                <input type="hidden" name="coupon_discount" value="{{ $coupon_discount }}">
                                <input type="hidden" name="tax" value="{{ $tax }}">
                                <input type="hidden" name="items" value="{{ json_encode($cart_items->pluck('id')) }}">

                                <div class="mt-20">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if (request()->has('coupon') && isset($coupon) && $coupon_discount > 0)
                                                <div class="alert w-100 alert-purple show d-flex align-items-center py-2">
                                                    <div>
                                                        {{ get_phrase('Coupon') }} <strong>{{ get_phrase('Applyed') }} ({{ $coupon->discount }}%) !</strong>
                                                    </div>
                                                    <a href="{{ route('cart') }}" type="button" class="btn ms-auto mt-2"><i class="fi-rr-cross-circle text-14px"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-md-12">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" name="coupon" placeholder="{{ get_phrase('Apply coupon') }}" value="{{ request()->query('coupon') }}">
                                                <button type="button" value="{{ get_phrase('Apply') }}" class="input-group-text eBtn gradient text-white" id="apply-coupon">
                                                    {{ get_phrase('Apply') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-20 send_gift_check">
                                    <div class="form-check">
                                        <input class="form-check-input mt-0" type="checkbox" name="is_gift" value="1" id="send_gift">
                                        <label class="form-check-label" for="send_gift">{{ get_phrase('Send as a gift') }}</label>
                                    </div>

                                    <input type="email" class="form-control mt-15 gifted_user d-none" name="" placeholder="{{ get_phrase('Enter user email') }}">
                                </div>

                                <div class="mt-20">
                                    <input type="submit" class="form-control eBtn gradient text-white" value="{{ get_phrase('Continue to payment') }}" @if ($count_items_price == 0) disabled @endif>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-------------- Cart list Item End  --------------->
@endsection
@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            // submit coupon
            $('#apply-coupon').on('click', function(e) {
                e.preventDefault();
                let code = $('input[name="coupon"]').val();
                window.location.href = "{{ route('cart') }}" + "?coupon=" + code;
            });

            // cancel coupon
            $('#cancel-coupon').on('click', function(e) {
                e.preventDefault();
                window.location.href = "{{ route('cart') }}";
            });

            $('input[name="is_gift"]').change(function(e) {
                if ($(this).prop('checked')) {
                    $('.gifted_user').attr({
                        'name': 'gifted_user_email',
                        'required': '1'
                    }).removeClass('d-none');
                } else {
                    $('.gifted_user').removeAttr('name required').addClass('d-none');
                }
            });
        });
    </script>
@endpush
