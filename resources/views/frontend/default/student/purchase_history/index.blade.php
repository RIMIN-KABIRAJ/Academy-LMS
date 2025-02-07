@extends('layouts.default')
@push('title', get_phrase('Purchase History'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <section class="wishlist-content">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9">
                    <h4 class="g-title mb-5">{{ get_phrase('Payment History') }}</h4>
                    <div class="my-panel purchase-history-panel">


                        @if ($payments->count() > 0)
                            <div class="table-responsive">
                                <table class="table eTable">
                                    <thead>
                                        <tr>
                                            <th>{{ get_phrase('Course Name') }}</th>
                                            <th>{{ get_phrase('Date') }}</th>
                                            <th>{{ get_phrase('Payment Method') }}</th>
                                            <th>{{ get_phrase('Price') }}</th>
                                            <th>{{ get_phrase('Invoice') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($payments as $payment)
                                            <tr>
                                                <td>{{ $payment->course_title }}</td>
                                                <td>{{ date('Y-m-d', strtotime($payment->created_at)) }}</td>
                                                <td>{{ ucfirst($payment->payment_type) }}</td>
                                                <td>{{ currency($payment->amount) }}</td>
                                                <td>
                                                    <a href="{{ route('invoice', $payment->id) }}"
                                                        class="d-flex align-items-center justify-content-center btn btn-primary text-18 text-white py-3" data-bs-toggle="tooltip" data-bs-title="{{get_phrase('Print Invoice')}}">
                                                        <i class="fi fi-rr-print d-inline-flex"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="row bg-white radius-10 mx-2">
                                <div class="com-md-12">
                                    @include('frontend.default.empty')
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if (count($payments) > 0)
                <div class="entry-pagination">
                    <nav aria-label="Page navigation example">
                        {{ $payments->links() }}
                    </nav>
                </div>
            @endif
            <!-- Pagination -->
        </div>
    </section>
    <!------------ purchase history area End  ------------>
@endsection
@push('js')@endpush
