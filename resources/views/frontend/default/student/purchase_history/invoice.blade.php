@extends('layouts.default')
@push('title', get_phrase('Invoice'))

@section('content')
    <section class="wishlist-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('Invoice') }}</h4>
                    <div class="my-panel purchase-history-panel">
                        <div class="invoice mt-5" id="invoice">
                            <div class="top d-flex justify-content-between align-items-center pb-5 mb-5 border-1 border-bottom">
                                <div>
                                    <h2>
                                        <span>{{ get_phrase('Invoice') }}</span>
                                        <span>#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </h2>
                                    <p class="description">
                                        {{ get_phrase('Date') }}:
                                        {{ date('d-m-Y', strtotime($invoice->created_at)) }}
                                    </p>
                                </div>
                                <div>
                                    <img src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="system logo" class="object-fit-cover rounded" width="200px">
                                </div>
                            </div>

                            <div class="billing-area">
                                <div class="table-responsive">
                                    <table class="table eTable">
                                        <thead>
                                            <tr>
                                                <th>{{ get_phrase('Item') }}</th>
                                                <th>{{ get_phrase('Date of issue') }}</th>
                                                <th>{{ get_phrase('Payment Method') }}</th>
                                                <th>{{ get_phrase('Price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>
                                                        {{ $invoice->course_title }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{ date('d-m-Y', strtotime($invoice->created_at)) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ ucfirst($invoice->payment_type) }}</p>
                                                </td>
                                                <td width="110px">
                                                    <p>{{ currency(number_format($invoice->amount, 2)) }}</p>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <p class="description">{{ get_phrase('Billed to :') }}</p>
                                                </td>
                                                <td>
                                                    <p class="description">{{ auth()->user()->name }}</p>
                                                </td>
                                                <td>
                                                    <p class="description text-dark">{{ get_phrase('Total') }}</p>
                                                </td>
                                                <td width="110px">
                                                    <p>{{ currency(number_format($invoice->amount, 2)) }}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 mt-3">
                        <a class="eBtn gradient" href="{{ route('purchase.history') }}">{{ get_phrase('Back') }}</a>
                        <a class="eBtn gradient" id="print" href="javascript:void(0);" onclick="printableDiv('invoice')">{{ get_phrase('Print') }}</a>
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        "use strict";

        function printableDiv(printableAreaDivId) {
            var printContents = document.getElementById(printableAreaDivId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endpush
