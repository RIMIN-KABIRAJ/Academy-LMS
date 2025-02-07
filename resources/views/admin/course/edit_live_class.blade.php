@php
    $live_class = App\Models\Live_class::where('id', $id)->first();
@endphp
<form class="required-form" action="{{ route('admin.live.class.update', ['id' => $id]) }}" method="post">
    @csrf
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="class_topic">{{ get_phrase('Class Topic') }}<span class="required">*</span></label>
        <input type="text" value="{{$live_class->class_topic}}" name = "class_topic" id = "class_topic" class="form-control ol-form-control" required>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="live_class_instructor_id">{{ get_phrase('Instructor') }}<span class="required">*</span></label>
        <select class="ol-select2" name="user_id" id="live_class_instructor_id">
            @foreach(App\Models\Course::where('id', $live_class->course_id)->first()->instructors() as $instructor)
                <option value="{{$instructor->id}}" @if($live_class->user_id == $instructor->id) selected @endif>{{$instructor->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="class_date_and_time">{{ get_phrase('Class date and time') }}<span class="required">*</span></label>
        <input value="{{date('Y-m-d\TH:i', strtotime($live_class->class_date_and_time))}}" type="datetime-local" class="form-control ol-form-control" name="class_date_and_time" id="class_date_and_time" required>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="note_for_student">{{ get_phrase('Note for your student') }}</label>
        <textarea class="form-control ol-form-control" name="note" id="note_for_student" rows="4">{{$live_class->note}}</textarea>
    </div>

    <div class="fpb-7 mb-3">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Update') }}</button>
    </div>
</form>

@include('admin.init')
