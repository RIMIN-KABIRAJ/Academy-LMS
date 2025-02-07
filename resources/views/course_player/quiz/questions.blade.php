<style>
    .serial {
        width: 30px;
        height: 30px;
        background: #F2F3F5;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<form action="{{ route('quiz.submit', $quiz->id) }}" method="post" class="quiz-submit-form">@csrf
    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
    @foreach ($questions as $key => $question)
        <div class="question px-4 mb-4 @if ($key > 0) d-none @endif">
            <div class="mb-3 d-flex gap-3">
                <span class="serial">{{ ++$key }} </span>
                <div>{!! $question->title !!}</div>
            </div>

            <div class="row gap-0">
                @if ($question->type == 'mcq')
                    @php $options = json_decode($question->options, true) ?? []; @endphp
                    @foreach ($options as $index => $option)
                        <div class="col-sm-6">
                            <input class="form-check-input" type="checkbox" name="{{ $question->id }}[]"
                                value="{{ $option }}" id="{{ $option }}-{{ $question->id }}">
                            <label class="form-check-label text-capitalize"
                                for="{{ $option }}-{{ $question->id }}">{{ $option }}</label>
                        </div>
                    @endforeach
                @elseif($question->type == 'fill_blanks')
                    <input type="text" class="form-control tagify" name="{{ $question->id }}" data-role="tagsinput">
                @elseif($question->type == 'true_false')
                    <div class="col-sm-2">
                        <input class="form-check-input" type="radio" name="{{ $question->id }}" value="true"
                            id="question-{{ $question->id }}-true">
                        <label class="form-check-label"
                            for="question-{{ $question->id }}-true">{{ get_phrase('True') }}</label>
                    </div>
                    <div class="col-sm-2">
                        <input class="form-check-input" type="radio" name="{{ $question->id }}" value="false"
                            id="question-{{ $question->id }}-false">
                        <label class="form-check-label"
                            for="question-{{ $question->id }}-false">{{ get_phrase('False') }}</label>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</form>


@if ($questions->count() > 0)
    <div class="row">
        <div class="col-12 d-flex gap-3 justify-content-center">
            <button type="button" class="eBtn gradient border-0" id="prevBtn" onclick="prevQuestion()"><i
                    class="fi fi-rr-angle-small-left"></i>{{ get_phrase('Prev') }}</button>
            <button type="button" class="eBtn gradient border-0" id="nextBtn"
                onclick="nextQuestion()">{{ get_phrase('Next') }}<i class="fi fi-rr-angle-small-right"></i></button>
            @if ($submits->count() < $quiz->retake)
                <button type="button" class="eBtn gradient border-0 d-none" id="submitBtn"
                    onclick="submitQuiz()">{{ get_phrase('Submit') }}<i class="fi fi-rr-badge-check ms-2"></i></button>
            @endif
        </div>
    </div>
@endif

@include('course_player.init')

<script>
    let nextBtn = document.querySelector('#nextBtn');
    let prevBtn = document.querySelector('#prevBtn');
    let submitBtn = document.querySelector('#submitBtn');
    let submitForm = document.querySelector('.quiz-submit-form');
    // next question
    function nextQuestion() {
        let selectQuestion = document.querySelector('.question:not(.d-none)');
        let nextQuestion = selectQuestion.nextElementSibling;
        if (nextQuestion && nextQuestion.classList.contains('question')) {
            selectQuestion.classList.add('d-none');
            nextQuestion.classList.remove('d-none');
        }
        let nextNextQuestion = nextQuestion.nextElementSibling;
        if (!(nextNextQuestion && nextNextQuestion.classList.contains('question'))) {
            submitBtn.classList.remove('d-none');
            nextBtn.classList.add('d-none');
        }
    }

    // previous question
    function prevQuestion() {
        let selectQuestion = document.querySelector('.question:not(.d-none)');
        let prevQuestion = selectQuestion.previousElementSibling;
        if (prevQuestion && prevQuestion.classList.contains('question')) {
            selectQuestion.classList.add('d-none');
            prevQuestion.classList.remove('d-none');
        }
        if (nextBtn.classList.contains('d-none')) {
            nextBtn.classList.remove('d-none');
            submitBtn.classList.add('d-none');
        }
    }

    // submit quiz
    function submitQuiz() {
        submitForm.submit();
    }
</script>
