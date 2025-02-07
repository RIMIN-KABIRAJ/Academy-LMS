@extends('layouts.admin')
@push('title', get_phrase('Instructor payout'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Instructor Payout') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">

            <div class="row mt-4">
                <div class="col-md-12">
                    <ul class="nav nav-tabs eNav-Tabs-custom eTab" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(!isset($_GET['eDateRange'])) active @endif" id="cHome-tab" data-bs-toggle="tab" data-bs-target="#cHome" type="button" role="tab" aria-controls="cHome"
                                aria-selected="true">
                                {{ get_phrase('Pending payouts') }}
                                <span></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link @if(isset($_GET['eDateRange'])) show active @endif" id="cProfile-tab" data-bs-toggle="tab" data-bs-target="#cProfile" type="button" role="tab" aria-controls="cProfile"
                                aria-selected="false">
                                {{ get_phrase('Completed payouts') }}
                                <span></span>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content eNav-Tabs-content" id="myTabContent">
                        <div class="tab-pane fade @if(!isset($_GET['eDateRange'])) show active @endif" id="cHome" role="tabpanel" aria-labelledby="cHome-tab">
                            <div class="row print-d-none mt-4 row-gap-3">
                                <div class="col-md-6 pt-2 pt-md-0">
                                    @if (count($instructor_payout_incomplete) > 0)
                                        <div class="custom-dropdown">
                                            <button class="dropdown-header btn ol-btn-light">
                                                {{ get_phrase('Export') }}
                                                <i class="fi-rr-file-export ms-2"></i>
                                            </button>
                                            <ul class="dropdown-list">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'payout-request')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <form class="form-inline" action="{{ route('admin.instructor.payout.filter') }}" method="get">
                                        <div class="row mb-4">
                                            <div class="col-md-9">
                                                <div class="mb-3 position-relative position-relative">
                                                    <input type="text" class="form-control ol-form-control daterangepicker w-100"
                                                        name="eDateRange"value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if (count($instructor_payout_incomplete) > 0)
                                <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($instructor_payout_incomplete) . ' ' . get_phrase('of') . ' ' . $instructor_payout_incomplete->total() . ' ' . get_phrase('data') }}
                                    </p>
                                </div>
                                <div class="table-responsive purchase_list mt-4" id="purchase_list">
                                    <table class="table eTable eTable-2 print-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ get_phrase('Name') }}</th>
                                                <th scope="col">{{ get_phrase('Payout amount') }}</th>
                                                <th scope="col">{{ get_phrase('	Payout date') }}</th>
                                                <th scope="col" class="print-d-none">{{ get_phrase('Option') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($instructor_payout_incomplete as $key => $instructor_payout_incompleted)
                                                <tr>
                                                    <th scope="row">
                                                        <p class="row-number">{{ ++$key }}</p>
                                                    </th>
                                                    <td>
                                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                            <div class="dAdmin_profile_img">
                                                                <img class="img-fluid rounded-circle image-45" width="45" height="45" src="{{ get_image_by_id($instructor_payout_incompleted->user_id) }}" />
                                                            </div>
                                                            <div class="ms-1">
                                                                <h4 class="title fs-14px">{{ get_user_info($instructor_payout_incompleted->user_id)->name }}</h4>
                                                                <p class="sub-title2 text-12px">{{ get_user_info($instructor_payout_incompleted->user_id)->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="dAdmin_info_name min-w-250px mr-50">
                                                            <p>{{ currency($instructor_payout_incompleted->amount) }}
                                                            </p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="dAdmin_info_name min-w-250px">
                                                            <p>{{ date('D, d M Y', strtotime($instructor_payout_incompleted->created_at)) }}
                                                            </p>
                                                        </div>
                                                    </td>

                                                    <td class="print-d-none">
                                                        <form action="{{ route('admin.instructor.payment') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $instructor_payout_incompleted->user_id }}">
                                                            <input type="hidden" name="amount" value="{{ $instructor_payout_incompleted->amount }}">
                                                            <input type="hidden" name="payout_id" value="{{ $instructor_payout_incompleted->id }}">
                                                            <button type="submit" class="btn ol-btn-outline-secondary">
                                                                <i class="fi-rr-credit-card"></i>
                                                                {{ get_phrase('Pay') }}</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th>{{ get_phrase('Total') }} :
                                                    {{ currency(App\Models\Payout::where('status', 0)->sum('amount')) }}
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
                            @if (count($instructor_payout_incomplete) > 0)
                                <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($instructor_payout_incomplete) . ' ' . get_phrase('of') . ' ' . $instructor_payout_incomplete->total() . ' ' . get_phrase('data') }}
                                    </p>
                                    {{ $instructor_payout_incomplete->links() }}
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade @if(isset($_GET['eDateRange'])) show active @endif" id="cProfile" role="tabpanel" aria-labelledby="cProfile-tab">

                            <div class="row print-d-none mt-4 row-gap-3">
                                <div class="col-md-6 pt-2 pt-md-0">
                                    @if (count($instructor_payout_complete) > 0)
                                        <div class="custom-dropdown">
                                            <button class="dropdown-header btn ol-btn-light">
                                                {{ get_phrase('Export') }}
                                                <i class="fi-rr-file-export ms-2"></i>
                                            </button>
                                            <ul class="dropdown-list">
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'accepted-payout')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <form class="form-inline" action="{{ route('admin.instructor.payout.filter') }}" method="get">
                                        <div class="row mb-4">
                                            <div class="col-md-9">
                                                <div class="mb-3 position-relative position-relative">
                                                    <input type="text" class="form-control ol-form-control daterangepicker w-100"
                                                        name="eDateRange"value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            @if (count($instructor_payout_complete) > 0)
                                <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($instructor_payout_complete) . ' ' . get_phrase('of') . ' ' . $instructor_payout_complete->total() . ' ' . get_phrase('data') }}
                                    </p>
                                </div>
                                <div class="table-responsive purchase_list" id="purchase_list">
                                    <table class="table eTable eTable-2 print-table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ get_phrase('Name') }}</th>
                                                <th scope="col">{{ get_phrase('Payout amount') }}</th>
                                                <th scope="col">{{ get_phrase('Payment type') }}</th>
                                                <th scope="col">{{ get_phrase('	Payout date') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($instructor_payout_complete as $key => $instructor_payouts)
                                                <tr>
                                                    <th scope="row">
                                                        <p class="row-number">{{ ++$key }}</p>
                                                    </th>
                                                    <td>
                                                        <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                            <div class="dAdmin_profile_img">
                                                                <img class="img-fluid rounded-circle image-45" width="45" height="45" src="{{ get_image_by_id($instructor_payouts->user_id) }}" />
                                                            </div>
                                                            <div class="ms-1">
                                                                <h4 class="title fs-14px">{{ get_user_info($instructor_payouts->user_id)->name }}</h4>
                                                                <p class="sub-title2 text-12px">{{ get_user_info($instructor_payouts->user_id)->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="dAdmin_info_name min-w-250px">
                                                            <p>{{ currency($instructor_payouts->amount) }}</p>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="dAdmin_info_name min-w-250px">
                                                            @if ($instructor_payouts->status != 0)
                                                                <p> {{ get_phrase('Paid') }} </p>
                                                            @else
                                                                <p> {{ get_phrase('Pending') }} </p>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="dAdmin_info_name min-w-250px">
                                                            <p>{{ date('D, d M Y', strtotime($instructor_payouts->updated_at)) }}
                                                            </p>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>

                                                <th></th>
                                                <th></th>
                                                <th>{{ get_phrase('Total') }} :
                                                    {{ currency(App\Models\Payout::where('status', 1)->sum('amount')) }}
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
                            @if (count($instructor_payout_complete) > 0)
                                <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($instructor_payout_complete) . ' ' . get_phrase('of') . ' ' . $instructor_payout_complete->total() . ' ' . get_phrase('data') }}
                                    </p>
                                    {{ $instructor_payout_complete->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
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
