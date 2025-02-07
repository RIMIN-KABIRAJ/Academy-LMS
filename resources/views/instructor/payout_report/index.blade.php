@extends('layouts.instructor')
@push('title', get_phrase('Payout report'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- start page title -->

    <div class="ol-card radius-8px">
        <div class="ol-card-body py-12px px-20px my-3">
            <div class="d-flex align-items-center justify-content-between flex-md-nowrap flex-wrap gap-3">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Payouts') }}
                </h4>
                @if ($payout_request)
                    <a onclick="confirmModal('{{ route('instructor.payout.delete', $payout_request->id) }}')" href="javascript:void(0)" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                        <span class="fi-rr-minus"></span>
                        {{ get_phrase('Delete request') }}</a>
                @else
                    <a href="#" onclick="ajaxModal('{{ route('modal', ['instructor.payout_report.withdrawal']) }}', '{{ get_phrase('Request a new withdrawal') }}')" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                        <span class="fi-rr-plus"></span>
                        <span>{{ get_phrase('Request withdrawal') }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="row print-d-none">
        <div class="col-12 mt-3">
            <div class="row g-2 g-sm-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-3 mb-3">
                <div class="col">
                    <div class="ol-card card-hover h-100">
                        <div class="ol-card-body py-12px px-3">
                            <div class="d-flex align-items-center cg-12px">
                                <div class="ol-card-icon d-inline-flex">
                                    <span class="icon fi fi-rr-sack-dollar fs-2 d-inline-flex"></span>
                                </div>
                                <div>
                                    <h6 class="title fs-14px mb-1">{{ get_phrase('Available') }}</h6>
                                    <p class="sub-title fs-14px fw-semibold">{{ currency(number_format($balance, 2)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="ol-card card-hover h-100">
                        <div class="ol-card-body py-12px px-3">
                            <div class="d-flex align-items-center cg-12px">
                                <div class="ol-card-icon d-inline-flex">
                                    <span class="icon fi fi-rr-sack-dollar fs-2 d-inline-flex"></span>
                                </div>
                                <div>
                                    <h6 class="title fs-14px mb-1">{{ get_phrase('Total payout') }}</h6>
                                    <p class="sub-title fs-14px fw-semibold">{{ currency(number_format($total_payout, 2)) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="ol-card card-hover h-100">
                        <div class="ol-card-body py-12px px-3">
                            <div class="d-flex align-items-center cg-12px">
                                <div class="ol-card-icon d-inline-flex">
                                    <span class="icon fi fi-rr-sack-dollar fs-2 d-inline-flex"></span>
                                </div>
                                <div>
                                    <h6 class="title fs-14px mb-1">{{ get_phrase('Requested') }}</h6>
                                    <p class="sub-title fs-14px fw-semibold">
                                        {{ currency(number_format($payout_request->amount ?? 0, 2)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-4 mt-3">
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            @if (count($payout_reports))
                                <div class="custom-dropdown ms-2">
                                    <button class="dropdown-header btn ol-btn-light">
                                        {{ get_phrase('Export') }}
                                        <i class="fi-rr-file-export ms-2"></i>
                                    </button>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.print-table', 'payout-reports')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <form class="form-inline" action="{{ route('instructor.payout.reports') }}" method="get">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="position-relative position-relative mb-3">
                                            <input type="text" class="form-control ol-form-control daterangepicker w-100" name="eDateRange"value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (count($payout_reports))
                        <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($payout_reports) . ' ' . get_phrase('of') . ' ' . $payout_reports->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="eTable eTable-2 print-table table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Payout amount') }}</th>
                                        <th>{{ get_phrase('Payment type') }}</th>
                                        <th>{{ get_phrase('Date processed') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payout_reports as $key => $row)
                                        <tr class="gradeU">
                                            <td> {{ ++$key }}</td>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">
                                                            {{ currency(number_format($row->amount, 2)) }}
                                                        </h4>
                                                        <p>
                                                            {{ date('D, d M Y', strtotime($row->created_at)) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($row->status == 0)
                                                    <p class="badge bg-danger">{{ get_phrase('Pending') }}</p>
                                                @endif
                                                {{ ucfirst($row->payment_type) }}
                                            </td>
                                            <td>
                                                @if ($row->status == 0)
                                                    <p class="badge bg-danger">{{ get_phrase('Pending') }}</p>
                                                @else
                                                    {{ date('D, d M Y', strtotime($row->updated_at)) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('instructor.no_data')
                    @endif
                    <!-- Data info and Pagination -->
                    @if (count($payout_reports) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($payout_reports) . ' ' . get_phrase('of') . ' ' . $payout_reports->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $payout_reports->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script type="text/javascript">
            function update_date_range() {
                var x = $("#selectedValue").html();
                $("#date_range").val(x);
            }
        </script>
    @endpush
