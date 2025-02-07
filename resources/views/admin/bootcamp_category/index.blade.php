@extends('layouts.admin')
@push('title', get_phrase('Bootcamp Category'))


@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{ get_phrase('Bootcamp Category') }} <span class="text-muted"></span>
            </h4>

            <a onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_category.create']) }}', '{{ get_phrase('Add new category') }}')" href="#"
                class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
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
                            <p class="sub-title text-12px mt-2">{{ get_phrase('Total bootcamps') }} {{ count_bootcamps_by_category($category->id) }}</p>
                        </div>

                        <div class="dropdown ol-icon-dropdown">
                            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fi-rr-menu-dots-vertical"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="ajaxModal('{{ route('modal', ['admin.bootcamp_category.edit', 'id' => $category->id]) }}', '{{ get_phrase('Edit category') }}')">{{ get_phrase('Edit') }}</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="confirmModal('{{ route('admin.bootcamp.category.delete', $category->id) }}')">{{ get_phrase('Delete') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center flex-wrap gr-15 mb-5">
        <p class="admin-tInfo">
            {{ get_phrase('Showing') . ' ' . count($categories) . ' ' . get_phrase('of') . ' ' . $categories->total() . ' ' . get_phrase('data') }}
        </p>
        {{ $categories->links() }}
    </div>
@else
    <div class="ol-card">
        <div class="ol-card-body">
            @include('admin.no_data')
        </div>
    </div>
@endif
@endsection
