@extends('layouts.admin')
@push('title', get_phrase('Purchase History'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Purchase History') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">
            <div class="row row-gap-3">
                <div class="col-md-6  pt-2 pt-md-0">
                    @if (count($reports) > 0)
                        <div class="custom-dropdown">
                            <button class="dropdown-header btn ol-btn-light">
                                {{ get_phrase('Export') }}
                                <i class="fi-rr-file-export ms-2"></i>
                            </button>
                            <ul class="dropdown-list">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'payment-history')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <form class="form-inline" action="{{ route('admin.purchase.history') }}" method="get">
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
                    <!-- Table -->
                    @if (count($reports) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive purchase_list" id="purchase_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ get_phrase('#') }}</th>
                                        <th scope="col">{{ get_phrase('User') }}</th>
                                        <th scope="col">{{ get_phrase('Item') }}</th>
                                        <th scope="col">{{ get_phrase('Paid amount') }}</th>
                                        <th scope="col">{{ get_phrase('Payment method') }}</th>
                                        <th scope="col">{{ get_phrase('Purchased date') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Invoice') }}</th>
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
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_img">
                                                        <img class="img-fluid rounded-circle image-45" width="45" height="45" src="{{ get_image($report->photo) }}" />
                                                    </div>
                                                    <div class="ms-1">
                                                        <h4 class="title fs-14px">{{ get_user_info($report->user_id)->name }}</h4>
                                                        <p class="sub-title2 text-12px">{{ get_user_info($report->user_id)->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $item->title }}</h4>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-200px">
                                                    <p>{{ currency($report->amount) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ $report->payment_type }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ date('d-M-Y', strtotime($report->created_at)) }}</p>
                                                </div>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="adminTable-action">
                                                    <a class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip" title="{{ get_phrase('Print') }}" href="{{ route('admin.purchase.history.invoice', $report->id) }}">
                                                        <i class="fi-rr-print"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>

                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{ get_phrase('Total') }} :
                                            {{ currency(App\Models\Payment_history::sum('amount')) }}
                                        </th>
                                        <th></th>
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

        function Export() {
            const element = document.getElementById("purchase_list");
            var clonedElement = element.cloneNode(true);
            $(clonedElement).css("display", "block");

            var opt = {
                margin: 1,
                filename: 'purchase_list_{{ date('y-m-d') }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                }
            };
            html2pdf().set(opt).from(clonedElement).save();
            clonedElement.remove();
        }


        function printableDiv(printableAreaDivId) {
            var printContents = document.getElementById(printableAreaDivId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
