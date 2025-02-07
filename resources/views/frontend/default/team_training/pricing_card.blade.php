<div class="gradient-border radius-22 page-static-sidebar">
    <div class="ps-box ps-sidebar static-menu p-30">
        <div class="ps-price d-flex">
            @if ($package->pricing_type == 0)
                <h4 class="g-title">{{ get_phrase('Free') }}</h4>
            @else
                <div class="d-flex flex-column gap-3">
                    <h4 class="g-title p-0">{{ currency(number_format($package->price, 2)) }}</h4>
                    <del class="m-0 mb-4">{{ currency(number_format($package->allocation * $package->course_price, 2)) }}</del>
                </div>
            @endif
        </div>



        @php
            if (isset(auth()->user()->id)) {
                $is_purchased = DB::table('team_package_purchases')
                    ->where('user_id', auth()->user()->id)
                    ->where('package_id', $package->id)
                    ->where('status', 1)
                    ->exists();

                $pending_package_payment = DB::table('offline_payments')
                    ->where('user_id', auth()->user()->id)
                    ->where('item_type', 'package')
                    ->where('items', $package->id)
                    ->where('status', 0)
                    ->first();
            }
        @endphp

        @if (isset(auth()->user()->id))
            @if ($pending_package_payment)
                <a href="{{ route('purchase.team.package', $package->id) }}" class="eBtn gradient w-100 mb-3">
                    <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                    {{ get_phrase('Processing') }}</a>
            @else
                @if ($is_purchased)
                    <a href="{{ route('my.team.packages.details', $package->slug) }}" class="eBtn gradient w-100 mb-3">
                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                        {{ get_phrase('Show In Collection') }}</a>
                @else
                    <a href="{{ route('purchase.team.package', $package->id) }}" class="eBtn gradient w-100">
                        <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                        {{ get_phrase($package->pricing_type ? 'Buy Package' : 'Enroll Package') }}
                    </a>
                @endif
            @endif
        @else
            <a href="{{ route('purchase.team.package', $package->id) }}" class="eBtn gradient w-100">
                <img src="{{ asset('assets/frontend/default/image/enroll.png') }}" alt="...">
                {{ get_phrase($package->pricing_type ? 'Buy Package' : 'Enroll Package') }}</a>
        @endif


        <ul class="ps-side-feature">
            <li class="d-flex justify-content-between align-items-center">
                <span>
                    <img src="{{ asset('assets/frontend/default/image/m1.png') }}" alt="...">
                    <p>{{ get_phrase('Members') }}</p>
                </span>
                {{ reserved_team_members($package->id) }} /
                {{ $package->allocation }}
            </li>
            <li class="d-flex justify-content-between align-items-center">
                <span class="align-items-center">
                    <i class="fi fi-rr-book-alt d-inline-flex text-18"></i>
                    <p>{{ get_phrase('Sections') }}</p>
                </span>
                {{ section_count($package->course_id) }}
            </li>
            <li class="d-flex justify-content-between align-items-center">
                <span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="m-0">
                        <path d="M1.67188 7.5V6.66667C1.67188 4.16667 3.33854 2.5 5.83854 2.5H14.1719C16.6719 2.5 18.3385 4.16667 18.3385 6.66667V13.3333C18.3385 15.8333 16.6719 17.5 14.1719 17.5H13.3385" stroke="#6b7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.07812 9.7583C6.92813 10.25 9.75313 13.0833 10.2531 16.9333" stroke="#6b7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2.1875 12.5586C5.0125 12.9169 7.08751 15.0003 7.45417 17.8253" stroke="#6b7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1.65234 15.7168C3.06068 15.9001 4.10235 16.9335 4.28568 18.3501" stroke="#6b7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p>{{ get_phrase('Lessons') }}</p>
                </span>
                {{ lesson_count($package->course_id) }}
            </li>
            <li class="d-flex justify-content-between align-items-center">
                <span>
                    <svg width="20" height="20" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24">
                        <path fill="#6b7385"
                            d="m14,19h-4.443c-2.535,0-4.67-1.898-4.966-4.416L3.215,2.883c-.059-.503-.486-.883-.993-.883h-1.222c-.552,0-1-.448-1-1S.448,0,1,0h1.222c1.521,0,2.801,1.139,2.979,2.649l.041.351h15.757c.902,0,1.748.4,2.32,1.098s.799,1.605.622,2.49c-.915,4.566-.931,4.628-.941,4.665-.118.449-.523.747-.967.747-.084,0-.169-.01-.254-.033-.525-.138-.843-.668-.721-1.193.058-.269.921-4.578.921-4.578.059-.294-.017-.597-.208-.83-.19-.233-.472-.366-.773-.366H5.478l.941,8h7.581c.552,0,1,.448,1,1s-.448,1-1,1h-7.263c.416,1.174,1.528,2,2.82,2h4.443c.552,0,1,.448,1,1s-.448,1-1,1Zm-7,1c-1.105,0-2,.895-2,2s.895,2,2,2,2-.895,2-2-.895-2-2-2Zm12-7c-1.379,0-2.5,1.121-2.5,2.5s1.121,2.5,2.5,2.5,2.5-1.121,2.5-2.5-1.121-2.5-2.5-2.5Zm0,6c-2.333,0-4.375,1.538-4.966,3.741-.143.533.173,1.082.707,1.225.532.143,1.082-.173,1.225-.707.357-1.33,1.605-2.259,3.034-2.259s2.677.929,3.034,2.259c.12.447.524.741.965.741.085,0,.173-.011.26-.035.533-.143.85-.692.707-1.225-.591-2.203-2.633-3.741-4.966-3.741Z" />
                    </svg>
                    <p>{{ get_phrase('Purchase') }}</p>
                </span>
                {{ team_package_purchases($package->id) }}
            </li>
        </ul>


        @php
            $instructor = get_user_info($package->user_id);
        @endphp

        @if (isset($instructor->twitter) || isset($instructor->facebook) || isset($instructor->linkedin) || isset($instructor->instagram))
            <ul class="f-socials d-flex flex-column gap-3">
                <p class="description text-14 text-center">{{ get_phrase('Contact Instructor') }}</p>
                <div class="d-flex justify-content-center gap-3">
                    @isset($instructor->twitter)
                        <li><a href="{{ $instructor->twitter }}"><i class="fa-brands fa-twitter"></i></a></li>
                    @endisset

                    @isset($instructor->facebook)
                        <li><a href="{{ $instructor->facebook }}"><i class="fa-brands fa-facebook-f"></i></a></li>
                    @endisset

                    @isset($instructor->linkedin)
                        <li><a href="{{ $instructor->linkedin }}"><i class="fa-brands fa-linkedin-in"></i></a></li>
                    @endisset

                    @isset($instructor->instagram)
                        <li><a href="{{ $instructor->instagram }}"><i class="fa-brands fa-instagram"></i></a></li>
                    @endisset
                </div>
            </ul>
        @endif

        @if ($instructor->phone)
            <div class="dt_group mt-3">
                <p class="description mb-15 text-center">
                    {{ get_phrase('For details about the course') }}</p>
                <a href="tel:{{ $instructor->phone }}" class="d-flex justify-content-center"><img src="{{ asset('assets/frontend/default/image/call.svg') }}" alt="...">{{ get_phrase('Call Us') }}: <p>
                        {{ $instructor->phone }}</p> </a>
            </div>
        @endif

        @php
            if (isset($user_data['unique_identifier'])):
                $ref = $user_data['unique_identifier'];
            else:
                $ref = '';
            endif;
            $share_url = route('team.package.details', $package->slug);
        @endphp
        <div class="w-100 mt-3 px-4 text-center">
            <p class="description text-14 text-center">{{ get_phrase('Share on social media') }}</p>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $share_url }}&ref={{ $ref }}" target="_blank" class="p-2" style="color: #316FF6;" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Facebook') }}" data-bs-placement="top">
                <i class="fab fa-facebook text-20"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ $share_url }}&text={{ $package->title }}&ref={{ $ref }}" target="_blank" class="p-2" style="color: #1DA1F2;" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Twitter') }}" data-bs-placement="top">
                <i class="fab fa-twitter text-20"></i>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ $share_url }}&ref={{ $ref }}" target="_blank" class="p-2" style="color: #128c7e;" data-bs-toggle="tooltip" title="{{ get_phrase('Share on Whatsapp') }}" data-bs-placement="top">
                <i class="fab fa-whatsapp text-20"></i>
            </a>
            <a href="https://www.linkedin.com/shareArticle?url={{ $share_url }}&title={{ $package->title }}&summary={{ $package->course_title }}&ref={{ $ref }}" target="_blank" class="p-2" style="color: #0077b5;" data-bs-toggle="tooltip"
                title="{{ get_phrase('Share on Linkedin') }}" data-bs-placement="top">
                <i class="fab fa-linkedin text-20"></i>
            </a>
        </div>
    </div>
</div>

@include('frontend.default.scripts')
