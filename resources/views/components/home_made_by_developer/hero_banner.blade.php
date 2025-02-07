{{-- To make a editable image or text need to be add a "builder editable" class and builder identity attribute with a unique value --}}
{{-- builder identity and builder editable --}}
{{-- builder identity value have to be unique under a single file --}}

<section class="banner-wraper mt-0 mt-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 order-2 order-md-1">
                <div class="banner-content">
                    <h5 class="d-flex"><img class="builder-editable" builder-identity="1" src="{{asset('assets/page-builder/block-image/roket.svg')}}" alt="..."> <span class="builder-editable" builder-identity="2">{{ get_phrase('The Leader in online learning')}}</span></h5>
                    <h1>
                        <span class="builder-editable" builder-identity="3">{{ get_phrase("Start learning from the world's pro")}}</span>
                        <span class="gradient color shadow-none builder-editable" builder-identity="4">{{ get_phrase('instructors')}}</span>
                    </h1>
                    <p class="builder-editable" builder-identity="5">{{ get_phrase('We invites learners to explore courses designed by industry experts, offering cutting-edge content for skill development.')}}</p>
                    <div class="banner-btn">
                        <a href="{{ route('courses') }}" class="eBtn gradient builder-editable" builder-identity="6">{{ get_phrase('Get Started') }}</a>
                        <a data-bs-toggle="modal" data-bs-target="#promoVideo" href="#" class="eBtn learn-btn"><i class="fa-solid fa-play"></i>{{ get_phrase('Learn More') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 col-md-6 order-1 order-md-2">
                <div class="banner-image mt-0 mt-md-5">
                    <img class="large-img" src="{{ asset(get_frontend_settings('banner_image')) }}" alt="banner-image">
                    <div class="over-text">
                        <span>
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_47_63)">
                                    <mask id="mask0_47_63" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="30" height="30">
                                        <path d="M0 1.90735e-06H30V30H0V1.90735e-06Z" fill="white" />
                                    </mask>
                                    <g mask="url(#mask0_47_63)">
                                        <path d="M7.36816 27.2279V29.5615" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M22.6289 27.2279V29.5615" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <path d="M5.94995 4.26311V7.34473" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <mask id="mask1_47_63" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="30" height="30">
                                        <path d="M0 1.90735e-06H30V30H0V1.90735e-06Z" fill="white" />
                                    </mask>
                                    <g mask="url(#mask1_47_63)">
                                        <path d="M3.56714 27.2547V28.1348C3.56714 28.9227 4.20587 29.5615 4.9939 29.5615H25.0054C25.7933 29.5615 26.4321 28.9227 26.4321 28.1348V23.8904C26.4321 22.1012 25.2529 20.5261 23.5362 20.0221L21.7134 19.487L14.9996 23.4764L8.28622 19.4872L6.46331 20.0222C4.74646 20.5261 3.56714 22.1013 3.56714 23.8906V25.2003" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M21.7133 19.4871L17.6291 16.8194C17.6291 18.5262 17.1336 20.1963 16.2029 21.6269L14.9995 23.4766" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8.28589 19.4871L12.3702 16.8194C12.3702 18.5262 12.8656 20.1963 13.7963 21.6269L14.9997 23.4766" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.2968 7.40565V8.73256C11.2968 9.26494 10.8652 9.6966 10.3328 9.6966H9.37549V11.273C9.37549 11.6758 9.70203 12.0024 10.1049 12.0024C10.232 12.0024 10.3354 12.1019 10.3434 12.2288C10.4972 14.6673 12.5224 16.5977 14.9996 16.5977C17.4769 16.5977 19.5021 14.6673 19.6559 12.2288C19.664 12.1019 19.7673 12.0024 19.8944 12.0024C20.2972 12.0024 20.6238 11.6758 20.6238 11.273V9.6966H19.6665C19.1341 9.6966 18.7025 9.26494 18.7025 8.73256V7.40565" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12.3682 15.7837V16.8203L12.3701 16.8191" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M17.6292 16.8193V15.7851" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M17.7716 4.37924L16.0506 4.16631C15.352 4.07994 14.6455 4.07994 13.947 4.16637L10.0603 4.6473L9.01416 4.77674V6.975C9.01416 7.18898 9.1702 7.36611 9.37457 7.39998C9.39771 7.40379 9.42121 7.40625 9.44541 7.40625H20.5539C20.5775 7.40625 20.6004 7.40385 20.6229 7.40027C20.8282 7.36711 20.9853 7.18963 20.9853 6.975V4.77674L19.9371 4.64707L19.8139 4.63189" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M20.6228 9.69629V7.39936" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9.37451 7.39906L9.37545 9.69629" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M20.984 4.77625L23.9943 4.26355C24.5087 4.17596 24.5588 3.45666 24.0616 3.29857L15.1495 0.463867C15.0513 0.432637 14.9459 0.432637 14.8477 0.463867L5.93555 3.29857C5.43838 3.45666 5.48854 4.17596 6.00288 4.26355L9.01401 4.77637" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.01803 9.03922L4.4243 12.5241C4.36823 12.8531 4.62165 13.1533 4.9554 13.1533H6.9446C7.27823 13.1533 7.53165 12.8531 7.47563 12.5241L6.88196 9.03922" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M6.88199 7.81557C6.88199 7.55559 6.67123 7.34482 6.41125 7.34482H5.48881C5.22883 7.34482 5.01807 7.55559 5.01807 7.81557V9.03906H6.88199V7.81557Z" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M17.2406 19.4043C16.5501 19.5564 15.7935 19.6406 14.9996 19.6406C14.2056 19.6406 13.449 19.5564 12.7585 19.4043" stroke="white" stroke-width="0.878906" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                </g>
                                <defs>
                                    <clipPath id="clip0_47_63">
                                        <rect width="30" height="30" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <div class="b-text">
                            <h5>{{ total_enrolled() }}+</h5>
                            <p>{{ get_phrase('Students has Enrolled') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Vertically centered modal -->
<div class="modal fade-in-effect" id="promoVideo" tabindex="-1" aria-labelledby="promoVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body bg-dark">
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var xhr = new XMLHttpRequest();
        var url = "{{ route('view', ['path' => 'components.home_ajax_loaded_templates.promo_video']) }}";

        xhr.open("GET", url, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                $('#promoVideo .modal-body').html(xhr.responseText);
            }
        };

        xhr.send();
    })();

    function scrollToSmoothly(pos, time) {
        if (isNaN(pos)) {
            throw "Position must be a number";
        }
        if (pos < 0) {
            throw "Position can not be negative";
        }
        var currentPos = window.scrollY || window.screenTop;
        if (currentPos < pos) {
            var t = 10;
            for (let i = currentPos; i <= pos; i += 10) {
                t += 10;
                setTimeout(function() {
                    window.scrollTo(0, i);
                }, t / 2);
            }
        } else {
            time = time || 2;
            var i = currentPos;
            var x;
            x = setInterval(function() {
                window.scrollTo(0, i);
                i -= 10;
                if (i <= pos) {
                    clearInterval(x);
                }
            }, time);
        }
    }
</script>