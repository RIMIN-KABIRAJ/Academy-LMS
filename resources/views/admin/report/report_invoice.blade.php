@extends('layouts.admin')
@push('title', get_phrase('Invoice'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Invoice') }}
                </h4>

                <a href="{{ route('admin.purchase.history') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row purchase_list" id="purchase_list">
        <div class="col-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <div class="p-5 pt-3">
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div class="">
                                    <h4 class="title fs-18px mt-3">{{ get_phrase('Invoice') }}</h4>
                                    <h3 class="eh5 mt-2">#{{ $report->invoice }}</h3>
                                </div>

                                <h6 class="title fs-18px mt-4">{{ get_phrase('Billed To') }}</h6>
                                <address>
                                    {{ get_user_info($report->user_id)->name }},
                                    {{ get_user_info($report->user_id)->email }}
                                </address>
                            </div> <!-- end col-->

                            <div class="col-auto ms-auto">
                                <div class="d-flex justify-content-between">
                                    <div class="mt-3">
                                        <img width="200px" src="{{ asset(get_frontend_settings('dark_logo')) }}" alt="">

                                        <div class="ps-3 mt-4">
                                            <h6 class="title fs-12px">{{ get_phrase('Issue Date') }}</h6>
                                            <address>
                                                {{ date('d-M-Y', strtotime($report->created_at)) }}
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->

                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4">
                                        <thead>
                                            <tr>
                                                <th>{{ get_phrase('Item') }}</th>
                                                <th>{{ get_phrase('Instructor') }}</th>
                                                <th>{{ get_phrase('Qty/Hr Rate') }}</th>
                                                <th class="text-right">{{ get_phrase('Amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="min-w-250px">
                                                    <b>{{ get_course_info($report->course_id)->title }}</b>
                                                </td>
                                                <td class="min-w-250px">
                                                    <b>{{ course_by_instructor($report->course_id)->name }}</b>
                                                </td>
                                                <td class="min-w-250px">
                                                    1
                                                </td>
                                                <td class="min-w-250px">
                                                    {{ currency($report->amount) }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="min-w-250px">
                                                </td>
                                                <td class="min-w-250px">
                                                </td>
                                                <td class="min-w-250px">
                                                    <p>
                                                        <span>{{ get_phrase('Subtotal') }}</span>
                                                    </p>
                                                    <p>
                                                        <span>{{ get_phrase('Tax') }}</span>
                                                    </p>

                                                    <p>
                                                        <span>{{ get_phrase('Grand total') }}</span>
                                                    </p>
                                                </td>
                                                <td class="min-w-250px">
                                                    <p>
                                                        <span>{{ currency($report->amount) }}</span>
                                                    </p>
                                                    <p>
                                                        <span>{{ currency($report->tax) }}</span>
                                                    </p>

                                                    <p>
                                                        <span>{{ currency($report->amount - $report->tax) }}</span>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->


                        <div class="d-print-none mt-4">
                            <div class="text-right">
                                <a href="javascript:void(0)" onclick="printDiv('purchase_list')" class="btn ol-btn-primary"><i class="fi-rr-print"></i>
                                    {{ get_phrase('Print') }}</a>
                            </div>
                        </div>
                        <!-- end buttons -->
                    </div>

                    <!-- Invoice Logo-->

                </div> <!-- end card-body-->
            </div> <!-- end card -->
        </div> <!-- end col-->
    </div>
@endsection
@push('js')
    <script>
        "use strict";

        function printDiv(divId) {
            var printContents = document.getElementById(divId).outerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
