
@php
    $seo_meta_tag = App\Models\SeoField::where('course_id', $course_details->id)->firstOrNew();
@endphp
<div class="fpb-7 mb-3">
    <label for="meta_title" class="form-label ol-form-label">{{ get_phrase('Meta Title') }}</label>
    <input class="form-control ol-form-control" id="meta_title" name="meta_title" type="text" value="{{ $seo_meta_tag->meta_title }}" placeholder="Meta Title" />
</div>

<div class="fpb-7 mb-3">
    <label for="meta_keywords" class="form-label ol-form-label">{{ get_phrase('Meta Keywords') }}</label>
    <input type="text" name="meta_keywords" value="{{ $seo_meta_tag->meta_keywords }}" class="tagify ol-form-control w-100" id="meta_keywords" placeholder="Meta keywords" />
    <small class="form-label ol-form-label text-muted">{{ get_phrase('Writing your keyword and hit the enter') }}</small>
</div>

<div class="fpb-7 mb-3">
    <label for="meta_description" class="form-label ol-form-label">{{ get_phrase('Meta Description') }}</label>
    <textarea class="form-control ol-form-control" id="meta_description" name="meta_description" type="text" placeholder="Meta Description">{{ $seo_meta_tag->meta_description }}</textarea>
</div>

<div class="fpb-7 mb-3">
    <label for="meta_robot" class="form-label ol-form-label">{{ get_phrase('Meta Robot') }}</label>
    <input class="form-control ol-form-control" id="meta_robot" name="meta_robot" type="text" value="{{ $seo_meta_tag->meta_robot }}" placeholder="Meta Robot" />
</div>

<div class="fpb-7 mb-3">
    <label for="canonical_url" class="form-label ol-form-label">{{ get_phrase(' Canonical Url') }}</label>
    <input type="text" class="form-control ol-form-control" data-role="tagsinput" id = "canonical_url" name="canonical_url" placeholder="https://example.com/courses"
        value="{{ $seo_meta_tag->canonical_url }}" />
</div>

<div class="fpb-7 mb-3">
    <label for="custom_url" class="form-label ol-form-label">{{ get_phrase(' Custom Url') }}</label>
    <input type="text" class="form-control ol-form-control" data-role="tagsinput" id = "custom_url" name="custom_url" placeholder="https://example.com/dresses/courses"
        value="{{ $seo_meta_tag->custom_url }}" />
</div>

<div class="fpb-7 mb-3">
    <label for="og_title" class="form-label ol-form-label">{{ get_phrase('Og Title') }}</label>
    <input type="text" class="form-control ol-form-control" data-role="tagsinput" id = "og_title" name="og_title" value="{{ $seo_meta_tag->og_title }}" />
</div>

<div class="fpb-7 mb-3">
    <label for="og_description" class="form-label ol-form-label">{{ get_phrase('Og Description') }}</label>
    <textarea class="form-control ol-form-control" id="og_description" name="og_description" type="text">{{ $seo_meta_tag->og_description }}</textarea>
</div>

<div class="fpb-7 mb-3">
    <label for="og_image" class="form-label ol-form-label">{{ get_phrase('Og Image') }}</label>
    <div class="og_image mb-2">
        <img width="150px" src="{{ get_image($seo_meta_tag->og_image) }}" alt="....">
    </div>
    <input type="file" class="form-control ol-form-control" id = "og_image" name="og_image" value="{{ $seo_meta_tag->og_image }}" />
    <input type="hidden" name="old_og_image" value="{{ $seo_meta_tag->og_image }}">
</div>

<div class="fpb-7 mb-3">
    <label for="json_ld" class="form-label ol-form-label">{{ get_phrase('Json Id') }}</label>
    <textarea class="form-control ol-form-control" id="json_ld" name="json_ld">{{ $seo_meta_tag->json_ld }}</textarea>
</div>
