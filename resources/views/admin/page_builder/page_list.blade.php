@extends('layouts.admin')
@push('title', get_phrase('Page Builder'))
@push('meta')@endpush
@push('css')
<style>
    .no-disabled:disabled{
        opacity: 1;
    }
</style>
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

    <div class="row">
        <div class="col-md-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <table class="table eTable table-hover">
                        <thead>
                            <tr>
                                <th scope="col">{{ get_phrase('#') }}</th>
                                <th scope="col">{{ get_phrase('Page Name') }}</th>
                                <th scope="col">{{ get_phrase('Status') }}</th>
                                <th scope="col">{{ get_phrase('Action') }}</th>
                            </tr>
                        </thead>

                        @foreach (App\Models\Builder_page::get() as $key => $page)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $page->name }}</td>
                                <td>
                                    <div class="eSwitches">
                                        <div class="form-check form-switch">
                                            <input
                                                onchange="actionTo('{{ route('admin.page.status', ['id' => $page->id]) }}'); pageSwitcher(this);"
                                                class="form-check-input form-switch-medium no-disabled" name="home_page" type="checkbox" @if ($page->status == 1) checked disabled @endif>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($page->is_permanent == 0)
                                        <a href="{{ route('admin.page.preview', $page->id) }}" target="_blank"
                                            class="btn ol-btn-outline-secondary ol-btn-sm">{{ get_phrase('Preview') }}</a>
                                        <a href="{{ route('admin.page.layout.edit', ['id' => $page->id]) }}"
                                            class="btn ol-btn-outline-secondary ol-btn-sm">{{ get_phrase('Edit Layout') }}</a>
                                        <a class="btn ol-btn-outline-secondary ol-btn-sm"
                                            onclick="showRightModal('{{ route('view', ['path' => 'admin.page_builder.page_edit', 'id' => $page->id]) }}', '{{ get_phrase('Edit Page') }}')"
                                            href="#" class="btn text-secondary">{{ get_phrase('Edit') }}</a>
                                        <a class="btn ol-btn-outline-secondary ol-btn-sm" onclick="confirmModal('{{ route('admin.page.delete', ['id' => $page->id]) }}')"
                                            href="#" class="btn text-danger">{{ get_phrase('Delete') }}</a>
                                    @endif
                                    @if ($page->edit_home_id == 1)
                                        <a class="btn ol-btn-outline-secondary ol-btn-sm"
                                            onclick="showRightModal('{{ route('view', ['path' => 'admin.setting.home_edit.home_edit', 'id' => $page->id]) }}', '{{ get_phrase('Edit Home Page') }}')"
                                            href="#" class="btn text-secondary">{{ get_phrase('Edit Home') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";

        function pageSwitcher(elem){
            $('.form-switch-medium').not(elem).prop('disabled', false);
            $('.form-switch-medium').not(elem).prop('checked', false);

            setTimeout(() => {
                $(elem).prop('checked', true);
                $(elem).prop('disabled', true);
            }, 200);
        }
    </script>
@endpush
