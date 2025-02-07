@extends('layouts.admin')
@push('title', get_phrase('Team Package Edit'))

@section('content')
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="ol-card radius-8px">
                <div class="ol-card-body my-3 py-4 px-20px">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                        <h4 class="title fs-16px">
                            <i class="fi-rr-settings-sliders me-2"></i>
                            {{ get_phrase('Edit Team Package') }}
                        </h4>
                    </div>
                </div>
            </div>



            <div class="ol-card p-3">
                <div class="ol-card-body">
                    <form action="{{ route('admin.team.packages.update', $package->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 pb-2">
                                <div class="mb-3">
                                    <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" name="title" class="form-control ol-form-control"
                                        placeholder="{{ get_phrase('Enter package title') }}" value="{{ $package->title }}"
                                        required>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-4">
                                        <div class="mb-3">
                                            <label for="course_privacy"
                                                class="form-label ol-form-label">{{ get_phrase('Course') }}<span
                                                    class="text-danger ms-1">*</span></label>
                                            <select class="ol-select2" name="course_privacy" id="course_privacy" required>
                                                <option value="">{{ get_phrase('Select course privacy') }}</option>
                                                <option value="public" @if ($package->course_privacy == 'public') selected @endif>
                                                    {{ get_phrase('Public') }}</option>
                                                <option value="private" @if ($package->course_privacy == 'private') selected @endif>
                                                    {{ get_phrase('Private') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xxl-8 d-flex align-items-end">
                                        <div class="w-100 mb-3 load_courses">
                                            <select class="ol-select2" name="course_id" id="course_id" required>
                                                <option value="">{{ get_phrase('Select a course') }}</option>

                                                @php $privacy = $package->course_privacy == 'public' ? 'active' : 'private'; @endphp
                                                @foreach (App\Models\Course::where('status', $privacy)->get() as $course)
                                                    <option value="{{ $course->id }}"
                                                        @if ($package->course_id == $course->id) selected @endif>
                                                        {{ $course->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label ol-form-label"
                                                for="allocation">{{ get_phrase('Allocation') }}<span
                                                    class="text-danger ms-1">*</span></label>
                                            <input type="number" class="form-control ol-form-control" name="allocation"
                                                value="{{ $package->allocation }}"
                                                placeholder="{{ get_phrase('Enter package allocation') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label ol-form-label"
                                                for="price">{{ get_phrase('Estimated Price') }}</label>
                                            <input type="number" class="form-control ol-form-control" id="estimated_price"
                                                placeholder="{{ currency() }}"
                                                value="{{ $package->allocation * $package->course_price }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="eForm-layouts">
                                    <div class="mb-3">
                                        <label
                                            class="form-label ol-form-label col-sm-2 w-100">{{ get_phrase('Pricing type') }}<span
                                                class="text-danger ms-1">*</span></label>

                                        <div class="eRadios">
                                            <div class="d-flex gap-3 mb-2">
                                                <div class="form-check">
                                                    <input type="radio" name="pricing_type" value="1"
                                                        class="form-check-input eRadioSuccess" id="paid"
                                                        onchange="$('#paid-section').slideDown(200)" checked>
                                                    <label for="paid"
                                                        class="form-check-label">{{ get_phrase('Paid') }}</label>
                                                </div>

                                                <div class="form-check">
                                                    <input type="radio" name="pricing_type" value="0"
                                                        class="form-check-input eRadioSuccess" id="free"
                                                        onchange="$('#paid-section').slideUp(200)">
                                                    <label for="free"
                                                        class="form-check-label">{{ get_phrase('Free') }}</label>
                                                </div>
                                            </div>
                                            <div class="paid-section" id="paid-section">
                                                <div class="mb-3">
                                                    <label for="price"
                                                        class="form-label ol-form-label">{{ get_phrase('Price') }}
                                                        <small>({{ currency() }})</small><span
                                                            class="text-danger ms-1">*</span></label>

                                                    <input type="number" name="price"
                                                        class="form-control ol-form-control" id="price" min="1"
                                                        step=".01" value="{{ $package->price }}"
                                                        placeholder="{{ get_phrase('Enter your course price') }} ({{ currency() }})">

                                                    <small class="text-danger">{{ get_phrase('Package discount rate') }}
                                                        <span id="show-discount">0%</span>
                                                    </small>
                                                </div>


                                                <div class="mb-3">
                                                    <label
                                                        class="form-label ol-form-label col-sm-2 w-100">{{ get_phrase('Package Expiry') }}<span
                                                            class="text-danger ms-1">*</span></label>
                                                    <div class="d-flex gap-3">
                                                        <div class="form-check">
                                                            <input type="radio" name="expiry_type" value="limited"
                                                                class="form-check-input eRadioSuccess" id="limited"
                                                                onchange="$('#package-expiry-section').slideDown(200)"
                                                                checked>
                                                            <label for="limited"
                                                                class="form-check-label">{{ get_phrase('Limited') }}</label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input type="radio" name="expiry_type" value="lifetime"
                                                                class="form-check-input eRadioSuccess" id="lifetime"
                                                                onchange="$('#package-expiry-section').slideUp(200)">
                                                            <label for="lifetime"
                                                                class="form-check-label">{{ get_phrase('Lifetime') }}</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="package-expiry-section">
                                                    <div class="mb-3">
                                                        <label for="expiry-date"
                                                            class="form-label ol-form-label">{{ get_phrase('Expiry Date') }}</label>

                                                        <div class="mb-3 position-relative position-relative">
                                                            <input type="text" id="expiry-date" name="expiry_date"
                                                                class="form-control ol-form-control daterangepicker w-100"
                                                                value="{{ date('m/d/Y', $package->start_date) . ' - ' . date('m/d/Y', $package->expiry_date) }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="thumbnail"
                                        class="form-label ol-form-label">{{ get_phrase('Thumbnail') }}</label>
                                    <input type="file" name="thumbnail" class="form-control ol-form-control"
                                        id="thumbnail" accept="image/*" />
                                </div>

                                <div class="row">
                                    <label class="col-md-2 form-label ol-form-label"
                                        for="features">{{ get_phrase('Features') }}</label>
                                    <div id="feature_area">
                                        <div class="d-flex gap-3 mb-3">
                                            <div class="flex-grow-1">
                                                <div class="form-group">
                                                    <input type="text" class="form-control ol-form-control"
                                                        name="features[]" id="features"
                                                        placeholder="{{ get_phrase('Provide package features') }}">
                                                </div>
                                            </div>
                                            <div class="">
                                                <button type="button" class="btn ol-btn-light ol-icon-btn"
                                                    name="button" data-bs-toggle="tooltip"
                                                    title="{{ get_phrase('Add new') }}" onclick="appendFeature()"> <i
                                                        class="fi-rr-plus-small"></i>
                                                </button>
                                            </div>
                                        </div>

                                        @php
                                            $features = $package->features ? json_decode($package->features, true) : [];
                                        @endphp

                                        @foreach ($features as $feature)
                                            <div class="d-flex gap-3 mb-3">
                                                <div class="flex-grow-1">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control ol-form-control"
                                                            name="features[]" id="features" value="{{ $feature }}"
                                                            placeholder="{{ get_phrase('Provide package features') }}">
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button type="button" class="btn ol-btn-light ol-icon-btn mt-0"
                                                        name="button" data-bs-toggle="tooltip"
                                                        title="{{ get_phrase('Remove') }}" onclick="removeFeature(this)">
                                                        <i class="fi-rr-minus-small"></i> </button>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div id = "blank_feature_field">
                                            <div class="d-flex gap-3 mb-3">
                                                <div class="flex-grow-1">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control ol-form-control"
                                                            name="features[]" id="features"
                                                            placeholder="{{ get_phrase('Provide package features') }}">
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button type="button" class="btn ol-btn-light ol-icon-btn mt-0"
                                                        name="button" data-bs-toggle="tooltip"
                                                        title="{{ get_phrase('Remove') }}" onclick="removeFeature(this)">
                                                        <i class="fi-rr-minus-small"></i> </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2">
                                <button type="submit"
                                    class="btn ol-btn-primary float-end">{{ get_phrase('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script type="text/javascript">
        "Use strict";
        var blank_feature_field = jQuery('#blank_feature_field').html();
        jQuery(document).ready(function() {
            jQuery('#blank_feature_field').hide();
        });

        function appendFeature() {
            jQuery('#feature_area').append(blank_feature_field);
        }

        function removeFeature(requirementElem) {
            jQuery(requirementElem).parent().parent().remove();
        }
    </script>

    <script>
        $(document).ready(function() {
            // Function to calculate and display the discount rate
            function calculateDiscount(estimatedPrice, finalPrice) {
                const discountRate = 100 - ((100 / estimatedPrice.val()) * finalPrice.val());
                $(finalPrice).parent().find('#show-discount').text(discountRate.toFixed(2) + '%');
            }

            // Initialize price elements
            const packagePrice = $('input#price');
            const estimatedPrice = $('input#estimated_price');

            // Calculate initial discount rate
            calculateDiscount(estimatedPrice, packagePrice);

            // Update discount rate on price input change
            $('input[name="price"]').on('keyup', function() {
                calculateDiscount(estimatedPrice, $(this));
            });

            // Function to load courses based on privacy
            function loadCourses(privacy) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.get.courses.by.privacy') }}",
                    data: {
                        privacy: privacy
                    },
                    success: function(response) {
                        if (response) {
                            $('.load_courses').empty().append(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Load courses on privacy selection change
            $('select[name="course_privacy"]').on('change', function() {
                loadCourses($(this).val());
            });

            // Function to update the estimated price
            function updateEstimatedPrice(courseId, students) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.get.course.price') }}",
                    data: {
                        course_id: courseId
                    },
                    success: function(response) {
                        const estimatedPrice = response * students;
                        $('input#estimated_price').val(estimatedPrice);
                    }
                });
            }

            // Update estimated price on student allocation input change
            $('input[name="allocation"]').on('keyup', function() {
                const students = $(this).val();
                const courseId = $('select[name="course_id"]').val();
                updateEstimatedPrice(courseId, students);
            });

            // Update estimated price on course selection change
            $(document).on('change', 'select[name="course_id"]', function() {
                updateEstimatedPrice($(this).val(), $('input[name="allocation"]').val());
            });

            // Slide up the price section if price is free
            const priceType = "{{ $package->pricing_type }}";
            if (!priceType) {
                $('#paid-section').slideUp();
            }

            // Slide up the price section if price is free
            const expiryType = "{{ $package->expiry_type }}";
            if (expiryType == 'lifetime') {
                $('#package-expiry-section').slideUp();
            }
        });
    </script>
@endpush
