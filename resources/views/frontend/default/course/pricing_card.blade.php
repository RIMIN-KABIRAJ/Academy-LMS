<div class="gradient-border radius-22 page-static-sidebar">
    <div class="ps-box ps-sidebar">
        <div class="hero-details position-relative pt-3 pb-4 mt-0">
            <img class="radius-10" src="{{ get_image($course_details->banner) }}" alt="...">
            <div class="overly-icon" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <a href="javascript:;" class="hero-popup"><i class="fa-solid fa-play"></i></a>
            </div>
        </div>

        @if ($course_details->is_best)
            <span class="d-inline-flex justify-content-center trophy-text w-100 px-2 py-1">
                <img src="{{ asset('assets/frontend/default/image/best-seller.svg') }}" alt="best-seller-icon">{{ get_phrase('Top course') }}</span>
        @endif

        <div class="ps-price d-flex">
            @if (isset($course_details->is_paid) && $course_details->is_paid == 0)
                <h4 class="g-title">{{ get_phrase('Free') }}</h4>
            @elseif (isset($course_details->discount_flag) && $course_details->discount_flag == 1)
                <h4 class="g-title">
                    {{ currency(number_format($course_details->discounted_price, 2)) }}</h4>
                <del>{{ currency(number_format($course_details->price, 2)) }}</del>
            @else
                <h4 class="g-title">{{ currency(number_format($course_details->price, 2)) }}</h4>
            @endif
        </div>

        @php
            if (isset(auth()->user()->id)) {
                $is_enrolled = DB::table('enrollments')
                    ->where('user_id', auth()->user()->id)
                    ->where('course_id', $course_details->id)
                    ->exists();

                $in_cart = DB::table('cart_items')
                    ->where('user_id', auth()->user()->id)
                    ->where('course_id', $course_details->id)
                    ->exists();

                $in_wishlist = DB::table('wishlists')
                    ->where('user_id', auth()->user()->id)
                    ->where('course_id', $course_details->id)
                    ->exists();

                $pending_course_for_payment = DB::table('offline_payments')
                    ->where('user_id', auth()->user()->id)
                    ->where('status', 0)
                    ->first();

                $pending_course = $pending_course_for_payment ? json_decode($pending_course_for_payment->items, true) : [];
            }
        @endphp

        @if (isset(auth()->user()->id))
            @if (in_array($course_details->id, $pending_course))
                <a href="javascript::void(0);" class="eBtn gradient w-100 mb-3">
                    <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                    {{ get_phrase('In progress') }}</a>
            @else
                @if ($is_enrolled)
                    <a href="{{ route('my.courses') }}" class="eBtn gradient w-100 mb-3">
                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                        {{ get_phrase('Start Now') }}</a>
                @else
                    <a href="{{ route('purchase.course', $course_details->id) }}" class="eBtn gradient w-100">
                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                        {{ get_phrase($course_details->is_paid ? get_phrase('Buy Now') : get_phrase('Enroll Now')) }}
                    </a>

                    @if (isset($course_details->is_paid) && $course_details->is_paid == 1)
                        @if ($in_cart)
                            <a href="{{ route('cart.delete', ['id' => $course_details->id]) }}" class="eBtn mt-3 gradient w-100">
                                {{ get_phrase('Remove from cart') }}</a>
                        @else
                            <a href="{{ route('cart.store', $course_details->id) }}" class="eBtn learn-btn w-100 mb-3 mt-3">
                                {{ get_phrase('Add to cart') }}</a>
                        @endif
                    @endif

                    @if ($in_wishlist)
                        <span class="eBtn border gradient w-100 cursor-pointer mt-3 toggleWishItem" onclick="wishlistToggleButton('{{ $course_details->id }}', this)">
                            {{ get_phrase('Remove from wishlist') }}
                        </span>
                    @else
                        <span class="eBtn border learn-btn w-100 cursor-pointer mt-3 toggleWishItem mb-0" onclick="wishlistToggleButton('{{ $course_details->id }}', this)">
                            {{ get_phrase('Add to wishlist') }}</span>
                    @endif
                @endif
            @endif
        @else
            <a href="{{ route('purchase.course', $course_details->id) }}" class="eBtn gradient mt-3 w-100">
                <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                {{ get_phrase($course_details->is_paid ? get_phrase('Buy Now') : get_phrase('Enroll Now')) }}</a>
        @endif


        <ul class="ps-side-feature mt-2">
            <li class="d-flex justify-content-between align-items-center py-3 mb-0">
                <span>
                    <img src="{{ asset('assets/frontend/default/image/m1.png') }}" alt="...">
                    <p>{{ get_phrase('Students') }}</p>
                </span>
                {{ total_enroll($course_details->id) }}
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 mb-0">
                <span>
                    <img src="{{ asset('assets/frontend/default/image/language2.png') }}" alt="...">
                    <p>{{ get_phrase('Language') }}</p>
                </span>
                {{ ucfirst($course_details->language) }}
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 mb-0">
                <span>
                    <img src="{{ asset('assets/frontend/default/image/time.png') }}" alt="...">
                    <p>{{ get_phrase('Duration') }}</p>
                </span>
                {{ total_durations($course_details->id) }}
            </li>
            <li class="d-flex justify-content-between align-items-center py-3 mb-0">
                <span>
                    <i class="fi fi-rr-dashboard"></i>
                    <p>{{ get_phrase('Level') }}</p>
                </span>
                {{ $course_details->level }}
            </li>
        </ul>

        @php
            if (isset($user_data['unique_identifier'])):
                $ref = $user_data['unique_identifier'];
            else:
                $ref = '';
            endif;
            $share_url = route('course.details', $course_details->slug);
        @endphp
        <div class="w-100 px-4 pb-2 text-center mt-3">
            <span>{{ get_phrase('Share') }} :</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_url }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-facebook" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Facebook') }}" data-bs-placement="top">
                <i class="fab fa-facebook text-20"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ $share_url }}&text={{ $course_details['title'] }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-twitter" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Twitter') }}" data-bs-placement="top">
                <i class="fab fa-twitter text-20"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ $share_url }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-whatsapp" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Whatsapp') }}" data-bs-placement="top">
                <i class="fab fa-whatsapp text-20"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?url={{ $share_url }}&title={{ $course_details['title'] }}&summary={{ $course_details['short_description'] }}&ref={{ $ref }}" target="_blank" class="p-2 mx-2 color-linkedin" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Linkedin') }}" data-bs-placement="top">
                <i class="fab fa-linkedin text-20"></i>
            </a>
        </div>
    </div>
</div>

<script>
    'use strict';

    function wishlistToggleButton(course_id, elem) {
        $.ajax({
            type: "get",
            url: "{{ route('toggleWishItem') }}" + '/' + course_id,
            success: function(response) {
                if (response) {
                    if (response.toggleStatus == 'added') {
                        $(elem).removeClass('learn-btn');
                        $(elem).addClass('gradient');
                        $(elem).html('{{ get_phrase('Remove from wishlist') }}');
                    } else if (response.toggleStatus == 'removed') {
                        $(elem).removeClass('gradient');
                        $(elem).addClass('learn-btn');
                        $(elem).html('{{ get_phrase('Add to wishlist') }}');
                    }
                }
            }
        });
    }
</script>

@include('frontend.default.scripts')
