{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<!-----------------  Sub Header Start ------------------->
<div class="sub-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="sub-header-left">
                    <ul class="d-flex">
                        <li>
                            <a href="tel:{{ get_settings('phone') }}">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.3018 15.2734C18.3018 15.5734 18.2352 15.8817 18.0935 16.1817C17.9518 16.4817 17.7685 16.765 17.5268 17.0317C17.1185 17.4817 16.6685 17.8067 16.1602 18.015C15.6602 18.2234 15.1185 18.3317 14.5352 18.3317C13.6852 18.3317 12.7768 18.1317 11.8185 17.7234C10.8602 17.315 9.90182 16.765 8.95182 16.0734C7.99349 15.3734 7.08516 14.5984 6.21849 13.74C5.36016 12.8734 4.58516 11.965 3.89349 11.015C3.21016 10.065 2.66016 9.11504 2.26016 8.17337C1.86016 7.22337 1.66016 6.31504 1.66016 5.44837C1.66016 4.88171 1.76016 4.34004 1.96016 3.84004C2.16016 3.33171 2.47682 2.86504 2.91849 2.44837C3.45182 1.92337 4.03516 1.66504 4.65182 1.66504C4.88516 1.66504 5.11849 1.71504 5.32682 1.81504C5.54349 1.91504 5.73516 2.06504 5.88516 2.28171L7.81849 5.00671C7.96849 5.21504 8.07682 5.40671 8.15182 5.59004C8.22682 5.76504 8.26849 5.94004 8.26849 6.09837C8.26849 6.29837 8.21016 6.49837 8.09349 6.69004C7.98516 6.8817 7.82682 7.0817 7.62682 7.2817L6.99349 7.94004C6.90182 8.0317 6.86016 8.14004 6.86016 8.27337C6.86016 8.34004 6.86849 8.39837 6.88516 8.46504C6.91016 8.5317 6.93516 8.5817 6.95182 8.6317C7.10182 8.9067 7.36016 9.26504 7.72682 9.69837C8.10182 10.1317 8.50182 10.5734 8.93516 11.015C9.38516 11.4567 9.81849 11.865 10.2602 12.24C10.6935 12.6067 11.0518 12.8567 11.3352 13.0067C11.3768 13.0234 11.4268 13.0484 11.4852 13.0734C11.5518 13.0984 11.6185 13.1067 11.6935 13.1067C11.8352 13.1067 11.9435 13.0567 12.0352 12.965L12.6685 12.34C12.8768 12.1317 13.0768 11.9734 13.2685 11.8734C13.4602 11.7567 13.6518 11.6984 13.8602 11.6984C14.0185 11.6984 14.1852 11.7317 14.3685 11.8067C14.5518 11.8817 14.7435 11.99 14.9518 12.1317L17.7102 14.09C17.9268 14.24 18.0768 14.415 18.1685 14.6234C18.2518 14.8317 18.3018 15.04 18.3018 15.2734Z"
                                        stroke="#192335" stroke-width="1.25" stroke-miterlimit="10" />
                                </svg>
                                {{ get_settings('phone') }}
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.99453 11.1912C11.4305 11.1912 12.5945 10.0272 12.5945 8.59121C12.5945 7.15527 11.4305 5.99121 9.99453 5.99121C8.55859 5.99121 7.39453 7.15527 7.39453 8.59121C7.39453 10.0272 8.55859 11.1912 9.99453 11.1912Z" stroke="#192335" stroke-width="1.25" />
                                    <path d="M3.0187 7.0763C4.66037 -0.140363 15.352 -0.132029 16.9854 7.08464C17.9437 11.318 15.3104 14.9013 13.002 17.118C11.327 18.7346 8.67704 18.7346 6.9937 17.118C4.6937 14.9013 2.06037 11.3096 3.0187 7.0763Z" stroke="#192335" stroke-width="1.25" />
                                </svg>
                                {{ get_settings('address') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="sub-header-left right-sub">


                    <ul class="d-flex">
                        <li class="primary-end">
                            <form action="{{ route('select.lng') }}" method="get">
                                <select name="language" id="lng-selector" class="form-select nice-control">
                                    @php
                                        $activated_language = strtolower(session('language') ?? get_settings('language'));
                                    @endphp
                                    @foreach (App\Models\Language::all() as $lng)
                                        <option value="{{ $lng->name }}" @selected(strtolower($lng->name) == $activated_language)>{{ $lng->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </li>
                        @if (get_frontend_settings('twitter') != '')
                            <li>
                                <a href="{{ get_frontend_settings('twitter') }}">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if (get_frontend_settings('linkedin') != '')
                            <li>
                                <a href="{{ get_frontend_settings('linkedin') }}">
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                            </li>
                        @endif
                        @if (get_frontend_settings('facebook') != '')
                            <li>
                                <a href="{{ get_frontend_settings('facebook') }}">
                                    <i class="fa-brands fa-square-facebook"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-----------------  Sub Header End  ------------------->
