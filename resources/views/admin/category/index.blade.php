@extends('layouts.admin')

@push('title', get_phrase('Categories'))

@push('meta')
@endpush

@push('css')
@endpush



@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('All Category') }} <span class="text-muted">({{ $categories->count() }})</span>
                </h4>

                <a onclick="ajaxModal('{{ route('modal', ['admin.category.create', 'parent_id' => 0]) }}', '{{ get_phrase('Add new category') }}')" href="#" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new category') }}</span>
                </a>
            </div>
        </div>
    </div>


    <div class="row g-4 all-category-list">
        @foreach ($categories as $category)
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="ol-card category-card radious-10px h-100">
                    <img src="{{ get_image($category->thumbnail) }}" class="card-img-top" alt="...">
                    <h6 class="title fs-14px mb-12px px-3 pt-3 d-flex align-baseline">
                        <i class="me-1 {{ $category->icon }}"></i>
                        {{ $category->title }} <span class="text-muted d-inline-block ms-auto">({{ $category->childs->count() }})</span>
                    </h6>
                    <div class="ol-card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($category->childs as $child_category)
                                <li class="list-group-item text-muted">
                                    <div class="row">
                                        <div class="col-auto">
                                            <i class="{{ $child_category->icon }}"></i> <span class="text-12px">{{ $child_category->title }}</span>
                                        </div>
                                        <div class="col-auto ms-auto d-flex subcategory-actions">
                                            <a onclick="ajaxModal('{{ route('modal', ['admin.category.edit', 'id' => $child_category->id]) }}', '{{ get_phrase('Edit category') }}')" class="mx-1" data-bs-toggle="tooltip" title="{{ get_phrase('Edit') }}" href="#"><i class="fi fi-rr-pen-clip"></i></a>
                                            <a onclick="confirmModal('{{ route('admin.category.delete', $child_category->id) }}')" class="mx-1" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" href="#"><i class="fi fi-rr-trash"></i></a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="category-footer ol-card-body text-center py-1">
                        <a onclick="ajaxModal('{{ route('modal', ['admin.category.create', 'parent_id' => $category->id]) }}', '{{ get_phrase('Add new category') }}')" href="#" class="btn text-12px fw-600"><i class="fi fi-rr-plus"></i></i> {{ get_phrase('Add') }}</a>
                        <a href="#" onclick="ajaxModal('{{ route('modal', ['admin.category.edit', 'id' => $category->id]) }}', '{{ get_phrase('Edit category') }}')" class="btn text-12px fw-600"><i class="fi fi-rr-pen-clip"></i> {{ get_phrase('Edit') }}</a>
                        <a href="#" onclick="confirmModal('{{ route('admin.category.delete', $category->id) }}')" class="btn text-12px fw-600"><i class="fi-rr-trash"></i>
                            {{ get_phrase('Delete') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
