<div class="fpb7 mb-3">
    <label class="form-label ol-form-label" for="options">
        {{ get_phrase('Options') }}
        <span class="text-danger ms-1">*</span>
    </label>
    <input class="form-control ol-form-control tagify" type="text" data-role="tagsinput" id="options" name="options"
        placeholder="{{ get_phrase('Your questions here') }}">
    <small>{{ get_phrase('You can keep multiple options. Just put an option and hit enter.') }}</small>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="mb-3">
            <label class="form-label ol-form-label">
                {{ get_phrase('Answer') }}
                <span class="text-danger ms-1">*</span>
            </label>
            <select class="form-control ol-form-control ol-select2" name="answer[]" data-toggle="select2"
                id="answer-select2" multiple>
                <option value="">{{ get_phrase('Select an option') }}</option>
            </select>
            <small>{{ get_phrase('You can select multiple answers.') }}</small>
        </div>
    </div>
</div>

@include('instructor.init')

<script>
    var inputElm = document.querySelector('#options');
    inputElm.addEventListener('change', onChange)

    function onChange(e) {
        let values = e.target.value
        let varArr = JSON.parse(values)
        let answerSelect2 = document.querySelector('#answer-select2')

        answerSelect2.innerHTML = ''
        varArr.forEach(item => {
            let option = document.createElement('option')
            option.text = item.value
            option.value = item.value
            answerSelect2.add(option)
        });
    }
</script>
