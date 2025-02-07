@php
    $category = App\Models\Category::where('id', $id)->first();
    $parent_categories = App\Models\Category::where('parent_id', 0)->orderBy('title', 'asc')->get();
@endphp
<form action="{{ route('admin.category.update', $category->id) }}" method="post" enctype="multipart/form-data">
    @CSRF

    <div class="mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Parent category') }}</label>
        <select class="form-control ol-form-control ol-select2" name="parent_id">
            <option value="0" @if ($category->parent_id == 0) selected @endif>{{ get_phrase('- Mark it as parent -') }}</option>
            @foreach ($parent_categories as $parent_category)
                <option value="{{ $parent_category->id }}" @if ($category->parent_id == $parent_category->id) selected @endif>{{ $parent_category->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="category_name" class="form-label ol-form-label">{{ get_phrase('Category Name') }}</label>
                <input type="text" name="title" value="{{ $category->title }}" class="form-control ol-form-control" id="category_name" placeholder="{{ get_phrase('Enter your category name') }}" aria-label="{{ get_phrase('Enter your unique category name') }}" required />
            </div>

            <div class="mb-3">
                <label for="icon-picker" class="form-label ol-form-label">{{ get_phrase('Pick Your Icon') }}</label>
                <input type="text" name="icon" value="{{ $category->icon }}" class="form-control ol-form-control icon-picker" id="icon-picker" placeholder="{{ get_phrase('Pick your category icon') }}" aria-label="{{ get_phrase('Pick your category icon') }}" autocomplete="false" required />
            </div>

            <div class="mb-3">
                <label for="Keywords" class="form-label ol-form-label">{{ get_phrase('Keywords') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
                <input type="text" name="keywords" value="{{ $category->keywords }}" class="form-control ol-form-control" id="Keywords" placeholder="{{ get_phrase('Enter your Keywords') }}" aria-label="{{ get_phrase('Enter your Keywords') }}" />
            </div>

            <div class="mb-3">
                <label for="description" class="form-label ol-form-label">{{ get_phrase('Category Description') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
                <textarea name="description" rows="4" class="form-control ol-form-control" id="description" placeholder="{{ get_phrase('Enter your description') }}" aria-label="{{ get_phrase('Enter your description') }}">{{ $category->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label ol-form-label">{{ get_phrase('Choose category thumbnail') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
                <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
            </div>
            <div class="mb-3">
                <label for="category_logo" class="form-label ol-form-label">{{ get_phrase('Choose category Logo') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
                <input type="file" name="category_logo" class="form-control ol-form-control" id="category_logo" accept="image/*" />
            </div>

            <div class="mb-2">
                <button class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
            </div>
        </div>
    </div>
</form>


<script type="text/javascript">
    "use strict";

    $(function() {
        if ($('.icon-picker').length) {
            $('.icon-picker').iconpicker();
        }
    });
    $('.ol-select2').select2({
        dropdownParent: $("#ajaxModal")
    });
</script>
