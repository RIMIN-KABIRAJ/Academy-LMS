<form action="{{ route('admin.page.update', ['id' => $id]) }}" method="post" enctype="multipart/form-data">
    @CSRF

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="name" class="form-label ol-form-label">{{ get_phrase('Name') }}</label>
                <input type="text" name="name" class="form-control ol-form-control" id="name" placeholder="{{ get_phrase('Enter your page name') }}" aria-label="{{ get_phrase('Enter your page name') }}" value="{{ App\Models\Builder_page::where('id', $id)->first()->name }}" required />
            </div>

            <div class="mb-2">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
            </div>
        </div>
    </div>
</form>
