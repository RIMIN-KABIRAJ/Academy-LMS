<div class="fpb7 mb-3">
    <label class="form-label ol-form-label" for="answer">
        {{ get_phrase('Answer') }}
        <span class="text-danger ms-1">*</span>
    </label>
    <input class="form-control ol-form-control tagify" type="text" data-role="tagsinput" id="answer" name="answer"
        value="{{ $question->answer }}" placeholder="{{ get_phrase('Your answer here') }}">
    <small>{{ get_phrase('You can keep multiple answers. Just put your answer and hit enter.') }}</small>
</div>

@include('admin.init')
