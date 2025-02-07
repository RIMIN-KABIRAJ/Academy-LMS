@php
    $review = App\Models\Review::where('course_id', $bootcamp->id)
        ->orderBy('id', 'DESC')
        ->get();

    $total = $review->count();
    $rating = array_sum(array_column($review->toArray(), 'rating'));

    $average_rating = 0;
    if ($total != 0) {
        $average_rating = $rating / $total;
    }
@endphp

<div class="col-lg-4 col-md-6 col-sm-6 mb-30">
    <div class="card Ecard eBar-card bootcamp-grid-card">
        <a href="{{ route('bootcamp.details', $bootcamp->slug) }}">
            <div class="courses-img">
                <img src="{{ get_image($bootcamp->thumbnail) }}" alt="course-thumbnail">
                <div class="cText d-flex">
                    <h4>
                        @if ($bootcamp->is_paid == 0)
                            {{ get_phrase('Free') }}
                        @else
                            @if ($bootcamp->discount_flag == 1)
                                @php $discounted_price = number_format(($bootcamp->price - $bootcamp->discounted_price), 2) @endphp
                                {{ currency($discounted_price) }}
                                <del>{{ currency(number_format($bootcamp->price, 2)) }}</del>
                            @else
                                {{ currency(number_format($bootcamp->price, 2)) }}
                            @endif
                        @endif
                    </h4>
                </div>
            </div>
        </a>
        <div class="card-body entry-details mt-0 pb-0">
            <div class="info-card mb-15">
                <a href="{{ route('instructor.details', [slugify($bootcamp->instructor_name), $bootcamp->user_id]) }}"
                    class="creator text-color">
                    <img src="{{ get_image($bootcamp->instructor_image) }}" alt="author-image">
                    <h5>{{ $bootcamp->instructor_name }}</h5>
                </a>
            </div>
            <div class="entry-title">
                <h3 class="w-100 ellipsis-2">
                    <a href="{{ route('bootcamp.details', $bootcamp->slug) }}" class="color-2" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="{{ $bootcamp->title }}">{{ ucfirst($bootcamp->title) }}</a>
                </h3>
            </div>
            <ul class="info">
                <li>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="m-0">
                        <path
                            d="M18.3307 10.0003C18.3307 14.6003 14.5974 18.3337 9.9974 18.3337C5.3974 18.3337 1.66406 14.6003 1.66406 10.0003C1.66406 5.40033 5.3974 1.66699 9.9974 1.66699C14.5974 1.66699 18.3307 5.40033 18.3307 10.0003Z"
                            stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M13.0875 12.65L10.5042 11.1083C10.0542 10.8416 9.6875 10.2 9.6875 9.67497V6.2583"
                            stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ date('d-M-Y', $bootcamp->publish_date) }}
                </li>
                <li>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="m-0">
                        <path
                            d="M1.67188 7.5V6.66667C1.67188 4.16667 3.33854 2.5 5.83854 2.5H14.1719C16.6719 2.5 18.3385 4.16667 18.3385 6.66667V13.3333C18.3385 15.8333 16.6719 17.5 14.1719 17.5H13.3385"
                            stroke="#6B7385" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.07812 9.7583C6.92813 10.25 9.75313 13.0833 10.2531 16.9333" stroke="#6B7385"
                            stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2.1875 12.5586C5.0125 12.9169 7.08751 15.0003 7.45417 17.8253" stroke="#6B7385"
                            stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1.65234 15.7168C3.06068 15.9001 4.10235 16.9335 4.28568 18.3501" stroke="#6B7385"
                            stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ count_bootcamp_classes($bootcamp->id) }}
                    {{ get_phrase('Class') }}
                </li>
            </ul>
            <div class="btns">
                <a href="{{ route('bootcamp.details', $bootcamp->slug) }}"
                    class="eBtn gradient">{{ get_phrase('View Details') }}</a>
                @php
                    $btn['url'] = route('purchase.bootcamp', $bootcamp->id);
                    $btn['title'] = get_phrase('Buy Now');
                    if (isset(auth()->user()->id)) {
                        $my_bootcamp = App\Models\BootcampPurchase::where('user_id', auth()->user()->id)
                            ->where('bootcamp_id', $bootcamp->id)
                            ->where('status', 1)
                            ->first();

                        if ($my_bootcamp) {
                            $btn['title'] = get_phrase('In Collection');
                            $btn['url'] = route('my.bootcamp.details', $bootcamp->slug);
                        }

                        $pending_payment = DB::table('offline_payments')
                            ->where('user_id', auth()->user()->id)
                            ->where('item_type', 'bootcamp')
                            ->where('items', $bootcamp->id)
                            ->where('status', 0)
                            ->first();

                        if ($pending_payment) {
                            $btn['title'] = get_phrase('Processing');
                            $btn['url'] = 'javascript:void(0);';
                        }
                    }
                @endphp
                <a href="{{ $btn['url'] }}"
                    class="eBtn gradient @isset($my_bootcamp) bootcamp-purchased @elseif(isset($pending_payment)) bootcamp-purchased @endisset">{{ $btn['title'] }}</a>
            </div>
        </div>
    </div>
</div>
