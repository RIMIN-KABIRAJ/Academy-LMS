@extends('layouts.admin')
@push('title', get_phrase('Manage Pcakages'))

@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body py-12px px-20px my-3">
            <div class="d-flex align-items-center justify-content-between flex-md-nowrap flex-wrap gap-3">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Manage Packages') }}
                </h4>

                <a href="{{ route('admin.team.packages.create') }}"class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add New Package') }}</span>
                </a>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body mb-5 p-3">
                    <div class="row mb-4 mt-3">
                        <div class="col-md-6 col-lg-3 col-xl-6 d-flex align-items-center gap-3">
                            <div class="custom-dropdown ms-2">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="downloadPDF('.print-table', 'package-list')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item export-btn" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-9 col-xl-6 mt-md-0 mt-3">
                            <form action="{{ route('admin.team.packages') }}"method="get">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="row">
                                            @php $search_val = request()->has('search'); @endphp
                                            <div class="search-input flex-grow-1">
                                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search Title') }}" class="ol-form-control form-control" />

                                                @if (request()->has('search'))
                                                    <div class="cancle-search-btn">
                                                        <a href="{{ route('admin.team.packages') }}">
                                                            <i class="fi fi-rr-cross-circle"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">{{ get_phrase('Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @if ($packages->count() > 0)
                                <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($packages) . ' ' . get_phrase('of') . ' ' . $packages->total() . ' ' . get_phrase('data') }}
                                    </p>
                                </div>
                                <div class="table-responsive package_list overflow-auto" id="package_list">
                                    <table class="eTable eTable-2 print-table table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">{{ get_phrase('Title') }}</th>
                                                <th scope="col" class="text-center">{{ get_phrase('Allocation') }}</th>
                                                <th scope="col" class="text-center">{{ get_phrase('Purchases') }}</th>
                                                <th scope="col" class="print-d-none">{{ get_phrase('Status') }}</th>
                                                <th scope="col">{{ get_phrase('Price') }}</th>
                                                <th scope="col" class="print-d-none text-center">{{ get_phrase('Options') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($packages as $key => $package)
                                                <tr>
                                                    <th scope="row">
                                                        <p class="row-number">{{ ++$key }}</p>
                                                    </th>

                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="dAdmin_profile_img">
                                                                <img class="img-fluid rounded-circle image-45" width="40" height="40" src="{{ get_image($package->thumbnail) }}" />
                                                            </div>
                                                            <div class="ms-1 mt-1">
                                                                <h4 class="title fs-14px">
                                                                    <a href="{{ route('admin.team.packages.edit', $package->id) }}">
                                                                        {{ ucfirst($package->title) }}
                                                                    </a>
                                                                </h4>
                                                                <div class="sub-title2 text-12px">
                                                                    <a href="{{ route('course.details', $package->course_slug) }}">{{ $package->course_title }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="sub-title2 text-12px text-center">
                                                            <p>
                                                                {{ $package->allocation }} /
                                                                {{ reserved_team_members($package->id) }}
                                                            </p>

                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="sub-title2 text-12px text-center">
                                                            <p>{{ team_package_purchases($package->id) }}</p>
                                                        </div>
                                                    </td>
                                                    <td class="print-d-none">
                                                        <span class="badge bg-{{ $package->status ? 'active' : 'inactive' }}">{{ get_phrase($package->status ? 'Active' : 'Inactive') }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="dAdmin_info_name min-w-150px">
                                                            @if ($package->pricing_type == 0)
                                                                <p class="eBadge ebg-soft-success">{{ get_phrase('Free') }}
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{ currency(number_format($package->price, 2)) }}
                                                                    <del>{{ currency(number_format($package->course_price * $package->allocation, 2)) }}</del>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="print-d-none text-center">
                                                        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent d-flex justify-content-center">
                                                            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span class="fi-rr-menu-dots-vertical"></span>
                                                            </button>

                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" target="_blank" href="{{ route('team.package.details', $package->slug) }}">{{ get_phrase('Frontend View') }}</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('admin.team.packages.edit', $package->id) }}">{{ get_phrase('Edit') }}</a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" onclick="confirmModal('{{ route('admin.team.packages.duplicate', $package->id) }}')" href="javascript:void(0)">{{ get_phrase('Duplicate') }}</a>
                                                                </li>
                                                                @if ($package->status)
                                                                    <li>
                                                                        <a class="dropdown-item" onclick="confirmModal('{{ route('admin.team.toggle.status', $package->id) }}')" href="javascript:void(0)">{{ get_phrase('Make As Inactive') }}</a>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="dropdown-item" onclick="confirmModal('{{ route('admin.team.toggle.status', $package->id) }}')" href="javascript:void(0)">{{ get_phrase('Make As Active') }}</a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <a class="dropdown-item" onclick="confirmModal('{{ route('admin.team.packages.delete', $package->id) }}')" href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($packages) . ' ' . get_phrase('of') . ' ' . $packages->total() . ' ' . get_phrase('data') }}
                                    </p>
                                    {{ $packages->links() }}
                                </div>
                            @else
                                @include('admin.no_data')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
