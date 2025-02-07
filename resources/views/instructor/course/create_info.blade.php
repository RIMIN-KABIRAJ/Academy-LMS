<div class="row mb-3">
    <label class="col-md-2 form-label ol-form-label" for="faq">{{get_phrase('Course FAQ')}}</label>
    <div class="col-md-10">
        <div id = "faq_area">
            <div class="d-flex mt-2">
                <div class="flex-grow-1 px-3">
                    <div class="form-group">
                        <input type="text" class="form-control ol-form-control" name="faq_title[]" id="faqs" placeholder="{{get_phrase('FAQ question')}}">
                        <textarea name="faq_description[]" rows="2" class="form-control ol-form-control mt-2" placeholder="{{get_phrase('Answer')}}"></textarea>
                    </div>
                </div>
                <div class="">
                    <button type="button" class="btn ol-btn-light ol-icon-btn"  name="button" onclick="appendFaq()"> <i class="fa fa-plus"></i> </button>
                </div>
            </div>
            <div id = "blank_faq_field">
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="faq_title[]" placeholder="{{get_phrase('FAQ question')}}">
                            <textarea name="faq_description[]" rows="2" class="form-control ol-form-control mt-2" placeholder="{{get_phrase('Answer')}}"></textarea>
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" onclick="removeFaq(this)"> <i class="fa fa-minus"></i> </button>
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
            <div class="d-flex mt-2">
                <div class="flex-grow-1 px-3">
                    <div class="form-group">
                        <input type="text" class="form-control ol-form-control" name="requirements[]" id="requirements" placeholder="{{get_phrase('Provide requirements')}}">
                    </div>
                </div>
                <div class="">
                    <button type="button" class="btn ol-btn-light ol-icon-btn"  name="button" onclick="appendRequirement()"> <i class="fa fa-plus"></i> </button>
                </div>
            </div>
            <div id = "blank_requirement_field">
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="requirements[]" id="requirements" placeholder="{{get_phrase('Provide requirements')}}">
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" onclick="removeRequirement(this)"> <i class="fa fa-minus"></i> </button>
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
            <div class="d-flex mt-2">
                <div class="flex-grow-1 px-3">
                    <div class="form-group">
                        <input type="text" class="form-control ol-form-control" name="outcomes[]" id="outcomes" placeholder="{{get_phrase('Provide outcomes')}}">
                    </div>
                </div>
                <div class="">
                    <button type="button" class="btn ol-btn-light ol-icon-btn" name="button" onclick="appendOutcome()"> <i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div id = "blank_outcome_field">
                <div class="d-flex mt-2">
                    <div class="flex-grow-1 px-3">
                        <div class="form-group">
                            <input type="text" class="form-control ol-form-control" name="outcomes[]" id="outcomes" placeholder="{{get_phrase('Provide outcomes')}}">
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn ol-btn-light ol-icon-btn mt-0" name="button" onclick="removeOutcome(this)"> <i class="fa fa-minus"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
	<script type="text/javascript">
		"use strict";

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
