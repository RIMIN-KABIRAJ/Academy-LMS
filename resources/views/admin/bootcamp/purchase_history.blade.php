@extends('layouts.admin')
@push('title', get_phrase('Purchase History'))

@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Purchase History') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-3 mt-3">
                        <div class="col-md-6 pt-2 pt-md-0">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="downloadPDF('.print-table', 'bootcamp-payment-history')"><i
                                                class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print();"><i
                                                class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    @if (count($purchases) > 0)
                        <div
                            class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($purchases) . ' ' . get_phrase('of') . ' ' . $purchases->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive course_list" id="course_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('User') }}</th>
                                        <th scope="col">{{ get_phrase('Bootcamp') }}</th>
                                        <th scope="col">{{ get_phrase('Price') }}</th>
                                        <th scope="col">{{ get_phrase('Issue date') }}</th>
                                        <th scope="col">{{ get_phrase('Payment method') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchases as $key => $report)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_img">
                                                        <img class="img-fluid rounded-circle image-45" width="40" height="40" src="{{ get_image(get_user_info($report->user_id)->photo) }}">
                                                    </div>
                                                    <div class="ms-1 mt-1">
                                                        <h4 class="title fs-14px">{{ get_user_info($report->user_id)->name }}</h4>
                                                        <p class="sub-title2 text-12px">{{ get_user_info($report->user_id)->email }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title2 text-12px min-w-150px">
                                                    <a
                                                        href="{{ route('bootcamp.details', $report->slug) }}">{{ $report->title }}</a>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title2 text-12px min-w-150px">
                                                    <p>{{ currency(number_format($report->price, 2)) }}</p>
                                                    <p><span>{{ get_phrase('Admin :') }} </span>{{ currency(number_format($report->admin_revenue, 2)) }}</p>
                                                    <p><span>{{ get_phrase('Author :') }} </span>{{ currency(number_format($report->instructor_revenue, 2)) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title2 text-12px">
                                                    <p>{{ date('d-M-y', strtotime($report->purchase_date)) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title2 text-12px text-capitalize">
                                                    <p>{{ $report->payment_method }}</p>
                                                </div>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="sub-title2 text-12px text-capitalize">
                                                    <a href="{{ route('admin.bootcamp.purchase.invoice', $report->id) }}"
                                                        class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                                                        <span>{{ get_phrase('Invoice') }}</span>
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif
                    <!-- Data info and Pagination -->
                    @if (count($purchases) > 0)
                        <div
                            class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($purchases) . ' ' . get_phrase('of') . ' ' . $purchases->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $purchases->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
