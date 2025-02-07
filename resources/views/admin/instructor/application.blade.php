@extends('layouts.admin')
@push('title', get_phrase('Application'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $pendings = App\Models\Application::where('status', 0)->paginate(10);
        $approved = App\Models\Application::where('status', 1)->paginate(10);
    @endphp
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Instructor Applicationss') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">
            <ul class="nav nav-tabs eNav-Tabs-custom eTab" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="cHome-tab" data-bs-toggle="tab" data-bs-target="#cHome" type="button" role="tab" aria-controls="cHome"
                        aria-selected="true">
                        {{ get_phrase('Pending applications') }}
                        <span></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cProfile-tab" data-bs-toggle="tab" data-bs-target="#cProfile" type="button" role="tab" aria-controls="cProfile"
                        aria-selected="false">
                        {{ get_phrase('Approved applications') }}
                        <span></span>
                    </button>
                </li>
            </ul>
            <div class="tab-content eNav-Tabs-content mt-4" id="myTabContent">
                <div class="tab-pane fade show active" id="cHome" role="tabpanel" aria-labelledby="cHome-tab">
                    @if (count($pendings) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($pendings) . ' ' . get_phrase('of') . ' ' . $pendings->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table id="pending-application" class="table eTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Name') }}</th>
                                        <th>{{ get_phrase('Document') }}</th>
                                        <th>{{ get_phrase('Details') }}</th>
                                        <th>{{ get_phrase('Status') }}</th>
                                        <th>{{ get_phrase('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pendings as $key => $pending)
                                        <tr class="gradeU">
                                            <td>{{ ++$key }}</td>
                                            <td>{{ get_user_info($pending->user_id)->name }}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn ol-btn-primary"
                                                    onclick="ajaxModal('{{ route('modal', ['admin.instructor.show_document', 'id' => $pending->id]) }}', '{{ get_phrase('Applicant details') }}')">
                                                    <i class="fa fa-info-circle"></i>
                                                    {{ get_phrase('Application details') }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.instructor.application.download', ['id' => $pending->id]) }}" data-bs-toggle="tooltip" title="{{ get_phrase('Download') }}" class="btn ol-btn-light ol-icon-btn">
                                                    <span class="fi-rr-download"></span></a>
                                            </td>
                                            <td>
                                                @if ($pending->status == 0)
                                                    <div class="badge bg-danger">
                                                        {{ get_phrase('Pending') }}
                                                    </div>
                                                @else
                                                    <div class="badge bg-success">
                                                        {{ get_phrase('Approved') }}
                                                    </div>
                                                @endif

                                            </td>
                                            <td>
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="confirmModal('{{ route('admin.instructor.application.approve', $pending->id) }}')">{{ get_phrase('Approve') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="confirmModal('{{ route('admin.instructor.application.delete', $pending->id) }}')">{{ get_phrase('Delete') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (count($pendings))
                            <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                <p class="admin-tInfo">
                                    {{ get_phrase('Showing') . ' ' . count($pendings) . ' ' . get_phrase('of') . ' ' . $pendings->total() . ' ' . get_phrase('data') }}
                                </p>
                            </div>
                            {{ $pendings->links() }}
                        @endif
                    @endif
                </div>
                <div class="tab-pane fade" id="cProfile" role="tabpanel" aria-labelledby="cProfile-tab">
                    @if (count($approved))
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($approved) . ' ' . get_phrase('of') . ' ' . $approved->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table id="approved-application" class="table eTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Name') }}</th>
                                        <th>{{ get_phrase('Document') }}</th>
                                        <th>{{ get_phrase('Details') }}</th>
                                        <th>{{ get_phrase('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approved as $key => $approve)
                                        <tr class="gradeU">
                                            <td>{{ ++$key }}</td>
                                            <td>{{ get_user_info($approve->user_id)->name }}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn ol-btn-primary"
                                                    onclick="ajaxModal('{{ route('modal', ['admin.instructor.show_document', 'id' => $approve->id]) }}', '{{ get_phrase('Applicant details') }}')">
                                                    <i class="fa fa-info-circle"></i>
                                                    {{ get_phrase('Application details') }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.instructor.application.download', ['id' => $approve->id]) }}" class="btn ol-btn-light ol-icon-btn"><span
                                                        class="fi-rr-download"></span></a>
                                            </td>
                                            <td>
                                                @if ($approve->status == 0)
                                                    <div class="badge bg-danger">
                                                        {{ get_phrase('Pending') }}
                                                    </div>
                                                @else
                                                    <div class="badge bg-success">
                                                        {{ get_phrase('Approved') }}
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if (count($approved))
                            <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                <p class="admin-tInfo">
                                    {{ get_phrase('Showing') . ' ' . count($approved) . ' ' . get_phrase('of') . ' ' . $approved->total() . ' ' . get_phrase('data') }}
                                </p>
                            </div>
                            {{ $approved->links() }}
                        @endif
                    @endif
                </div>
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
@endsection
@push('js')
    <script type="text/javascript">
        "use strict";

        $(document).ready(function() {
            initDataTable(['#pending-application', '#approved-application']);
        });
    </script>
@endpush
