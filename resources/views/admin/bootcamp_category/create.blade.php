<form action="{{ route('admin.bootcamp.category.store') }}" method="post">@csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
        <input class="form-control ol-form-control" type="text" id="title" name="title" required>
    </div>

    <div class="fpb7 mb-2">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Add category') }}</button>
    </div>
</form>
