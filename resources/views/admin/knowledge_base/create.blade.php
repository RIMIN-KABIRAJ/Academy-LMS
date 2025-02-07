<form action="{{ route('admin.knowledge.base.store') }}" method="post">
    @csrf

    <div class="mb-3">
        <label for="title" class="form-label ol-form-label">{{ get_phrase('Title') }}</label>
        <input type="text" name="title" class="form-control ol-form-control" id="title" placeholder="{{ get_phrase('Subject') }}" required>
    </div>

    <div class="fpb-7">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Submit') }}</button>
    </div>
</form>
