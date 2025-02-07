
@extends('layouts.admin')
@push('title', get_phrase('Knowledge_base'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Add Article') }}</span>
                </h4>
                <a href="{{route('admin.articles',['id'=> $articleTitle->id])}}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="row ">
        <div class="col-md-8">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <h5 class="pb-5">{{$articleTitle->title}}</n5>
                    <form action="{{route('admin.articles.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }}</label>
                            <input type="text" class="form-control ol-form-control" name="title" id="title"
                                placeholder="{{ get_phrase('Enter Article title') }}" required>
                        </div>

                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="summernote-basic">{{ get_phrase('Description') }}</label>
                            <textarea name="description" class="form-control ol-form-control text_editor"></textarea>
                        </div>
                        <input type="hidden" name='topick_id' value="{{$articleTitle->id}}">
                        <div class="fpb-7 mb-3">
                            <button type="submit" class="ol-btn-primary">{{ get_phrase('Add Article') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

    <script type="text/javascript">
        "use strict";
        
        function stopProp(event) {
            event.stopPropagation();
        }
    </script>
@endpush 