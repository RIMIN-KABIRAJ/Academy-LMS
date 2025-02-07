@php
    $category = App\Models\BootcampCategory::where('id', $id)->first();
@endphp

<form action="{{ route('admin.bootcamp.category.update', $category->id) }}" method="post">@csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input class="form-control ol-form-control" type="text" id="title" name="title" value="{{ $category->title }}" required>
    </div>

    <div class="fpb7 mb-2">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update category') }}</button>
    </div>
</form>
