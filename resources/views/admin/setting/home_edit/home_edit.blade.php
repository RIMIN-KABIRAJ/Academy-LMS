@php
    $home_page_identifire = App\Models\Builder_page::where('id', $id)->first()->identifier;
@endphp
<form action="{{ route('admin.update.home', ['id' => $id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="{{ $home_page_identifire }}">
    @if ($home_page_identifire == 'cooking')
        <h5 class="title mt-4 mb-3">{{ get_phrase('Become An Instructor') }}</h5>
        <div class="row">
            <div class="col-md-12">
                @php
                    $instructor_speech = json_decode(get_homepage_settings('cooking'));
                @endphp
                <div id="motivational_speech_area">
                    <div id="blank_motivational_speech_field">
                        <div class="d-flex mt-2 border-top pt-2">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="title" value="{{ $instructor_speech->title ?? '' }}" placeholder="Enter a title" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="description" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}" required>{{ $instructor_speech->description ?? '' }}</textarea>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Video Url') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="video_url" value="{{ $instructor_speech->video_url ?? '' }}" placeholder="enter a video url" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                    <div class="custom-file">
                                        <input name="previous_image" type="hidden" value="{{ $instructor_speech->image ?? '' }}">
                                        <input type="file" class="form-control ol-form-control" name="image" value="{{ $instructor_speech->image ?? '' }}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fpb-7 mb-2 flex-grow-1 px-2">
                    <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
                </div>
            </div>
        </div>
    @elseif($home_page_identifire == 'university')
        <div class="row">
            <div class="col-md-12">
                @php
                    $university = json_decode(get_homepage_settings('university'));
                @endphp
                <h5 class="title mt-4 mb-3">{{ get_phrase('About Us Image') }}</h5>
                <div id="motivational_speech_area">
                    <div id="blank_motivational_speech_field">
                        <div class="d-flex mt-2 border-top pt-2">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                    <div class="custom-file">
                                        <input name="previous_image" type="hidden" value="{{ $university->image ?? '' }}">
                                        <input type="file" class="form-control ol-form-control" name="image" value="{{ $university->image ?? '' }}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="title mt-4 mb-3">{{ get_phrase('Faq  Image') }}</h5>
                <div id="motivational_speech_area">
                    <div id="blank_motivational_speech_field">
                        <div class="d-flex mt-2 border-top pt-2">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Faq Image') }}</label>
                                    <div class="custom-file">
                                        <input name="previous_faq_image" type="hidden" value="{{ $university->faq_image ?? '' }}">
                                        <input type="file" class="form-control ol-form-control" name="faq_image" value="{{ $university->faq_image ?? '' }}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="title mt-4 mb-3">{{ get_phrase('Slider image & video link') }}</h5>
                <div class="row">
                    <div class="col-6">
                        <button type="button" onclick="addSliderImageField()" class="btn ol-btn-primary"><i class="fi-rr-plus-small"></i> {{ get_phrase('Add Image') }}</button>
                    </div>
                    <div class="col-6">
                        <button type="button" onclick="addSliderVideoField()" class="btn ol-btn-primary"><i class="fi-rr-plus-small"></i> {{ get_phrase('Add Video Link') }}</button>
                    </div>
                </div>

                <div id="slider_area">
                    @php
                        $university = json_decode(get_homepage_settings('university'));
                        $slider_items = json_decode($university->slider_items ?? '{}', true) ?? [];
                    @endphp
                    @foreach ($slider_items as $key => $slider_item)
                        @if (file_exists(public_path($slider_item)))
                            <div class="d-flex mt-2 border-top pt-2 align-items-center">
                                <img width="50px" src="{{ asset($slider_item) }}" alt="">
                                <div class="flex-grow-1 px-2 mb-3">
                                    <div class="fpb-7 mb-3">
                                        <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                        <div class="custom-file">
                                            <input type="hidden" value="{{$slider_item}}" class="form-control ol-form-control" name="previous_slider_items[]" >
                                            <input type="hidden" value="{{$slider_item}}" class="form-control ol-form-control" name="slider_items[]">
                                            <input type="file" class="form-control ol-form-control" name="slider_items[]" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-danger" onclick="$(this).parent().remove();"><i class="fi-rr-minus-small"></i></button>
                            </div>
                        @else
                            <div class="d-flex mt-2 border-top pt-2 align-items-center">
                                <div class="flex-grow-1 px-2 mb-3">
                                    <div class="fpb-7 mb-3">
                                        <label class="form-label ol-form-label">{{ get_phrase('Video Link') }} <small>({{get_phrase('Youtube')}} & {{get_phrase('HTML5')}})</small></label>
                                        <div class="custom-file">
                                            <input type="hidden" value="{{$slider_item}}" class="form-control ol-form-control" name="previous_slider_items[]" >
                                            <input type="text" value="{{$slider_item}}" class="form-control ol-form-control" name="slider_items[]">
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-danger" onclick="$(this).parent().remove();"><i class="fi-rr-minus-small"></i></button>
                            </div>
                        @endif
                    @endforeach
                </div>

                <hr>

                <div class="fpb-7 mb-2 flex-grow-1 mt-3">
                    <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
                </div>
            </div>
        </div>
    @elseif($home_page_identifire == 'development')
        <div class="row">
            <h5 class="title mt-4 mb-3">{{ get_phrase('About Us') }}</h5>
            <div class="col-md-12">
                @php
                    $development = json_decode(get_homepage_settings('development'));
                @endphp
                <div id="motivational_speech_area">
                    <div id="blank_motivational_speech_field">
                        <div class="d-flex mt-2 border-top pt-2">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="title" value="{{ $development->title ?? '' }}" placeholder="Enter a title" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="description" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}" required>{{ $development->description ?? '' }}</textarea>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                    <div class="custom-file">
                                        <input name="previous_image" type="hidden" value="{{ $development->image ?? '' }}">
                                        <input type="file" class="form-control ol-form-control" name="image" value="{{ $development->image ?? '' }}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fpb-7 mb-2 flex-grow-1 px-2">
                    <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
                </div>
            </div>
        </div>
    @elseif($home_page_identifire == 'kindergarden')
        <div class="row">
            <h5 class="title mt-4 mb-3">{{ get_phrase('About Us') }}</h5>
            <div class="col-md-12">
                @php
                    $kindergarden = json_decode(get_homepage_settings('kindergarden'));
                @endphp
                <div id="motivational_speech_area">
                    <div id="blank_motivational_speech_field">
                        <div class="d-flex mt-2 border-top pt-2">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="title" value="{{ $kindergarden->title ?? '' }}" placeholder="Enter a title" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="description" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}" required>{{ $kindergarden->description ?? '' }}</textarea>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                    <div class="custom-file">
                                        <input name="previous_image" type="hidden" value="{{ $kindergarden->image ?? '' }}">
                                        <input type="file" class="form-control ol-form-control" name="image" value="{{ $kindergarden->image ?? '' }}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fpb-7 mb-2 flex-grow-1 px-2">
                    <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
                </div>
            </div>
        </div>
    @elseif($home_page_identifire == 'marketplace')
        <h5 class="title mt-4 mb-3">{{ get_phrase('Become An Instructor') }}</h5>
        <div class="row">
            <div class="col-md-12">
                @php
                    $settings = get_homepage_settings('marketplace');
                    $marketplace = json_decode($settings);
                    if ($marketplace && isset($marketplace->instructor)) {
                        $instructor = $marketplace->instructor;
                    }
                @endphp
                <div id="motivational_speech_area">
                    <div id="blank_motivational_speech_field">
                        <div class="d-flex mt-2 border-top pt-2">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="title" value="{{ $instructor->title ?? '' }}" placeholder="Enter a title" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="description" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}" required>{{ $instructor->description ?? '' }}</textarea>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Video Url') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="video_url" value="{{ $instructor->video_url ?? '' }}" placeholder="enter a video url" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                    <div class="custom-file">
                                        <input name="previous_image" type="hidden" value="{{ $instructor->image ?? '' }}">
                                        <input type="file" class="form-control ol-form-control" name="image" value="{{ $instructor->image ?? '' }}" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h5 class="title mt-4 mb-3">{{ get_phrase('Banner Information') }}</h5>
            <div class="col-md-12">
                <div id = "motivational_speech_areas">
                    @php
                        $settings = get_homepage_settings('marketplace');
                        if (!$settings) {
                            $settings = '{"slider":[{"banner_title":"","banner_description":""}]}';
                        }
                        $marketplace = json_decode($settings);
                        $sliders = [];
                        $maxKey = 0;
                        if ($marketplace && isset($marketplace->slider)) {
                            $sliders = $marketplace->slider;
                            $maxKey = count($sliders) > 0 ? max(array_keys((array) $sliders)) : 0;
                        }
                    @endphp
                    @foreach ($sliders as $key => $slider)
                        <div class="d-flex mt-2">
                            <input type="hidden" name="slider[]" value="{{ $key }}">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="banner_title{{ $key }}" placeholder="{{ get_phrase('Title') }}" value="{{ $slider?->banner_title }}">
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="banner_description{{ $key }}" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}">{{ $slider?->banner_description }}</textarea>
                                </div>

                            </div>

                            @if ($key == 0)
                                <div class="pt-4">
                                    <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendMotivational_speech()"> <i class="fi-rr-plus-small"></i>
                                    </button>
                                </div>
                            @else
                                <div class="pt-4">
                                    <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeMotivational_speech(this)">
                                        <i class="fi-rr-minus-small"></i> </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <div id = "blank_motivational_speech_fields">
                        <div class="d-flex mt-2 border-top pt-2">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="banner_title" placeholder="{{ get_phrase('Title') }}">
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="banner_description" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}"></textarea>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeMotivational_speech(this)">
                                    <i class="fi-rr-minus-small"></i> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fpb-7 mb-2 flex-grow-1 px-2">
            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
        </div>
        <script type="text/javascript">
            "use strict";

            let blank_motivational_speech = jQuery('#blank_motivational_speech_fields').html();
            let sliderCounter = {{ $maxKey + 1 }};
            $(document).ready(function() {
                jQuery('#blank_motivational_speech_fields').hide();
            });

            function appendMotivational_speech() {
                let newMotivationalSpeech = jQuery('#blank_motivational_speech_fields').clone();
                newMotivationalSpeech.find('input[name="banner_title"]').attr('name', 'banner_title' + sliderCounter);
                newMotivationalSpeech.find('textarea[name="banner_description"]').attr('name', 'banner_description' + sliderCounter);
                jQuery('#motivational_speech_areas').append(newMotivationalSpeech.html());
                let newHiddenInput = '<input type="hidden" name="slider[]" value="' + sliderCounter + '">';
                jQuery('#motivational_speech_areas').append(newHiddenInput);
                sliderCounter++;
            }

            function removeMotivational_speech(faqElem) {
                jQuery(faqElem).parent().parent().remove();
                sliderCounter--;
            }
        </script>
    @elseif($home_page_identifire == 'meditation')
        @php
            $bigImage = json_decode(get_homepage_settings('meditation'));
        @endphp
        <div class="row">
            <h5 class="title mt-4 mb-3">{{ get_phrase('Meditation Big  Image') }}</h5>
            <div id="speech_area">
                <div id="blank_motivational">
                    <div class="d-flex mt-2 border-top pt-2">
                        <div class="flex-grow-1 px-2 mb-3">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Big Image') }}</label>
                                <div class="custom-file">
                                    <input type="hidden" class="form-control ol-form-control" name="big_previous_image" value="{{ $bigImage->big_image ?? '' }}">
                                    <input type="file" class="form-control ol-form-control" name="big_image" value="{{ $bigImage->big_image ?? '' }}" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h5 class="title mt-4 mb-3">{{ get_phrase('Meditation Featured') }}</h5>
            <div class="col-md-12">
                <div id = "area">
                    @php
                        $settings = get_homepage_settings('meditation');
                        if (!$settings) {
                            $settings = '{"meditation":[{"banner_title":"","banner_description":"", "image":""}]}';
                        }
                        $meditation_text = json_decode($settings);
                        $meditations = [];
                        $maxkey = 0;
                        if ($meditation_text && isset($meditation_text->meditation)) {
                            $meditations = $meditation_text->meditation;
                            $maxkey = count($meditations) > 0 ? max(array_keys((array) $meditations)) : 0;
                        }
                    @endphp
                    @foreach ($meditations as $key => $slider)
                        <div class="d-flex mt-2">
                            <input type="hidden" name="meditation[]" value="{{ $key }}">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="banner_title{{ $key }}" placeholder="{{ get_phrase('Title') }}" value="{{ $slider->banner_title }}" required>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="banner_description{{ $key }}" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}" required>{{ $slider->banner_description }}</textarea>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                    <div class="custom-file">
                                        <input type="hidden" name="old_image{{ $key }}" value="{{ $slider->image ?? '' }}">
                                        <input type="file" class="form-control ol-form-control" name="image{{ $key }}" value="{{ $slider->image ?? '' }}" accept="image/*">
                                    </div>
                                </div>

                            </div>

                            @if ($key == 0)
                                <div class="pt-4">
                                    <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="append_speech()"> <i class="fi-rr-plus-small"></i>
                                    </button>
                                </div>
                            @else
                                <div class="pt-4">
                                    <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="remove_speech(this)">
                                        <i class="fi-rr-minus-small"></i> </button>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <div id = "blank_fields">
                        <div class="d-flex mt-2 border-top pt-2 w-100">
                            <div class="flex-grow-1 px-2 mb-3">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="banner_title" placeholder="{{ get_phrase('Title') }}">
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                    <textarea name="banner_description" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}"></textarea>
                                </div>
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                    <div class="custom-file">
                                        <input type="hidden" class="form-control ol-form-control" name="old_image" value="">
                                        <input type="file" class="form-control ol-form-control" name="image" value="" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="remove_speech(this)">
                                    <i class="fi-rr-minus-small"></i> </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="fpb-7 mb-2 flex-grow-1 px-2">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
            </div>
        </div>
        <script type="text/javascript">
            "use strict";

            let blank_motivational_speech = jQuery('#blank_fields').html();
            let sliderCounter = {{ $maxkey + 1 }};
            $(document).ready(function() {
                jQuery('#blank_fields').hide();
            });

            function append_speech() {
                let newMotivationalSpeech = jQuery('#blank_fields').clone();
                newMotivationalSpeech.find('input[name="banner_title"]').attr('name', 'banner_title' + sliderCounter);
                newMotivationalSpeech.find('input[name="image"]').attr('name', 'image' + sliderCounter);
                newMotivationalSpeech.find('input[name="old_image"]').attr('name', 'old_image' + sliderCounter);
                newMotivationalSpeech.find('textarea[name="banner_description"]').attr('name', 'banner_description' + sliderCounter);
                jQuery('#area').append(newMotivationalSpeech.html());
                let newHiddenInput = '<input type="hidden" name="meditation[]" value="' + sliderCounter + '">';
                jQuery('#area').append(newHiddenInput);
                sliderCounter++;
            }

            function remove_speech(faqElem) {
                jQuery(faqElem).parent().parent().remove();
                sliderCounter--;
            }
        </script>
    @else
    @endif
</form>





<div id="sliderBlankImageField" class="d-none">
    <div class="d-flex mt-2 border-top pt-2 align-items-center">
        <div class="flex-grow-1 px-2 mb-3">
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                <div class="custom-file">
                    <input type="hidden" value="no" class="form-control ol-form-control" name="previous_slider_items[]" >
                    <input type="file" class="form-control ol-form-control" name="slider_items[]"accept="image/*">
                </div>
            </div>
        </div>
        <button class="btn btn-danger" onclick="$(this).parent().remove();"><i class="fi-rr-minus-small"></i></button>
    </div>
</div>

<div id="sliderBlankVideoField" class="d-none">
    <div class="d-flex mt-2 border-top pt-2 align-items-center">
        <div class="flex-grow-1 px-2 mb-3">
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Video Link') }} <small>({{get_phrase('Youtube')}} & {{get_phrase('HTML5')}})</small></label>
                <div class="custom-file">
                    <input type="hidden" value="no" class="form-control ol-form-control" name="previous_slider_items[]" >
                    <input type="text" class="form-control ol-form-control" name="slider_items[]">
                </div>
            </div>
        </div>
        <button class="btn btn-danger" onclick="$(this).parent().remove();"><i class="fi-rr-minus-small"></i></button>
    </div>
</div>

<script>
    function addSliderImageField() {
        var sliderBlankImageField = $('#sliderBlankImageField').html();
        $('#slider_area').append(sliderBlankImageField);
    }

    function addSliderVideoField() {
        var sliderBlankVideoField = $('#sliderBlankVideoField').html();
        $('#slider_area').append(sliderBlankVideoField);
    }
</script>
