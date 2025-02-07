@extends('layouts.admin')
@push('title', get_phrase('Blog category'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Blog Category') }}</span>
                </h4>
                <a href="javascript:void(0);"
                    class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px"
                    onclick="ajaxModal('{{ route('modal', ['admin.blog_category.create']) }}', '{{ get_phrase('Add Category') }}')">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new category') }}</span>
                </a>
            </div>
        </div>
    </div>


    @if ($categories->count() > 0)
        <div class="row g-2 g-sm-3 mb-3 row-cols-1 row-colssm-2 row-cols-md-3 row-cols-lg-4">
            @foreach ($categories as $category)
                <div class="col">
                    <div class="ol-card card-hover">
                        <div class="ol-card-body px-20px py-3 d-flex justify-content-between">
                            <div>
                                <p class="title card-title-hover">{{ $category->title }}</p>
                                <p class="sub-title text-12px mt-2">{{ get_phrase('Total number of blog') }} {{ count_blogs_by_category($category->id) }}</p>
                            </div>

                            <div class="dropdown ol-icon-dropdown">
                                <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class=""></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="ajaxModal('{{ route('modal', ['admin.blog_category.edit', 'id' => $category->id]) }}', '{{ get_phrase('Edit Category') }}')">{{ get_phrase('Edit') }}</a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);" onclick="confirmModal('{{ route('admin.blog.category.delete', $category->id) }}')">{{ get_phrase('Delete') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="ol-card">
            <div class="ol-card-body">
                @include('admin.no_data')
            </div>
        </div>
    @endif
@endsection
@push('js')@endpush
