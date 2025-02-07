<h4 class="title mt-4 mb-3">{{ get_phrase('Website FAQS') }}</h4>
<form action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="websitefaqs">
    <div class="row">
        <div class="col-md-8">
            <div id = "faq_area">
                @php
                    $faqs = count(json_decode(get_frontend_settings('website_faqs'), true)) > 0 ? json_decode(get_frontend_settings('website_faqs'), true) : [['question' => '', 'answer' => '']];
                @endphp
                @foreach ($faqs as $key => $faq)
                    <div class="d-flex mt-2">
                        <div class="flex-grow-1 px-2 mb-3">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Question') }}</label>
                                <input type="text" class="form-control ol-form-control" name="questions[]" id="questions" placeholder="{{ get_phrase('Write a question') }}" value="{{ $faq['question'] }}">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Answer') }}</label>
                                <textarea name="answers[]" class="form-control ol-form-control" placeholder="{{ get_phrase('Write a question answer') }}">{{ $faq['answer'] }}</textarea>
                            </div>
                        </div>

                        @if ($key == 0)
                            <div class="pt-4">
                                <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendFaq()"> <i class="fi-rr-plus-small"></i>
                                </button>
                            </div>
                        @else
                            <div class="pt-4">
                                <button type="button" class="btn ol-btn-light ol-icon-btn mt-2" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" name="button" onclick="removeFaq(this)"> <i class="fi-rr-minus-small"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div id = "blank_faq_field">
                    <div class="d-flex pt-2 border-top">
                        <div class="flex-grow-1 px-3">
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Question') }}</label>
                                <input type="text" class="form-control ol-form-control" name="questions[]" id="questions" placeholder="{{ get_phrase('Write a question') }}">
                            </div>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label">{{ get_phrase('Answer') }}</label>
                                <textarea name="answers[]" class="form-control ol-form-control" placeholder="{{ get_phrase('Write a question answer') }}"></textarea>
                            </div>

                        </div>
                        <div class="pt-4">
                            <button type="button" class="btn ol-btn-light ol-icon-btn mt-2"name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeFaq(this)"> <i class="fi-rr-minus-small"></i>
                            </button>
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
