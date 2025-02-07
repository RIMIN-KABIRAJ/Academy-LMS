@php
    $sections = App\Models\Section::where('id', $id)->first();
@endphp
<form action="{{ route('instructor.section.update') }}" method="post" enctype="multipart/form-data">
    @CSRF
    <input type="hidden" name="section_id" value="{{ $id }}">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="category_name" class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
                <input type="text" name="up_title" class="form-control ol-form-control" id="category_name" placeholder="{{ get_phrase('Enter title') }}" aria-label="{{ get_phrase('Enter title') }}" value="{{ $sections->title }}" required />
            </div>

            <div class="mb-2">
                <button class="btn ol-btn-primary">{{ get_phrase('Update') }}</button>
            </div>
        </div>
    </div>
</form>
