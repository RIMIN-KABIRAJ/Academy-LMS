@extends('layouts.admin')
@push('title', get_phrase('Subscriber'))

@section('content')
    <!-- Mani section header and breadcrumb -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    <span>{{ get_phrase('Subscribers') }}</span>
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">

                    <div class="row print-d-none mb-3 mt-3 row-gap-3">
                        <div class="col-md-6 pt-2 pt-md-0">
                            <div class="custom-dropdown">
                                <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button>
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'newsletter-subscribers')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('admin.subscribed_user') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-md-9">
                                        <div class="search-input">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="{{ get_phrase('Search Email') }}" class="ol-form-control form-control" />

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">{{ get_phrase('Search') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (count($subscribers) > 0)
                        <div class="table-responsive">
                            <table id="basic-datatable" class="table eTable print-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ get_phrase('Email') }}</th>
                                        <th>{{ get_phrase('User status') }}</th>
                                        <th class="print-d-none">{{ get_phrase('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $key => $subscriber)
                                        @php
                                            $user_details = App\Models\User::where('email', $subscriber->email)->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $subscriber->email }}</td>
                                            <td>
                                                @if ($user_details)
                                                    <span class="badge bg-success">{{ get_phrase('Registered User') }}</span>
                                                @else
                                                    <span class="badge bg-warning">{{ get_phrase('Not Registered') }}</span>
                                                @endif
                                            </td>

                                            <td class="print-d-none">
                                                <div class="adminTable-action">
                                                    <button type="button" class="btn ol-btn-light ol-icon-btn" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}"
                                                        onclick="confirmModal('{{ route('admin.subscribed_user.delete', $subscriber->id) }}')">
                                                        <i class="fi-rr-trash"></i>
                                                    </button>
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
                </div>
                @if (count($subscribers) > 0)
                    <div
                        class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                        <p class="admin-tInfo">
                            {{ get_phrase('Showing') . ' ' . count($subscribers) . ' ' . get_phrase('of') . ' ' . $subscribers->total() . ' ' . get_phrase('data') }}
                        </p>
                        {{ $subscribers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('js')@endpush
