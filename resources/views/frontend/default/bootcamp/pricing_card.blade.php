<div class="gradient-border radius-22 page-static-sidebar">
    <div class="ps-box ps-sidebar static-menu p-30 ">
        <div class="ps-price d-flex">
            @if (isset($bootcamp_details->discount_flag) && $bootcamp_details->discount_flag == 1)
                <h4 class="g-title">
                    {{ currency(number_format($bootcamp_details->price - $bootcamp_details->discounted_price, 2)) }}
                </h4>
                <del>{{ currency(number_format($bootcamp_details->price, 2)) }}</del>
            @elseif (isset($bootcamp_details->is_paid) && $bootcamp_details->is_paid == 0)
                <h4 class="g-title">{{ get_phrase('Free') }}</h4>
            @else
                <h4 class="g-title">{{ currency(number_format($bootcamp_details->price, 2)) }}</h4>
            @endif
        </div>

        @php
            if (isset(auth()->user()->id)) {
                $is_purchased = DB::table('bootcamp_purchases')
                    ->where('user_id', auth()->user()->id)
                    ->where('bootcamp_id', $bootcamp_details->id)
                    ->where('status', 1)
                    ->exists();

                $pending_bootcamp_payment = DB::table('offline_payments')
                    ->where('user_id', auth()->user()->id)
                    ->where('item_type', 'bootcamp')
                    ->where('items', $bootcamp_details->id)
                    ->where('status', 0)
                    ->first();
            }
        @endphp

        @if (isset(auth()->user()->id))
            @if ($pending_bootcamp_payment)
                <a href="{{ route('purchase.bootcamp', $bootcamp_details->id) }}" class="eBtn gradient w-100 mb-3">
                    <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                    {{ get_phrase('Processing') }}</a>
            @else
                @if ($is_purchased)
                    <a href="{{ route('my.bootcamp.details', $bootcamp_details->slug) }}"
                        class="eBtn gradient w-100 mb-3">
                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                        {{ get_phrase('Show In Collection') }}</a>
                @else
                    <a href="{{ route('purchase.bootcamp', $bootcamp_details->id) }}" class="eBtn gradient w-100">
                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                        {{ get_phrase($bootcamp_details->is_paid ? 'Buy Bootcamp' : 'Enroll Bootcamp') }}
                    </a>
                @endif
            @endif
        @else
            <a href="{{ route('purchase.bootcamp', $bootcamp_details->id) }}" class="eBtn gradient w-100">
                <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                {{ get_phrase($bootcamp_details->is_paid ? 'Buy Bootcamp' : 'Enroll Bootcamp') }}</a>
        @endif


        <ul class="ps-side-feature">
            <li class="d-flex justify-content-between align-items-center">
                <span>
                    <img src="{{ asset('assets/frontend/default/image/m1.png') }}" alt="...">
                    <p>{{ get_phrase('Students') }}</p>
                </span>
                {{ bootcamp_enrolls($bootcamp_details->id) }}
            </li>
            <li class="d-flex justify-content-between align-items-center">
                <span class="align-items-center">
                    <i class="fi fi-rr-book-alt d-inline-flex text-18"></i>
                    <p>{{ get_phrase('Module') }}</p>
                </span>
                {{ count_bootcamp_modules($bootcamp_details->id) }}
            </li>
            <li class="d-flex justify-content-between align-items-center">
                <span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="m-0">
                        <path
                            d="M1.67188 7.5V6.66667C1.67188 4.16667 3.33854 2.5 5.83854 2.5H14.1719C16.6719 2.5 18.3385 4.16667 18.3385 6.66667V13.3333C18.3385 15.8333 16.6719 17.5 14.1719 17.5H13.3385"
                            stroke="#6b7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.07812 9.7583C6.92813 10.25 9.75313 13.0833 10.2531 16.9333" stroke="#6b7385"
                            stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2.1875 12.5586C5.0125 12.9169 7.08751 15.0003 7.45417 17.8253" stroke="#6b7385"
                            stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1.65234 15.7168C3.06068 15.9001 4.10235 16.9335 4.28568 18.3501" stroke="#6b7385"
                            stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p>{{ get_phrase('Live class') }}</p>
                </span>
                {{ count_bootcamp_classes($bootcamp_details->id) }}
            </li>
            <li class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="fi fi-rr-box-open-full text-20"></i>
                    <p>{{ get_phrase('Resource') }}</p>
                </span>
                {{ get_phrase('Yes') }}
            </li>
            <li class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="fi fi-rr-file-video text-18"></i>
                    <p>{{ get_phrase('Class record') }}</p>
                </span>
                {{ get_phrase('Yes') }}
            </li>
        </ul>
        <ul class="f-socials d-flex flex-column gap-3">
            <p class="description text-center text-14">{{ get_phrase('Contact Instructor') }}</p>
            @php $instructor = $bootcamp_details->instructor; @endphp
            <div class="d-flex justify-content-center gap-3">
                @if (isset($instructor->twitter))
                    <li><a href="{{ $instructor->twitter }}"><i class="fa-brands fa-twitter"></i></a></li>
                @endif

                @if (isset($instructor->facebook))
                    <li><a href="{{ $instructor->facebook }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                @endif
                @if (isset($instructor->linkedin))
                    <li><a href="{{ $instructor->linkedin }}"><i class="fa-brands fa-linkedin-in"></i></a></li>
                @endif
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
            </div>
        </ul>

        @if ($instructor->phone)
            <div class="dt_group mb-3">
                <p class="description text-center mb-15">
                    {{ get_phrase('For details about the course') }}</p>
                <a href="tel:{{ $instructor->phone }}" class="d-flex justify-content-center"><img
                        src="{{ asset('assets/frontend/default/image/call.svg') }}"
                        alt="...">{{ get_phrase('Call Us') }}: <p>
                        {{ $instructor->phone }}</p> </a>
            </div>
        @endif

        @php
            if (isset($user_data['unique_identifier'])):
                $ref = $user_data['unique_identifier'];
            else:
                $ref = '';
            endif;
            $share_url = route('course.details', $bootcamp_details->slug);
        @endphp
        <div class="w-100 px-4 text-center">
            <p class="description text-center text-14">{{ get_phrase('Share on social media') }}</p>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_url }}&ref={{ $ref }}"
                target="_blank" class="p-2" style="color: #316FF6;" data-bs-toggle="tooltip"
                title="{{ get_phrase('Share on Facebook') }}" data-bs-placement="top">
                <i class="fab fa-facebook text-20"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ $share_url }}&text={{ $bootcamp_details['title'] }}&ref={{ $ref }}"
                target="_blank" class="p-2" style="color: #1DA1F2;" data-bs-toggle="tooltip"
                title="{{ get_phrase('Share on Twitter') }}" data-bs-placement="top">
                <i class="fab fa-twitter text-20"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ $share_url }}&ref={{ $ref }}" target="_blank"
                class="p-2" style="color: #128c7e;" data-bs-toggle="tooltip"
                title="{{ get_phrase('Share on Whatsapp') }}" data-bs-placement="top">
                <i class="fab fa-whatsapp text-20"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?url={{ $share_url }}&title={{ $bootcamp_details['title'] }}&summary={{ $bootcamp_details['short_description'] }}&ref={{ $ref }}"
                target="_blank" class="p-2" style="color: #0077b5;" data-bs-toggle="tooltip"
                title="{{ get_phrase('Share on Linkedin') }}" data-bs-placement="top">
                <i class="fab fa-linkedin text-20"></i>
            </a>
        </div>
    </div>
</div>

@include('frontend.default.scripts')
