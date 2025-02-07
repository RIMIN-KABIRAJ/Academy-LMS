@extends('layouts.admin')
@push('title', get_phrase('Coupon'))
@push('meta')@endpush
@push('css')@endpush


@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Coupon') }}</span>
                </h4>
                <a href="javascript:void(0)" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px" onclick="ajaxModal('{{ route('modal', ['admin.coupon.create']) }}', '{{ get_phrase('Add Coupon') }}')">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add Coupon') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Start Admin area -->
    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-3 mt-3 row-gap-3">
                        <div class="col-md-6 pt-2 pt-md-0">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'coupon-list')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6 mt-3 mt-md-0">
                            <form action="{{ route('admin.coupons') }}" method="get" class="d-flex gap-3 justify-content-end">
                                <div class="search-input flex-grow-1">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search coupon') }}" class="ol-form-control form-control" />

                                </div>
                                <button type="submit" class="btn ol-btn-primary" id="submit-button">{{ get_phrase('Search') }}</button>
                            </form>
                        </div>
                    </div>
                    <!-- Table -->
                    @if (count($coupons) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($coupons) . ' ' . get_phrase('of') . ' ' . $coupons->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive course_list" id="course_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Coupon code') }}</th>
                                        <th scope="col">{{ get_phrase('Discount') }}</th>
                                        <th scope="col">{{ get_phrase('Expiry') }}</th>
                                        <th scope="col">{{ get_phrase('Status') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $coupon)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ ++$key }}</p>
                                            </th>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $coupon->code }}</h4>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p>
                                                        {{ $coupon->discount }}
                                                        {{ get_phrase('%') }}
                                                    </p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p>{{ date('d-M-Y', $coupon->expiry) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p><span class="badge {{ $coupon->status ? 'bg-success' : 'bg-danger' }} text-white">{{ get_phrase($coupon->status ? 'Active' : 'Inactive') }}</span></p>
                                                </div>
                                            </td>

                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#" onclick="confirmModal('{{ route('admin.coupon.status', $coupon->id) }}')">{{ get_phrase($coupon->status ? 'Deactivate' : 'Activate') }}</a></li>
                                                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="ajaxModal('{{ route('modal', ['admin.coupon.edit', 'id' => $coupon->id]) }}', '{{ get_phrase('Edit Coupon') }}')">{{ get_phrase('Edit') }}</a></li>
                                                        <li><a class="dropdown-item" href="javascript:void(0);" onclick="confirmModal('{{ route('admin.coupon.delete', $coupon->id) }}')">{{ get_phrase('Delete') }}</a></li>
                                                    </ul>
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
                    @if (count($coupons) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($coupons) . ' ' . get_phrase('of') . ' ' . $coupons->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $coupons->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Admin area -->
@endsection
@push('js')@endpush
