@php
    $faqs = json_decode($bootcamp_details->faqs, true);
    $outcomes = json_decode($bootcamp_details->outcomes, true);
    $requirements = json_decode($bootcamp_details->requirements, true);
@endphp
<div class="row mb-3">
    <label class="col-md-2 form-label ol-form-label" for="faq">{{get_phrase('Bootcamp FAQ')}}</label>
    <div class="col-md-10">
        <div id = "faq_area">
            @if(is_array($faqs) && count($faqs) > 0)
                @foreach($faqs as $key => $faq)
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" value="{{$faq['title'] ?? ''}}" class="form-control ol-form-control" name="faq_title[]" id="faqs{{$key ?? ''}}" placeholder="{{get_phrase('FAQ question')}}">
                            <textarea name="faq_description[]" rows="2" class="form-control ol-form-control mt-2" placeholder="{{get_phrase('Answer')}}">{{$faq['description'] ?? ''}}</textarea>
                        </div>
                    </div>
                    <div class="">
                        @if($key == 0)
                            <button type="button" class="btn ol-btn-light ol-icon-btn" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendFaq()"> <i class="fi-rr-plus-small"></i> </button>
                        @else
                            <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeFaq(this)"> <i class="fi-rr-minus-small"></i> </button>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="faq_title[]" id="faqs" placeholder="{{get_phrase('FAQ question')}}">
                            <textarea name="faq_description[]" rows="2" class="form-control ol-form-control mt-2" placeholder="{{get_phrase('Answer')}}"></textarea>
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn" style="" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendFaq()"> <i class="fi-rr-plus-small"></i> </button>
                    </div>
                </div>
            @endif
            <div id = "blank_faq_field">
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="faq_title[]" placeholder="{{get_phrase('FAQ question')}}">
                            <textarea name="faq_description[]" rows="2" class="form-control ol-form-control mt-2" placeholder="{{get_phrase('Answer')}}"></textarea>
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeFaq(this)"> <i class="fi-rr-minus-small"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3 pt-2">
    <label class="col-md-2 form-label ol-form-label" for="requirements">{{get_phrase('Requirements')}}</label>
    <div class="col-md-10">
        <div id = "requirement_area">
            @if(is_array($requirements) && count($requirements) > 0)
                @foreach($requirements as $key => $requirement)
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" value="{{$requirement}}" class="form-control ol-form-control" name="requirements[]" id="requirements" placeholder="{{get_phrase('Provide requirements')}}">
                        </div>
                    </div>
                    <div class="">
                        @if($key == 0)
                            <button type="button" class="btn ol-btn-light ol-icon-btn" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendRequirement()"> <i class="fi-rr-plus-small"></i> </button>
                        @else
                            <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeRequirement(this)"> <i class="fi-rr-minus-small"></i> </button>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="requirements[]" id="requirements" placeholder="{{get_phrase('Provide requirements')}}">
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendRequirement()"> <i class="fi-rr-plus-small"></i> </button>
                    </div>
                </div>
            @endif
            <div id = "blank_requirement_field">
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="requirements[]" id="requirements" placeholder="{{get_phrase('Provide requirements')}}">
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeRequirement(this)"> <i class="fi-rr-minus-small"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-3 pt-2">
    <label class="col-md-2 form-label ol-form-label" for="outcomes">{{get_phrase('Outcomes')}}</label>
    <div class="col-md-10">
        <div id = "outcomes_area">
            @if(is_array($outcomes) && count($outcomes) > 0)
                @foreach($outcomes as $key => $outcome)
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" value="{{$outcome}}" class="form-control ol-form-control" name="outcomes[]" id="outcomes" placeholder="{{get_phrase('Provide outcomes')}}">
                        </div>
                    </div>
                    <div class="">
                        @if($key == 0)
                            <button type="button" class="btn ol-btn-light ol-icon-btn" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendOutcome()"> <i class="fi-rr-plus-small"></i> </button>
                        @else
                            <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeOutcome(this)"> <i class="fi-rr-minus-small"></i> </button>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="outcomes[]" id="outcomes" placeholder="{{get_phrase('Provide outcomes')}}">
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Add new') }}" onclick="appendOutcome()"> <i class="fi-rr-plus-small"></i> </button>
                    </div>
                </div>
            @endif
            <div id = "blank_outcome_field">
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="outcomes[]" placeholder="{{get_phrase('Provide outcomes')}}">
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" data-bs-toggle="tooltip" title="{{ get_phrase('Remove') }}" onclick="removeOutcome(this)"> <i class="fi-rr-minus-small"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
	<script type="text/javascript">
		"Use strict";

		var blank_faq = jQuery('#blank_faq_field').html();
		var blank_outcome = jQuery('#blank_outcome_field').html();
		var blank_requirement = jQuery('#blank_requirement_field').html();
		jQuery(document).ready(function() {
		  jQuery('#blank_faq_field').hide();
		  jQuery('#blank_outcome_field').hide();
		  jQuery('#blank_requirement_field').hide();
		});

		function appendFaq() {
		  jQuery('#faq_area').append(blank_faq);
		}
		function removeFaq(faqElem) {
		  jQuery(faqElem).parent().parent().remove();
		}

		function appendOutcome() {
		  jQuery('#outcomes_area').append(blank_outcome);
		}
		function removeOutcome(outcomeElem) {
		  jQuery(outcomeElem).parent().parent().remove();
		}

		function appendRequirement() {
		  jQuery('#requirement_area').append(blank_requirement);
		}
		function removeRequirement(requirementElem) {
		  jQuery(requirementElem).parent().parent().remove();
		}

	</script>
@endpush
