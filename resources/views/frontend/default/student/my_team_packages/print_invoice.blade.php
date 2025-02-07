@extends('layouts.default')
@push('title', get_phrase('Invoice ') . $package->invoice)
@section('content')
    <section class="my-course-content mt-50">
        <div class="profile-banner-area"></div>
        <div class="profile-banner-area-container container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')


                <div class="col-lg-9">
                    <div class="my-panel purchase-history-panel">
                        <div class="invoice mt-5" id="invoice">
                            <div class="top d-flex justify-content-between align-items-center border-1 border-bottom mb-5 pb-5">
                                <div>
                                    <h2><span>{{ get_phrase('Invoice') }} {{ $package->invoice }}</span></h2>
                                    <p class="description">{{ get_phrase('Date ') }} {{ date('d-M-Y', strtotime($package->created_at)) }}</p>
                                </div>
                                <div>
                                    <img src="/projects/academy/1.3/public/uploads/dark_logo/placeholder/placeholder.png" alt="system logo" class="object-fit-cover rounded" width="200px">
                                </div>
                            </div>

                            <div class="billing-area">
                                <div class="table-responsive">
                                    <table class="eTable table">
                                        <thead>
                                            <tr>
                                                <th>{{ get_phrase('Item') }}</th>
                                                <th>{{ get_phrase('Date') }}</th>
                                                <th>{{ get_phrase('Method') }}</th>
                                                <th>{{ get_phrase('Price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $package->title }}</td>
                                                <td> {{ date('d-M-Y', strtotime($package->created_at)) }} </td>
                                                <td class="text-capitalize">{{ $package->payment_method }}</td>
                                                <td>{{ currency(number_format($package->price, 2)) }}</td>
                                            </tr>

                                            <tr>
                                                <td>{{ get_phrase('Billed to :') }}</td>
                                                <td>{{ $package->user_name }}</td>
                                                <td>{{ get_phrase('Total : ') }}</td>
                                                <td>{{ currency(number_format($package->price, 2)) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end mt-3 gap-3">
                        <a class="eBtn gradient" href="{{ route('my.team.packages.details', $package->slug) }}">{{ get_phrase('Back') }}</a>
                        <a class="eBtn gradient" id="print" href="javascript:void(0);" onclick="printableDiv('invoice')">{{ get_phrase('Print') }}</a>
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
