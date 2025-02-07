@extends('layouts.admin')
@push('title', get_phrase('Admin Revenue'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Admin Revenue') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">
            <div class="row mb-3 mt-3 row-gap-3">
                <div class="col-md-6  pt-2 pt-md-0">
                    @if ($reports->count() > 0)
                        <div class="custom-dropdown">
                            <button class="dropdown-header btn ol-btn-light">
                                {{ get_phrase('Export') }}
                                <i class="fi-rr-file-export ms-2"></i>
                            </button>
                            <ul class="dropdown-list">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'admin-revenue')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <form class="form-inline" action="{{ route('admin.revenue') }}" method="get">
                        <div class="row row-gap-3">
                            <div class="col-md-9">
                                <div class="mb-3 position-relative position-relative">
                                    <input type="text" class="form-control ol-form-control daterangepicker w-100" name="eDateRange"value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    @if ($reports->count() > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive enroll_history" id="enroll_history">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ get_phrase('#') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled course') }}</th>
                                        <th scope="col">{{ get_phrase('Total amount') }}</th>
                                        <th scope="col">{{ get_phrase('Admin revenue') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Option') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reports as $key => $report)
                                        @php
                                            if ($report->course_id > 0) {
                                                $item = App\Models\Course::where('id', $report->course_id)->first();
                                            }
                                        @endphp
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $item->title }}</h4>
                                                        <p class="mt-1 fs-12px">{{ get_phrase('Enrolled: ') }}
                                                            {{ date('d-M-Y', strtotime($report->created_at)) }}</p>
                                                        @isset($report->coupon)
                                                            <p>{{ get_phrase('Coupon: ') }}{{ $report->coupon }}</p>
                                                        @endisset
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ currency($report->amount) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ currency($report->admin_revenue) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ date('d-M-Y', strtotime($report->created_at)) }}</p>
                                                </div>
                                            </td>
                                            <td class="print-d-none">
                                                <div class="adminTable-action">
                                                    <button type="button" class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" onclick="confirmModal('{{ route('admin.enroll.history.delete', $report->id) }}')">
                                                        <i class="fi-rr-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>

                                        <th></th>
                                        <th></th>
                                        <th>{{ get_phrase('Total') }} :
                                            {{ currency($reports->sum('amount')) }}
                                        </th>
                                        <th>{{ get_phrase('Total') }} :
                                            {{ currency($reports->sum('instructor_revenue')) }}
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif
                    <!-- Data info and Pagination -->
                    @if (count($reports) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $reports->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript">
        "use strict";

        function update_date_range() {
            var x = $("#selectedValue").html();
            $("#date_range").val(x);
        }
    </script>
@endpush
