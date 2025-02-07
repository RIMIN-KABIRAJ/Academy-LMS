@php
    $questions = App\Models\Question::where('quiz_id', $id)->orderBy('sort')->get();
@endphp

@if ($questions->count() > 0)
    <div class="row">
        <div class="col-12 d-flex gap-3">
            <a href="#"
                onclick="ajaxModal('{{ route('modal', ['instructor.questions.create', 'id' => $id]) }}', '{{ get_phrase('Add Question') }}', 'modal-lg')"
                class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Add Question') }}
            </a>

            <a href="#"
                onclick="ajaxModal('{{ route('modal', ['instructor.questions.sort', 'id' => $id]) }}', '{{ get_phrase('Sort Questions') }}')"
                class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Sort Questions') }}
            </a>
        </div>
    </div>

    <ul class="list-group-3 mt-3">
        @foreach ($questions as $key => $question)
            <li>
                <h4 class="title d-flex gap-2">
                    <span>{{ ++$key }}. </span>
                    <div>{!! $question->title !!}</div>
                </h4>

                <div class="buttons">
                    <a href="#" data-bs-toggle="tooltip"
                        onclick="ajaxModal('{{ route('modal', ['instructor.questions.edit', 'id' => $question->id]) }}', '{{ get_phrase('Edit Question') }}', 'modal-lg')"
                        class="edit-delete" aria-label="Edit quiz" data-bs-original-title="Edit quiz">
                        <span class="fi-rr-pencil"></span>
                    </a>

                    <a href="#" data-bs-toggle="tooltip"
                        onclick="confirmModal('{{ route('instructor.course.question.delete', $question->id) }}'); event.stopPropagation();"
                        class="edit-delete" aria-label="Delete lesson" data-bs-original-title="Delete lesson">
                        <span class="fi-rr-trash"></span>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <div class="row">
        <div class="col-8 offset-2">
            <a onclick="ajaxModal('{{ route('modal', ['instructor.questions.create', 'id' => $id]) }}', '{{ get_phrase('Add Question') }}', 'modal-lg')"
                href="#" class="add-section-block text-center">
                <p class="sub-title"><i class="fi-rr-add"></i></p>
                <h3 class="title text-15px mt-2 fw-500">{{ get_phrase('Add Question') }}</h3>
            </a>
        </div>
    </div>
@endif
