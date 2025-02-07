<select class="ol-select2" name="course_id" id="course_id" required>
    <option value="">{{ get_phrase('Select package course') }}</option>

    @foreach ($courses as $course)
        <option value="{{ $course->id }}">{{ $course->title }}</option>
    @endforeach
</select>

@include('instructor.init')
