@extends('layouts.admin')
@push('title', get_phrase('Page Builder'))
@push('meta')@endpush
@push('css')
@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Home Page Builder') }}
                </h4>

                <a onclick="showRightModal('{{ route('view', ['path' => 'admin.page_builder.page_create']) }}', '{{ get_phrase('Create Page') }}')" href="#"
                    class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Create Page') }}</span>
                </a>
            </div>
        </div>
    </div>
@endsection
