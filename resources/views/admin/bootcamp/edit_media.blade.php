<style>
    .image_preview {
        width: 100%;
        height: 250px;
        border-radius: 8px;
        overflow: hidden
    }

    .image_preview img{
        widows: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
</style>

<div class="row mb-3">
    <label for="thumbnail" class="form-label ol-form-label col-sm-2 col-form-label">{{get_phrase('Thumbnail')}}</label>
    <div class="col-sm-10">
        <input type="file" name="thumbnail" class="form-control ol-form-control" id="thumbnail" accept="image/*" />
    </div>

    <div class="offset-md-2 offset-lg-3 col-md-10 col-lg-6 fpb-7 mt-3">
        <div class="image_preview">
            <img src="{{ asset($bootcamp_details->thumbnail) }}" id="preview_thumbnail" width="100%" alt="blog-thumbnail">
        </div>
    </div>
</div>

@push('js')
    <script>
        $(function() {
            $('#banner, #thumbnail').change(function(e) {
                e.preventDefault();

                var img_type = $(this).attr('id');
                var x = URL.createObjectURL(event.target.files[0]);
                $('#preview_' + img_type).attr('src', x);
            });
        });
    </script>
@endpush
