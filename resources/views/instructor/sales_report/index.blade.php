@extends('layouts.instructor')
@push('title', get_phrase('Sales report'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- start page title -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Sales report') }}
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mt-3 mb-4">
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            @if (count($sales_report) > 0)
                                <div class="custom-dropdown ms-2">
                                    <button class="dropdown-header btn ol-btn-light">
                                        {{ get_phrase('Export') }}
                                        <i class="fi-rr-file-export ms-2"></i>
                                    </button>
                                    <ul class="dropdown-list">
                                        <li>
                                            <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.print-table', 'sales-report')"><i class="fi-rr-file-pdf"></i>
                                                {{ get_phrase('PDF') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <form class="form-inline" action="{{ route('instructor.sales.report') }}" method="get">
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

                    <!-- Table -->
                    @if (count($sales_report) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($sales_report) . ' ' . get_phrase('of') . ' ' . $sales_report->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th>{{ get_phrase('#') }}</th>
                                        <th>{{ get_phrase('Course name') }}</th>
                                        <th>{{ get_phrase('Enrollment') }}</th>
                                        <th>{{ get_phrase('Instructor revenue') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sales_report as $key => $report)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">
                                                            <a href="{{ route('course.details', $report->course_slug) }}">
                                                                {{ $report->course_title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title text-12px">
                                                    <p>
                                                        {{ get_phrase('Enrolled user : ') }}{{ $report->student_name }}
                                                    </p>
                                                    <p>
                                                        {{ get_phrase('Enroled date : ') }}{{ date('d-M-Y h:i A', strtotime($report->created_at)) }}
                                                    </p>
                                                    @if ($report->coupon != '')
                                                        <p>
                                                            {{ get_phrase('Coupon applied : ') }}
                                                            {{ $report->coupon }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title text-12px">
                                                    <p>{{ get_phrase('Revenue : ') }}{{ currency($report->instructor_revenue) }}</p>
                                                    <p>{{ get_phrase('Course price : ') }}{{ currency($report->amount) }}</p>
                                                </div>
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
                    @if (count($sales_report) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($sales_report) . ' ' . get_phrase('of') . ' ' . $sales_report->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $sales_report->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script type="text/javascript">
            "use strict";
            $(document).ready(function() {
                $('#filter-report').on('submit', function(e) {
                    e.preventDefault();

                    let search = $('input[name = "search"]').val();
                    let date = $('input[name = "eDateRange"]').val();

                    let url = "{{ route('instructor.sales.report') }}";
                    if (search !== '' && date !== '') {
                        url += '?search=' + encodeURIComponent(search) + '&date=' + encodeURIComponent(date);
                    } else if (search !== '') {
                        url += '?search=' + encodeURIComponent(search);
                    } else if (date !== '') {
                        url += '?date=' + encodeURIComponent(date);
                    }
                    window.location.href = url;
                });
            });
        </script>
    @endpush
