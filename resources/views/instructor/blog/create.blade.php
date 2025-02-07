@extends('layouts.instructor')
@push('title', get_phrase('Add New Blog'))
@push('meta')@endpush
@push('css')
    {{-- this is bootstrap tag --}}
    <link href="{{ asset('assets/backend/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <style>
        .image_preview {
            width: 100%;
            height: 250px;
            margin-bottom: 12px;
            border-radius: 8px;
            overflow: hidden
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Add New Blog') }}</span>
                </h4>
                <a href="{{ route('instructor.blogs') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>


    <div class="row ">
        <div class="col-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route('instructor.blog.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="mb-3">
                                    <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                                    <input type="text" class="form-control ol-form-control" name="title" id="title" placeholder="{{ get_phrase('Enter blog title') }}" required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label ol-form-label" for="blog_category_id">{{ get_phrase('Category') }}</label>
                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="category_id" id="blog_category_id" required>
                                        <option value="">{{ get_phrase('Select a category') }}</option>
                                        @foreach ($category as $row)
                                            <option value="{{ $row->id }}">{{ $row->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label class="form-label ol-form-label" for="keywords">{{ get_phrase('Keywords') }}</label>
                            <input type="text" name="keywords" class="tagify ol-form-control w-100" data-role="tagsinput">
                            <small class="text-muted">{{ get_phrase('Writing your keyword and hit htw enter button') }}</small>
                        </div>

                        <div class=" mb-3">
                            <label class="form-label ol-form-label" for="summernote-basic">{{ get_phrase('Description') }}</label>
                            <textarea name="description" class="form-control ol-form-control text_editor"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 ">
                                <label class="form-label ol-form-label" for="banner">{{ get_phrase('Blog banner') }}</label>
                                <div class="image_preview">
                                    <img src="{{ get_image() }}" id="preview_banner" alt="blog-banner">
                                </div>
                                <input type="file" name="banner" id="banner" class="form-control image-upload" accept="image/*">
                            </div>

                            <div class="col-md-6  ">
                                <label class="form-label ol-form-label" for="thumbnail">{{ get_phrase('Blog thumbnail') }}</label>
                                <div class="image_preview">
                                    <img src="{{ get_image() }}" id="preview_thumbnail" alt="blog-thumbnail">
                                </div>
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control image-upload" accept="image/*">
                            </div>
                        </div>

                        <div class=" mb-3 mt-3">
                            <label class="form-label ol-form-label">{{ get_phrase('Would you like to designate it as popular?') }}</label>

                            <div class="d-flex gap-4">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" id="mark_yes" value="1" name="is_popular">
                                    <label for="mark_yes">{{ get_phrase('Yes') }}</label>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" id="mark_no" value="0" name="is_popular" checked>
                                    <label for="mark_no">{{ get_phrase('No') }}</label>
                                </div>
                            </div>
                        </div>

                        <div class=" mb-3">
                            <button type="submit" class="ol-btn-primary">{{ get_phrase('Add blog') }}</button>
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
