@extends('layouts.admin')
@push('title', get_phrase('Invoice'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="mainSection-title">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
                    <div class="d-flex flex-column">
                        <h4>{{ get_phrase('Invoice') }}</h4>
                        <ul class="d-flex align-items-center eBreadcrumb-2">
                            <li><a href="{{ route('admin.dashboard') }}">{{ get_phrase('Home') }}</a></li>
                            <li><a href="javascript:void(0)">{{ get_phrase('User') }}</a></li>
                            <li><a href="javascript:void(0)">{{ get_phrase('Instructor') }}</a></li>
                            <li><a href="javascript:void(0)">{{ get_phrase('Instructor Payout') }}</a></li>
                            <li><a href="javascript:void(0)">{{ get_phrase('Invice') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row purchase_list" id="purchase_list">
        <div class="col-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <div class="p-5">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <h4 class="eDisplay-3">{{ get_phrase('Invoice') }}</h4>
                                <h3 class="eh5 mt-2">{{ get_phrase('Invoice id') }}: #{{ $invoice_id }}</h3>
                            </div>
                            <div class="">
                                <img src="{{ asset(get_frontend_settings('dark_logo')) }}" alt="">
                            </div>
                        </div>


                        <!-- end row -->

                        <div class="row mt-4">
                            <div class="col-sm-4">
                                <h6>{{ get_phrase('Billed To') }}</h6>
                                <address>
                                    {{ get_user_info($invoice_info->user_id)->name }}
                                    {{ get_user_info($invoice_info->user_id)->email }}
                                </address>
                            </div> <!-- end col-->

                            <div class="col-sm-4">
                                <h6>{{ get_phrase('Date Of Issue') }}</h6>
                                <address>
                                    {{ date('D, d-M-Y', strtotime($invoice_info->created_at)) }}
                                </address>
                            </div> <!-- end col-->
                            <div class="col-sm-4">
                                <h6>{{ get_phrase('Invoice Total') }}</h6>
                                <address>
                                    {{ currency($invoice_info->amount) }}
                                </address>
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mt-4">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ get_phrase('Type') }}</th>
                                                <th>{{ get_phrase('Requested amount') }}</th>
                                                <th class="text-right">{{ get_phrase('Amount') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice_data as $key => $invoices)
                                                <tr>
                                                    <td class="min-w-200px">{{ ++$key }}</td>
                                                    <td class="min-w-250px">
                                                        {{ get_phrase('Withdrawal request') }}
                                                    </td>
                                                    <td class="min-w-250px">
                                                        {{ currency($invoice_info->amount) }}
                                                    </td>
                                                    <td class="min-w-250px">
                                                        {{ currency($invoice_info->amount) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-sm-9">
                                <div class="w-1000 d-flex align-items-end flex-column">
                                    <p>
                                        <span>{{ get_phrase('Subtotal') }}</span>
                                        <span>:{{ currency($invoice_info->amount) }}</span>
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- end row-->

                        <div class="d-print-none mt-4">
                            <div class="text-right">
                                <a href="javascript:void(0)" onclick="printDiv('purchase_list')" class="btn ol-btn-primary"><i
                                        class="fi-rr-print"></i>
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
