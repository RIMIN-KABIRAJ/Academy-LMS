<form class="required-form" action="{{ route('admin.live.class.store', ['course_id' => $course_id]) }}" method="post">
    @csrf
    <input name="provider" type="hidden" value="zoom">

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="class_topic">{{ get_phrase('Class Topic') }}<span class="required">*</span></label>
        <input type="text" name = "class_topic" id = "class_topic" class="form-control ol-form-control" required>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="live_class_instructor_id">{{ get_phrase('Instructor') }}<span class="required">*</span></label>
        <select class="ol-select2" name="user_id" id="live_class_instructor_id">
            @foreach (App\Models\Course::where('id', $course_id)->first()->instructors() as $instructor)
                <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="class_date_and_time">{{ get_phrase('Class date and time') }}<span class="required">*</span></label>
        <input type="datetime-local" class="form-control ol-form-control" name="class_date_and_time" id="class_date_and_time" required>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="note_for_student">{{ get_phrase('Note for your student') }}</label>
        <textarea class="form-control ol-form-control" name="note" id="note_for_student" rows="4"></textarea>
    </div>

    <div class="fpb-7 mb-3">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Create') }}</button>
    </div>
</form>

@include('admin.init')
