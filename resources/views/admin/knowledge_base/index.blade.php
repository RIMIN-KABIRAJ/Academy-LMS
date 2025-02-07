@extends('layouts.admin')
@push('title', get_phrase('Knowledge_base'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Knowledge base') }}
                </h4>

                <a onclick="ajaxModal('{{ route('modal', ['admin.knowledge_base.create']) }}', '{{ get_phrase('Add knowledge base') }}')" href="#" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add Knowledge base') }}</span>
                </a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 ">
            <div id="accordion" class="custom-accordion mb-4">
                <div class="ol-card p-20px">
                    <div class="ol-card-body">

                        <div class="row print-d-none mb-3 mt-3 row-gap-3">
                            <div class="col-md-6  pt-2 pt-md-0">
                                <div class="custom-dropdown">
                                    <button class="dropdown-header btn ol-btn-light">
                                        {{ get_phrase('Export') }}
                                        <i class="fi-rr-file-export ms-2"></i>
                                    </button>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'blog-list')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.knowledge.base') }}" method="get">
                                    <div class="row row-gap-3">
                                        <div class="col-md-9">
                                            <div class="search-input">
                                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search Title') }}" class="ol-form-control form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">{{ get_phrase('Search') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <ul class="ol-my-accordion">
                            @if (count($datas) > 0)
                            <div class="table-responsive course_list overflow-auto overflow-auto " id="course_list ">
                                <table class="eTable eTable-2 print-table table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">{{ get_phrase('Title') }}</th>
                                            <th scope="col" class="print-d-none text-center">{{ get_phrase('Total Articles') }}</th>
                                            <th scope="col" class="print-d-none text-center">{{ get_phrase('Options') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $key => $data)
                                            <tr>
                                                <th scope="row">
                                                    <p class="row-number">{{ ++$key }}</p>
                                                </th>
                                                <td>
                                                    <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                        <div class="dAdmin_profile_name">
                                                            <h4 class="title fs-14px">
                                                                <a href="#">{{ ucfirst($data->title) }}</a>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="print-d-none text-center">
                                                    @php
                                                        $total = App\Models\Knowledge_base_topick::where('knowledge_base_id', $data->id)->get();
                                                    @endphp
                                                    {{count($total)}}
                                                </td>

                                                <td class="print-d-none ">
                                                    <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent d-flex justify-content-center">
                                                        <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="fi-rr-menu-dots-vertical"></span>
                                                        </button>

                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="{{route('admin.articles', ['id' => $data->id])}}">{{ get_phrase(' Articles') }}</a>
                                                            </li>
                                                            <li>
                                                                <a onclick="ajaxModal('{{ route('modal', ['admin.knowledge_base.edit', 'id' => $data->id]) }}', '{{ get_phrase('Edit Newsletter') }}')" data-bs-toggle="tooltip" title="{{ get_phrase('Edit') }}" href="#">{{ get_phrase('Edit') }}</a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" onclick="confirmModal('{{ route('admin.knowledge.base.delete', $data->id) }}')" href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                                @if (count($datas) > 0)
                                    <div
                                        class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                        <p class="admin-tInfo">
                                            {{ get_phrase('Showing') . ' ' . count($datas) . ' ' . get_phrase('of') . ' ' . $datas->total() . ' ' . get_phrase('data') }}
                                        </p>
                                        {{ $datas->links() }}
                                    </div>
                                @endif
                            @else
                                @include('admin.no_data')
                            @endif
                        </ul>

                    </div>
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
