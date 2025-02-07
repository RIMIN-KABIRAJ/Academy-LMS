@extends('layouts.instructor')
@push('title', get_phrase('Create course'))

@section('content')
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="ol-card radius-8px">
                <div class="ol-card-body my-3 py-4 px-20px">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                        <h4 class="title fs-16px">
                            <i class="fi-rr-settings-sliders me-2"></i>
                            {{ get_phrase('Add new Course') }}
                        </h4>
                    </div>
                </div>
            </div>
            <div class="ol-card p-3">
                <div class="ol-card-body">
                    <form class="ajaxForm" action="{{ route('instructor.course.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_type" value="general" required>
                        <input type="hidden" name="instructors[]" value="{{ auth()->user()->id }}" required>
                        <div class="row">
                            <div class="col-md-6 pb-2">
                                <div class="eForm-layouts">
                                    <div class="fpb-7 mb-3">
                                        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}<span class="text-danger ms-1">*</span></label>
                                        <input type="text" name = "title" class="form-control ol-form-control" placeholder="{{ get_phrase('Enter Course Title') }}" required>
                                    </div>
                                    <div class="fpb-7 mb-3">
                                        <label class="form-label ol-form-label" for="short_description">{{ get_phrase('Short Description') }}</label>
                                        <textarea name="short_description" placeholder="{{ get_phrase('Enter Short Description') }}" class="form-control ol-form-control" rows="5"></textarea>
                                    </div>
                                    <div class="fpb-7 mb-3">
                                        <label class="form-label ol-form-label" for="description">{{ get_phrase('Description') }}</label>
                                        <textarea name="description" placeholder="{{ get_phrase('Enter Description') }}" class="form-control ol-form-control text_editor"></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="eForm-layouts">
                                    <div class="fpb-7 mb-3">
                                        <label for="category_id" class="form-label ol-form-label">{{ get_phrase('Category') }}<span class="text-danger ms-1">*</span></label>
                                        <select class="ol-select2" name="category_id" id="category_id" required>
                                            <option value="">{{ get_phrase('Select a category') }}</option>
                                            @foreach (App\Models\Category::where('parent_id', 0)->orderBy('title', 'desc')->get() as $category)
                                                <option value="{{ $category->id }}"> {{ $category->title }}</option>

                                                @foreach ($category->childs as $sub_category)
                                                    <option value="{{ $sub_category->id }}"> --
                                                        {{ $sub_category->title }}
                                                    </option>
                                                @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="fpb-7 mb-3">
                                        <label for="level" class="form-label ol-form-label">{{ get_phrase('Course level') }}<span class="text-danger ms-1">*</span></label>
                                        <select class="ol-select2" name="level" id="level" required>
                                            <option value="">{{ get_phrase('Select your course level') }}</option>
                                            <option value="beginner">{{ get_phrase('Beginner') }}</option>
                                            <option value="intermediate">{{ get_phrase('Intermediate') }}</option>
                                            <option value="advanced">{{ get_phrase('Advanced') }}</option>
                                        </select>
                                    </div>
                                    <div class="fpb-7 mb-3">
                                        <label for="language" class="form-label ol-form-label">{{ get_phrase('Made in') }}
                                            <span class="text-danger ms-1">*</span></label>
                                        <select class="ol-select2" name="language" id="language" required>
                                            <option value="">{{ get_phrase('Select your course language') }}
                                            </option>
                                            @foreach (App\Models\Language::get() as $language)
                                                <option value="{{ strtolower($language->name) }}" class="text-capitalize">{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="fpb-7 mb-3">
                                        <label class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Pricing type') }}<span class="text-danger ms-1">*</span></label>

                                        <div class="eRadios">
                                            <div class="form-check">
                                                <input type="radio" name="is_paid" value="1" class="form-check-input eRadioSuccess" id="paid" onchange="$('#paid-section').slideDown(200)" checked>
                                                <label for="paid" class="form-check-label">{{ get_phrase('Paid') }}</label>
                                            </div>

                                            <div class="form-check">
                                                <input type="radio" name="is_paid" value="0" class="form-check-input eRadioSuccess" id="free" onchange="$('#paid-section').slideUp(200)">
                                                <label for="free" class="form-check-label">{{ get_phrase('Free') }}</label>
                                            </div>
                                            <div class="paid-section" id="paid-section">
                                                <div class="fpb-7 mb-3">
                                                    <label for="price" class="form-label ol-form-label">{{ get_phrase('Price') }}
                                                        <small>({{ currency() }})</small><span class="text-danger ms-1">*</span></label>

                                                    <input type="number" name="price" class="form-control ol-form-control" id="price" min="1" step=".01" placeholder="{{ get_phrase('Enter your course price') }} ({{ currency() }})">
                                                </div>

                                                <div class="fpb-7 mb-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="discount_flag" value="1" class="form-check-input eRadioSuccess" id="discount_flag">
                                                        <label for="discount_flag" class="form-check-label">{{ get_phrase('Check if this course has discount') }}</label>
                                                    </div>
                                                </div>

                                                <div class="fpb-7 mb-3">
                                                    <label for="discounted_price" class="form-label ol-form-label">{{ get_phrase('Discounted price') }}</label>

                                                    <input type="number" name="discounted_price" class="form-control ol-form-control" id="discounted_price" min="1" step=".01" placeholder="{{ get_phrase('Enter your discount price') }} ({{ currency() }})">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="fpb-7">
                                    <label for="thumbnail" class="form-label ol-form-label">{{ get_phrase('Thumbnail') }}</label>
                                    <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
                                </div>
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="btn ol-btn-primary float-end">{{ get_phrase('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";

        //Start progress
        var totalSteps = $('#v-pills-tab .nav-link').length
        var progressVal = 100 / totalSteps;
        $(function() {
            var pValPerItem = progressVal;
            $('#courseFormProgress .progress-bar').attr('aria-valuemin', 0);
            $('#courseFormProgress .progress-bar').attr('aria-valuemax', pValPerItem);
            $('#courseFormProgress .progress-bar').attr('aria-valuenow', pValPerItem);
            $('#courseFormProgress .progress-bar').width(pValPerItem + '%');
            $('#courseFormProgress .progress-bar').text("Step 1 out of " + totalSteps);
        });

        $("#v-pills-tab .nav-link").on('click', function() {
            var currentStep = $("#v-pills-tab .nav-link").index(this) + 1;
            var pValPerItem = currentStep * progressVal;
            $('#courseFormProgress .progress-bar').attr('aria-valuemin', 0);
            $('#courseFormProgress .progress-bar').attr('aria-valuemax', pValPerItem);
            $('#courseFormProgress .progress-bar').attr('aria-valuenow', pValPerItem);
            $('#courseFormProgress .progress-bar').width(pValPerItem + '%');
            $('#courseFormProgress .progress-bar').text("Step " + currentStep + " out of " + totalSteps);

            if (currentStep == totalSteps) {
                $('#courseFormProgress .progress-bar').text("{{ get_phrase('Finish!') }}");
                $('#courseFormProgress .progress-bar').addClass('bg-success');
            } else {
                $('#courseFormProgress .progress-bar').removeClass('bg-success');
            }
        });
        //End progress
    </script>
@endpush
