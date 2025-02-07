<form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
    @CSRF
    <input type="hidden" name="parent_id" value="{{ $parent_id }}">

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <label for="category_name" class="form-label ol-form-label">{{ get_phrase('Category Name') }}</label>
                <input type="text" name="title" class="form-control ol-form-control" id="category_name" placeholder="{{ get_phrase('Enter your category name') }}"
                    aria-label="{{ get_phrase('Enter your unique category name') }}" required />
            </div>

            <div class="mb-3">
                <label for="icon-picker" class="form-label ol-form-label">{{ get_phrase('Pick Your Icon') }}</label>
                <input type="text" name="icon" class="form-control ol-form-control icon-picker" id="icon-picker" placeholder="{{ get_phrase('Pick your category icon') }}"
                    aria-label="{{ get_phrase('Pick your category icon') }}" autocomplete="false" required />
            </div>

            <div class="mb-3">
                <label for="Keywords" class="form-label ol-form-label">{{ get_phrase('Keywords') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
                <input type="text" name="keywords" class="form-control ol-form-control" id="Keywords" placeholder="{{ get_phrase('Enter your Keywords') }}"
                    aria-label="{{ get_phrase('Enter your Keywords') }}" />
            </div>

            <div class="mb-3">
                <label for="description" class="form-label ol-form-label">{{ get_phrase('Category Description') }} <small
                        class="text-muted">({{ get_phrase('optional') }})</small></label>
                <textarea name="description" rows="4" class="form-control ol-form-control" id="description" placeholder="{{ get_phrase('Enter your description') }}"
                    aria-label="{{ get_phrase('Enter your description') }}"></textarea>
            </div>

            <div class="mb-3">
                <label for="thumbnail" class="form-label ol-form-label">{{ get_phrase('Thumbnail') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
                <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
            </div>
            <div class="mb-3">
                <label for="category_logo" class="form-label ol-form-label">{{ get_phrase('Category logo') }} <small class="text-muted">({{ get_phrase('optional') }})</small></label>
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
</script>
