<div class="tab-pane fade" id="invoice" role="tabpanel" aria-labelledby="invoice-tab" tabindex="0">
    <div class="table-responsive mt-4">
        <table class="eTable table">
            <thead>
                <th scope="col">{{ get_phrase('Package') }}</th>
                <th scope="col">{{ get_phrase('Price') }}</th>
                <th scope="col">{{ get_phrase('Date') }}</th>
                <th scope="col">{{ get_phrase('Method') }}</th>
                <th scope="col">{{ get_phrase('Invoice') }}</th>
            </thead>
            <tbody>
                @foreach ($purchased_packages as $key => $purchased_package)
                    <tr>
                        <td> {{ $purchased_package->title }} </td>
                        <td> {{ currency(number_format($purchased_package->price, 2)) }} </td>
                        <td> {{ date('d-M-Y', strtotime($purchased_package->created_at)) }} </td>
                        <td class="text-capitalize"> {{ $purchased_package->payment_method }} </td>
                        <td>
                            <a href="{{ route('team.package.invoice', $purchased_package->id) }}" class="d-flex align-items-center justify-content-center btn btn-primary text-18 py-3 text-white">
                                <i class="fi fi-rr-print d-inline-flex"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
