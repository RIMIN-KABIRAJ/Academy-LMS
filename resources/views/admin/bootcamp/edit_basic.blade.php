<input type="hidden" name="course_type" value="general" required>
<input type="hidden" name="instructors[]" value="{{ auth()->user()->id }}" required>


<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Course title') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <input type="text" name="title" value="{{ $bootcamp_details->title }}" class="form-control ol-form-control"
            id="title" required>
    </div>
</div>

<div class="row mb-3">
    <label for="short_description"
        class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Short description') }}</label>
    <div class="col-sm-10">
        <textarea name="short_description" rows="3" class="form-control ol-form-control" id="short_description">{{ $bootcamp_details->short_description }}</textarea>
    </div>
</div>

<div class="row mb-3">
    <label for="description"
        class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Description') }}</label>
    <div class="col-sm-10">
        <textarea name="description" rows="5" class="form-control ol-form-control text_editor" id="description">{!! $bootcamp_details->description !!}</textarea>
    </div>
</div>

<div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Category') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <select class="ol-select2" name="category_id" data-minimum-results-for-search="Infinity" required>
            <option value="">{{ get_phrase('Select a category') }}</option>
            @foreach (App\Models\BootcampCategory::orderBy('title', 'asc')->get() as $category)
                <option value="{{ $category->id }}" @if ($bootcamp_details->category_id == $category->id) selected @endif>
                    {{ $category->title }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Publish Date') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <input type="date" name="publish_date" value="{{ date('Y-m-d', $bootcamp_details->publish_date) }}" class="form-control ol-form-control"
            id="title" required>
    </div>
</div>
