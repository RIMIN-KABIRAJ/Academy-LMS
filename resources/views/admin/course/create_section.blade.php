<form action="{{ route('admin.section.store') }}" method="post" enctype="multipart/form-data">
    @CSRF
    <input type="hidden" name="course_id" value="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="category_name" class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                <input type="text" name="title" class="form-control ol-form-control" id="category_name" placeholder="{{ get_phrase('Enter title') }}" aria-label="{{ get_phrase('Enter title') }}" required />
            </div>

            <div class="mb-2">
                <button class="ol-btn-primary">{{ get_phrase('Submit') }}</button>
            </div>
        </div>
    </div>
</form>
