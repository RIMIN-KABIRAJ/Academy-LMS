<div class="row">
    <label class="form-label ol-form-label">
        {{ get_phrase('Answer') }}
        <span class="text-danger ms-1">*</span>
    </label>
    <div class="col-sm-8 offset-sm-2">
        <div class="btn-group mb-3 w-100" role="group">
            <input type="radio" class="btn-check" @if ($question->answer == 'true') checked @endif id="true"
                name="answer" value="true" autocomplete="off">
            <label class="btn btn-outline-secondary" for="true">{{ get_phrase('True') }}</label>

            <input type="radio" class="btn-check" @if ($question->answer == 'false') checked @endif id="false"
                name="answer" value="false" autocomplete="off">
            <label class="btn btn-outline-secondary" for="false">{{ get_phrase('False') }}</label>
        </div>
    </div>
</div>

@include('instructor.init')
