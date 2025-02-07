<form action="{{route('admin.course.approval', ['id' => $course_id])}}" method="post">
    @csrf

    <div class="mb-3">
        <label for="form-label mb-1">{{get_phrase('Subject')}}</label>
        <input name="subject" type="text" class="form-control ol-form-control">
    </div>

    <div class="mb-3">
        <label for="form-label mb-1">{{get_phrase('Message')}}</label>
        <textarea name="message" rows="5" class="form-control ol-form-control"></textarea>
    </div>
    
    <div class="mb-3">
        <button type="submit" class="btn ol-btn-primary">{{get_phrase('Send approval email')}}</button>
    </div>
</form>