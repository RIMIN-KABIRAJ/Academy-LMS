@extends('layouts.admin')
@push('title', get_phrase('Offline payments'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body px-20px my-3 py-4">
            <div class="d-flex align-items-center justify-content-between flex-md-nowrap flex-wrap gap-3">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Offline payments') }}</span>
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none row-gap-3 mb-3 mt-3">
                        <div class="col-md-6 d-flex align-items-center gap-3">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'offline-payments')"><i class="fi-rr-file-pdf"></i>
                                            {{ get_phrase('PDF') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="custom-dropdown dropdown-filter @if (!isset($_GET) || (isset($_GET) && count($_GET) == 0))  @endif">
                                <button class="dropdown-header btn ol-btn-light">
                                    <i class="fi-rr-filter me-2"></i>
                                    {{ get_phrase('Filter') }}

                                    @if (isset($_GET) && count($_GET))
                                        <span class="text-12px">
                                            ({{ count($_GET) }})
                                        </span>
                                    @endif
                                </button>
                                <ul class="dropdown-list w-250px">
                                    <li>
                                        <form id="filter-dropdown" action="{{ route('admin.offline.payments') }}" method="get">
                                            <div class="filter-option d-flex flex-column gap-3">
                                                <div>
                                                    <label for="eDataList" class="form-label ol-form-label">{{ get_phrase('Category') }}</label>
                                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status" data-placeholder="Type to search...">
                                                        <option value="all">{{ get_phrase('All') }}</option>
                                                        <option value="pending" @if (isset($_GET['status']) && $_GET['status'] == 'pending') selected @endif>{{ get_phrase('Pending') }}</option>
                                                        <option value="approved" @if (isset($_GET['status']) && $_GET['status'] == 'approved') selected @endif>{{ get_phrase('Approved') }}</option>
                                                        <option value="suspended" @if (isset($_GET['status']) && $_GET['status'] == 'suspended') selected @endif>{{ get_phrase('Suspended') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="filter-button d-flex justify-content-end align-items-center mt-3">
                                                <button type="submit" class="ol-btn-primary">{{ get_phrase('Apply') }}</button>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                            @if (isset($_GET) && count($_GET) > 0)
                                <a href="{{ route('admin.offline.payments') }}" class="me-2" data-bs-toggle="tooltip" title="{{ get_phrase('Clear') }}"><iclass="fi-rr-cross-circle"></iclass=></a>
                            @endif
                        </div>

                        <div class="col-md-6">

                        </div>
                    </div>

                    <!-- Table -->
                    @if (count($payments) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center gr-15 flex-wrap">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($payments) . ' ' . get_phrase('of') . ' ' . $payments->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive course_list" id="course_list">
                            <table class="eTable eTable-2 print-table table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('User') }}</th>
                                        <th scope="col">{{ get_phrase('Items') }}</th>
                                        <th scope="col">{{ get_phrase('Total') }}</th>
                                        <th scope="col">{{ get_phrase('Issue date') }}</th>
                                        <th scope="col">{{ get_phrase('Payment info') }}</th>
                                        <th scope="col">{{ get_phrase('Status') }}</th>
                                        <th scope="col" class="print-d-none">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $key => $payment)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">
                                                            {{ get_user_info($payment->user_id)->name }}
                                                        </h4>
                                                        <p class="sub-title text-12px">{{ get_user_info($payment->user_id)->email }}</p>
                                                        <p class="sub-title text-12px">{{get_phrase('Phone')}}: {{ get_user_info($payment->user_id)->phone }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_name">
                                                        @if ($payment->item_type == 'course')
                                                            @foreach (App\Models\Course::whereIn('id', json_decode($payment->items, true))->get() as $course)
                                                                <p class="sub-title text-12px">
                                                                    <a href="{{ route('course.details', slugify($course->title)) }}" class="text-muted me-3">{{ $course->title }} </a>
                                                                </p>
                                                            @endforeach
                                                        @endif

                                                        @if ($payment->item_type == 'bootcamp')
                                                            @foreach (App\Models\Bootcamp::whereIn('id', json_decode($payment->items, true))->get() as $bootcamp)
                                                                <p class="sub-title text-12px">
                                                                    <a href="{{ route('bootcamp.details', ['slug' => slugify($bootcamp->title)]) }}" class="text-muted me-3">{{ $bootcamp->title }} </a>
                                                                </p>
                                                            @endforeach
                                                        @endif

                                                        @if ($payment->item_type == 'package')
                                                            @foreach (App\Models\TeamTrainingPackage::whereIn('id', json_decode($payment->items, true))->get() as $package)
                                                                <p class="sub-title text-12px">
                                                                    <a href="{{ route('team.package.details', ['slug' => $package->slug]) }}" class="text-muted me-3">{{ $package->title }} </a>
                                                                </p>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title2 text-12px">
                                                    {{ currency($payment->total_amount) }}
                                                </div>
                                            </td>

                                            <td>
                                                <div class="sub-title2 text-12px">
                                                    <p>{{ date('d-M-y', strtotime($payment->created_at)) }}</p>
                                                </div>
                                            </td>

                                            <td>
                                                <a class="dropdown-item btn ol-btn-primary px-2 py-1" href="{{ route('admin.offline.payment.doc', $payment->id) }}"><i class="fi-rr-cloud-download"></i> {{ get_phrase('Download') }}</a>
                                            </td>

                                            <td>
                                                @if ($payment->status == 1)
                                                    <span class="badge bg-success">{{ get_phrase('Accepted') }}</span>
                                                @elseif($payment->status == 2)
                                                    <span class="badge bg-danger">{{ get_phrase('Suspended') }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ get_phrase('Pending') }}</span>
                                                @endif
                                            </td>

                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('admin.offline.payment.doc', $payment->id) }}">{{ get_phrase('Download') }}</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="{{ route('admin.offline.payment.accept', $payment->id) }}">{{ get_phrase('Accept') }}</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#" onclick="confirmModal('{{ route('admin.offline.payment.decline', $payment->id) }}')">{{ get_phrase('Decline') }}</a>
                                                        </li>
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
                    @if (count($payments) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center gr-15 flex-wrap">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($payments) . ' ' . get_phrase('of') . ' ' . $payments->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection()
