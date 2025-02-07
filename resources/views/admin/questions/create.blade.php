<style>
    .select2-selection.select2-selection--multiple {
        cursor: pointer !important;
    }
</style>

<form class="ajaxForm" action="{{ route('admin.course.question.store') }}" method="post">@csrf

    <input type="hidden" name="quiz_id" value="{{ $id }}">
    <div class="row">
        <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label ol-form-label">
                    {{ get_phrase('Question Type') }}
                    <span class="text-danger ms-1">*</span>
                </label>
                <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="type"
                    onchange="getOptionType(this)">
                    <option value="">{{ get_phrase('Select an option') }}</option>
                    <option value="mcq">{{ get_phrase('Multiple Choice') }}</option>
                    <option value="fill_blanks">{{ get_phrase('Fill in the blanks') }}</option>
                    <option value="true_false">{{ get_phrase('True or False') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div class="fpb-7 mb-3">
        <label for="title" class="form-label ol-form-label">
            {{ get_phrase('Write question') }}
            <span class="text-danger ms-1">*</span>
        </label>
        <textarea name="title" rows="5" class="form-control ol-form-control text_editor"></textarea>
    </div>

    <div class="load-question-type"></div>

    <div class="d-flex gap-3">
        <a href="#" class="btn ol-btn-primary" id="questionBackBtn"
            onclick="ajaxModal('{{ route('modal', ['admin.questions.index', 'id' => $id]) }}', '{{ get_phrase('Questions') }}', 'modal-lg')">
            <i class="fi-rr-angle-small-left"></i> {{ get_phrase('Back') }}
        </a>

        <div class="fpb7">
            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add Question') }}</button>
        </div>
    </div>
</form>


@include('admin.init')
<script>
    function getOptionType(elem) {
        let type = elem.value;
        setupQuestion(type)
    }

    function setupQuestion(type) {
        if (type) {
            $.ajax({
                type: "get",
                url: "{{ route('admin.load.question.type') }}",
                data: {
                    type: type
                },
                success: function(response) {
                    $('.load-question-type').empty().append(response)
                }
            });
        }
    }

    // after response this function will call
    function responseBack() {
        document.querySelector('#questionBackBtn').click();
    }
</script>
