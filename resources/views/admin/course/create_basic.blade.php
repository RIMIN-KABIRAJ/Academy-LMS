<input type="hidden" name="course_type" value="general" required>
<input type="hidden" name="instructors[]" value="{{ auth()->user()->id }}" required>


<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Course title') }}<span class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <input type="text" name="title" class="form-control ol-form-control" id="title" required>
    </div>
</div>

<div class="row mb-3">
    <label for="short_description" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Short description') }}</label>
    <div class="col-sm-10">
        <textarea name="short_description" rows="3" class="form-control ol-form-control" id="short_description"></textarea>
    </div>
</div>

<div class="row mb-3">
    <label for="description" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Description') }}</label>
    <div class="col-sm-10">
        <textarea name="description" rows="5" class="form-control ol-form-control text_editor" id="description"></textarea>
    </div>
</div>

<div class="row mb-3">
    <label for="category_id" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Category') }}<span class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <select class="form-control ol-form-control ol-select2" name="category_id" id="category_id" required>
            <option value="">{{ get_phrase('Select a category') }}</option>
            @foreach (App\Models\Category::where('parent_id', 0)->orderBy('title', 'desc')->get() as $category)
                <option value="{{ $category->id }}"> {{ $category->title }}</option>

                @foreach ($category->childs as $sub_category)
                    <option value="{{ $sub_category->id }}"> -- {{ $sub_category->title }}</option>
                @endforeach
            @endforeach
        </select>
    </div>
</div>

<div class="row mb-3">
    <label for="level" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Course level') }}<span class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <select class="form-control ol-form-control ol-select2" name="level" id="level" required>
            <option value="">{{ get_phrase('Select your course level') }}</option>
            <option value="beginner">{{ get_phrase('Beginner') }}</option>
            <option value="intermediate">{{ get_phrase('Intermediate') }}</option>
            <option value="advanced">{{ get_phrase('Advanced') }}</option>
        </select>
    </div>
</div>

<div class="row mb-3">
    <label for="language" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Made in') }} <span class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <select class="form-control ol-form-control ol-select2" name="language" id="language" required>
            <option value="">{{ get_phrase('Select your course language') }}</option>
            @foreach (App\Models\Language::get() as $language)
                <option value="{{ strtolower($language->name) }}" class="text-capitalize">{{ $language->name }}</option>
            @endforeach
        </select>
    </div>
</div>


<div class="row mb-3 ">
    <label for="course_status" class="col-sm-2 col-form-label">{{ get_phrase('Create as') }} <span class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <div class="eRadios">
            <div class="form-check">
                <input type="radio" value="active" name="status" class="form-check-input eRadioSuccess" id="status_active" required checked>
                <label for="status_active" class="form-check-label">{{ get_phrase('Active') }}</label>
            </div>

            <div class="form-check">
                <input type="radio" value="private" name="status" class="form-check-input eRadioPrimary" id="status_private" required>
                <label for="status_private" class="form-check-label">{{ get_phrase('Private') }}</label>
            </div>

            <div class="form-check">
                <input type="radio" value="upcoming" name="status" class="form-check-input eRadioInfo" id="status_upcoming" required>
                <label for="status_upcoming" class="form-check-label">{{ get_phrase('Upcoming') }}</label>
            </div>

            <div class="form-check">
                <input type="radio" value="pending" name="status" class="form-check-input eRadioDanger" id="status_pending" required>
                <label for="status_pending" class="form-check-label">{{ get_phrase('Pending') }}</label>
            </div>

            <div class="form-check">
                <input type="radio" value="draft" name="status" class="form-check-input eRadioSecondary" id="status_draft" required>
                <label for="status_draft" class="form-check-label">{{ get_phrase('Draft') }}</label>
            </div>

            <div class="form-check">
                <input type="radio" value="inactive" name="status" class="form-check-input eRadioDark" id="status_inactive" required>
                <label for="status_inactive" class="form-check-label">{{ get_phrase('Inactive') }}</label>
            </div>
        </div>
    </div>
</div>
