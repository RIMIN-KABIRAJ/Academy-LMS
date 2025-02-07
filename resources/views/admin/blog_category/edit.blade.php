@php
    $category = App\Models\BlogCategory::where('id', $id)->first();
@endphp

<form action="{{ route('admin.blog.category.update', $id) }}" method="post">@csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $category->title }}" required>
    </div>
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="subtitle">
            {{ get_phrase('Subtitle') }} <small class="text-muted">{{ get_phrase('(80  Character)') }}</small>
        </label>
        <textarea class="form-control ol-form-control" rows="3" name="subtitle" id="subtitle" maxlength="80">{{ $category->subtitle }}</textarea>
    </div>

    <div class="fpb7 mb-2">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update category') }}</button>
    </div>
</form>
