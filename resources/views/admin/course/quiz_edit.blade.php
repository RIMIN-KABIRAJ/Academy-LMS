@php
    $quiz = App\Models\Quiz::join('sections', 'quizzes.section_id', 'sections.id')
        ->select('quizzes.*', 'sections.course_id')
        ->where('quizzes.id', $id)
        ->first();
    $course_id = $quiz->course_id;
    $duration = json_decode($quiz->duration, true);
@endphp

<form action="{{ route('admin.quiz.update', $id) }}" method="post" enctype="multipart/form-data">@csrf
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="title" class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                <input type="text" name="title" class="form-control ol-form-control" id="title" value="{{ $quiz->title }}" required>
            </div>

            <div class="mb-3">
                <label for="section" class="form-label ol-form-label">{{ get_phrase('Section') }}</label>
                <select class="ol-form-control select select2" data-toggle="select2" id="section" name="section_id" required>
                    <option value="">{{ get_phrase('Select a section') }}</option>

                    @foreach (App\Models\Section::where('course_id', $course_id)->get() as $section)
                        <option value="{{ $section->id }}" @selected($section->id == $quiz->section_id)>{{ $section->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <div class="row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="total_mark" class="form-label ol-form-label">{{ get_phrase('Total mark') }}</label>
                        <input type="number" min="1" name="total_mark" value="{{ $quiz->total_mark }}" class="form-control ol-form-control" id="total_mark" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="pass_mark" class="form-label ol-form-label">{{ get_phrase('Pass mark') }}</label>
                        <input type="number" min="1" name="pass_mark" value="{{ $quiz->pass_mark }}" class="form-control ol-form-control" id="pass_mark" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label ol-form-label">{{ get_phrase('Duration') }}</label>

                <div class="row">
                    <div class="col-6">
                        <div class="counter hour">
                            <input type="number" name="hour" value="{{ $duration['hour'] }}" class="form-control ol-form-control" min="0" max="24" placeholder="{{ get_phrase('Hour') }}">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="counter minute">
                            <input type="number" name="minute" value="{{ $duration['minute'] }}" class="form-control ol-form-control" min="0" max="59" required placeholder="{{ get_phrase('Minute') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="section" class="form-label ol-form-label">
                    <span>{{ get_phrase('Drip content rule for quiz ') }}</span>
                    <small>{{ get_phrase('(This will only work if drip content is enabled)') }}</small>
                </label>
                <select class="ol-form-control select select2" data-toggle="select2" name="drip_rule" required>
                    <option value="">{{ get_phrase('Select a section') }}</option>
                    <option value="0" @selected($quiz->drip_rule)>{{ get_phrase('Students can start the next lesson by submitting the quiz') }}</option>
                    <option value="1" @selected(!$quiz->drip_rule)>{{ get_phrase('Students must achieve pass mark to start the next lesson') }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="summary" class="form-label ol-form-label">{{ get_phrase('Summary') }}</label>
                <textarea name="summary" class="form-control ol-form-control" id="summary">{{ $quiz->summary }}</textarea>
            </div>

            <div class="">
                <button class="btn ol-btn-primary">{{ get_phrase('Add quiz') }}</button>
            </div>
        </div>
    </div>
</form>

@include('admin.init')
