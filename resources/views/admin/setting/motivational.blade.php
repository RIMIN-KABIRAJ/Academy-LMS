<h4 class="title mt-4 mb-3">{{ get_phrase('Motivational Speech') }}</h4>
<form action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="motivational_speech">
    <div class="row">
        <div class="col-md-8">
            <div id = "motivational_speech_area">
                @php
                    $motivational_speeches = count(json_decode(get_frontend_settings('motivational_speech'), true)) > 0 ? json_decode(get_frontend_settings('motivational_speech'), true) : [['title' => '', 'description' => '', 'image' => '']];
                @endphp
                @foreach ($motivational_speeches as $key => $motivational_speech)
                    <div class="d-flex mt-2">
                        <div class="flex-grow-1 px-2 mb-3">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                <input type="text" class="form-control ol-form-control" name="titles[]" placeholder="{{ get_phrase('Title') }}" value="{{ $motivational_speech['title'] }}">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('designation') }}</label>
                                <input type="text" class="form-control ol-form-control" name="designation[]" placeholder="{{ get_phrase('designation') }}" value="{{ $motivational_speech['designation'] ?? '' }}">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                <textarea name="descriptions[]" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}">{{ $motivational_speech['description'] }}</textarea>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                <div class="custom-file">
                                    <input name="previous_images[]" type="hidden" value="{{ $motivational_speech['image'] }}">
                                    <input type="file" class="form-control ol-form-control" name="images[]" onchange="" accept="image/*">
                                </div>
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

                <div id = "blank_motivational_speech_field">
                    <div class="d-flex mt-2 border-top pt-2">
                        <div class="flex-grow-1 px-2 mb-3">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                                <input type="text" class="form-control ol-form-control" name="titles[]" placeholder="{{ get_phrase('Title') }}">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('designation') }}</label>
                                <input type="text" class="form-control ol-form-control" name="designation[]" placeholder="{{ get_phrase('designation') }}">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
                                <textarea name="descriptions[]" class="form-control ol-form-control" placeholder="{{ get_phrase('Description') }}"></textarea>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Image') }}</label>
                                <div class="custom-file">
                                    <input name="previous_images[]" type="hidden" value="">
                                    <input type="file" class="form-control ol-form-control" name="images[]" onchange="" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeMotivational_speech(this)">
                                <i class="fi-rr-minus-small"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fpb-7 mb-2 flex-grow-1 px-2">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save changes') }}</button>
            </div>
        </div>
    </div>
</form>
