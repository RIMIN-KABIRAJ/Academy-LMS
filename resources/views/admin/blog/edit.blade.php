@extends('layouts.admin')
@push('title', get_phrase('Update Blog'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <style>
        .image_preview {
            width: 100%;
            height: 200px;
            margin-bottom: 12px;
            border-radius: 8px;
            overflow: hidden
        }
    </style>
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Update Blog') }}</span>
                </h4>
                <a href="{{ route('admin.blogs') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-10">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route('admin.blog.update', $blog_data->id) }}" method="post" enctype="multipart/form-data">@csrf
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                            <input type="text" class="form-control ol-form-control" name="title" id="title" placeholder="{{ get_phrase('Enter blog title') }}" value="{{ $blog_data->title }}" required>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="blog_category_id">{{ get_phrase('Category') }}</label>
                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="category_id" id="blog_category_id" required>
                                <option value="">{{ get_phrase('Select a category') }}</option>
                                @foreach ($category as $row)
                                    <option value="{{ $row->id }}"@if ($blog_data->category_id == $row->id) selected @endif>
                                        {{ $row->title }}</option>
                                @endforeach

                            </select>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="keywords">{{ get_phrase('Keywords') }}</label>
                            <input type="text" name="keywords" value="{{ $blog_data->keywords }}" class="tagify ol-form-control w-100" data-role="tagsinput">
                            <small class="text-muted">{{ get_phrase('Click the enter button after writing your keyword') }}</small>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="summernote-basic">{{ get_phrase('Description') }}</label>
                            <textarea name="description" class="form-control ol-form-control text_editor" id="summernote-basic">{!! removeScripts($blog_data->description) !!}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 fpb-7">
                                <label class="form-label ol-form-label" for="banner">{{ get_phrase('Blog banner') }}</label>
                                <div class="image_preview">
                                    <img src="{{ asset($blog_data->banner) }}" id="preview_banner" alt="blog-banner">
                                </div>
                                <input type="file" name="banner" id="banner" class="form-control image-upload" accept="image/*">
                            </div>

                            <div class="col-md-6 fpb-7 ">
                                <label class="form-label ol-form-label" for="thumbnail">{{ get_phrase('Blog thumbnail') }}</label>
                                <div class="image_preview">
                                    <img src="{{ asset($blog_data->thumbnail) }}" id="preview_thumbnail" alt="blog-thumbnail">
                                </div>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control image-upload" accept="image/*">
                            </div>
                        </div>

                        <div class="fpb-7 mb-3 mt-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Would you like to designate it as popular?') }}</label>

                            <div class="d-flex gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" id="mark_yes" value="1" name="is_popular" @if ($blog_data->is_popular == 1) checked @endif>
                                    <label for="mark_yes">{{ get_phrase('Yes') }}</label>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" id="mark_no" value="0" name="is_popular" @if ($blog_data->is_popular == 0) checked @endif>
                                    <label for="mark_no">{{ get_phrase('No') }}</label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h3 class="title fs-16px mb-3">{{ get_phrase('SEO Fields') }}</h3>

                        @php
                            $seo_meta_tag = App\Models\SeoField::where('course_id', $blog_data->id)->firstOrNew();
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
                            <input type="text" class="form-control ol-form-control" data-role="tagsinput" id = "canonical_url" name="canonical_url" placeholder="https://example.com/courses" value="{{ $seo_meta_tag->canonical_url }}" />
                        </div>

                        <div class="fpb-7 mb-3">
                            <label for="custom_url" class="form-label ol-form-label">{{ get_phrase(' Custom Url') }}</label>
                            <input type="text" class="form-control ol-form-control" data-role="tagsinput" id = "custom_url" name="custom_url" placeholder="https://example.com/dresses/courses" value="{{ $seo_meta_tag->custom_url }}" />
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

                        <div class="fpb-7 mb-3">
                            <button type="submit" class="ol-btn-primary">{{ get_phrase('Update blog') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        "use strict";

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
