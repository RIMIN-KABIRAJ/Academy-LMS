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
                            <li><a href="javascript:void(0)">{{ get_phrase('Invice') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <div class="container p-5">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <h4 class="eDisplay-3">{{ get_phrase('Invoice') }}</h4>
                                <h3 class="eh5 mt-2">#{{ get_phrase('Invoice id') }}: </h3>
                            </div>
                            <div class="">
                                <img src="{{ asset(get_frontend_settings('dark_logo')) }}" alt="">
                            </div>
                        </div>


                        <!-- end row -->

                        <div class="row mt-4">
                            <div class="col-sm-4">
                                <h6>{{ get_phrase('Billed To') }}</h6>
                                <address></address>
                            </div> <!-- end col-->

                            <div class="col-sm-4">
                                <h6>{{ get_phrase('Date Of Issue') }}</h6>
                                <address></address>
                            </div> <!-- end col-->
                            <div class="col-sm-4">
                                <h6>{{ get_phrase('Invoice Total') }}</h6>
                                <address></address>
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
                                                <th>{{ get_phrase('type') }}</th>
                                                <th>{{ get_phrase('Requested amount') }}</th>
                                                <th class="text-right">{{ get_phrase('Total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td>
                                                </td>
                                                <td class="text-right">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-sm-6">

                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="float-right mt-3 mt-sm-0">
                                    <p><b>{{ get_phrase('sub_total') }}:</b> <span class="float-right">{{ get_phrase('Amount') }}</span></p>
                                </div>
                                <div class="clearfix"></div>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

                        <div class="d-print-none mt-4">
                            <div class="text-right">¸
                                <a href="javascript:window.print()" class="btn ol-btn-primary"><i class="mdi mdi-printer"></i>
                                    {{ get_phrase('print') }}</a>
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
@push('js')@endpush
