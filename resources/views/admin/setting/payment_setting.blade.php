@extends('layouts.admin')
@push('title', get_phrase('Payment setting'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $System_currencies = App\Models\Currency::get();
    @endphp
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Payment Settings') }}
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-10">
            @php
                $payment_gateways = App\Models\Payment_gateway::get();
            @endphp
            <div class="ol-card">
                <div class="ol-card-body p-4">
                    <div class="d-flex gap-3 flex-wrap flex-md-nowrap">
                        <div class="ol-sidebar-tab">
                            <div class="nav flex-column nav-pills" id="myv-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link @if(!isset($_GET['tab'])) active @endif" id="v-pills-currency-tab" data-bs-toggle="pill" data-bs-target="#v-pills-currency" type="button" role="tab" aria-controls="v-pills-currency" aria-selected="true">
                                    <span>{{ get_phrase('Currency Settings') }}</span>
                                </button>

                                <hr>

                                @foreach ($payment_gateways as $payment_gateway)
                                    <button class="nav-link @if(isset($_GET['tab']) && $_GET['tab'] == $payment_gateway->identifier) active @endif" id="v-pills-{{ $payment_gateway->identifier }}-tab" data-bs-toggle="pill" data-bs-target="#v-pills-{{ $payment_gateway->identifier }}" type="button" role="tab" aria-controls="v-pills-{{ $payment_gateway->identifier }}" aria-selected="true">
                                        <span>{{ $payment_gateway->title }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-content w-100" id="myv-pills-tabContent">
                            <div class="tab-pane fade @if(!isset($_GET['tab'])) show active @endif" id="v-pills-currency" role="tabpanel" aria-labelledby="v-pills-currency-tab" tabindex="0">
                                <h3 class="title text-14px mb-3">{{ get_phrase('Currency settings') }}</h3>

                                <div class="alert alert-primary ol-alert-primary mb-3" role="alert">
                                    <p class="sub-title2 fs-16px">
                                        <span class="title2">{{ get_phrase('Heads up !!') }}</span>
                                        {{ get_phrase('Ensure that the system currency and all active payment gateway currencies are same') }}
                                    </p>
                                </div>

                                <div class="ol-card-body">
                                    <form action="{{ route('admin.payment.settings.update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="top_part" value="top_part">


                                        <div class="fpb-7 mb-3">
                                            <label class="form-label ol-form-label">{{ get_phrase('Select currency') }}</label>
                                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="system_currency" required>
                                                <option value="">{{ get_phrase('Select currency') }}</option>

                                                @foreach ($System_currencies as $row)
                                                    <option value="{{ $row->code }}" @if (get_settings('system_currency') == $row->code) selected @endif>{{ $row->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="fpb-7 mb-3">
                                            <label class="form-label ol-form-label">{{ get_phrase('Currency position') }}</label>
                                            <select class="form-control ol-form-control ol-select2" data-toggle="select2" id = "currency_position" name="currency_position" required>
                                                <option value="left" @if (get_settings('currency_position') == 'left') selected @endif>
                                                    {{ get_phrase('Left') }}</option>
                                                <option value="right" @if (get_settings('currency_position') == 'right') selected @endif>
                                                    {{ get_phrase('Right') }}</option>
                                                <option value="left-space" @if (get_settings('currency_position') == 'left-space') selected @endif>
                                                    {{ get_phrase('Left with a space') }}</option>
                                                <option value="right-space" @if (get_settings('currency_position') == 'right-space') selected @endif>
                                                    {{ get_phrase('Right with a space') }}</option>
                                            </select>
                                        </div>

                                        <div class="fpb-7 mb-3">
                                            <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @foreach ($payment_gateways as $payment_gateway)
                                <div class="tab-pane fade @if(isset($_GET['tab']) && $_GET['tab'] == $payment_gateway->identifier) show active @endif" id="v-pills-{{ $payment_gateway->identifier }}" role="tabpanel" aria-labelledby="v-pills-{{ $payment_gateway->identifier }}-tab" tabindex="0">
                                    <h3 class="title text-14px mb-3">{{ $payment_gateway->title }} {{ get_phrase('settings') }}</h3>
                                    <div class="ol-card-body">
                                        <form action="{{ route('admin.payment.settings.update') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="identifier" value="{{ $payment_gateway->identifier }}">
            
                                            @if ($payment_gateway->identifier != 'offline')
                                                <div class="fpb-7 mb-3">
                                                    <label class="mb-2 text-capitalize">{{ get_phrase('Active') }}</label>
                                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="status">
                                                        <option value="0" @if ($payment_gateway->status == 0) selected @endif>
                                                            {{ get_phrase('No') }}</option>
                                                        <option value="1" @if ($payment_gateway->status == 1) selected @endif>
                                                            {{ get_phrase('Yes') }}</option>
                                                    </select>
                                                </div>
            
                                                <div class="fpb-7 mb-3">
                                                    <label class="mb-2 text-capitalize">{{ get_phrase('Want to keep test mode enabled') }}?</label>
                                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="test_mode">
                                                        <option value="0" @if ($payment_gateway->test_mode == 0) selected @endif>
                                                            {{ get_phrase('No') }}</option>
                                                        <option value="1" @if ($payment_gateway->test_mode == 1) selected @endif>
                                                            {{ get_phrase('Yes') }}</option>
                                                    </select>
                                                </div>
            
                                                <div class="fpb-7 mb-3">
                                                    <label class="mb-2 text-capitalize">{{ get_phrase('Select currency') }}</label>
                                                    <select class="form-control ol-form-control ol-select2" data-toggle="select2" name="currency" required>
                                                        <option value="">{{ get_phrase('Select currency') }}</option>
            
                                                        @foreach ($System_currencies as $currency)
                                                            <option value="{{ $currency->code }}" @if ($payment_gateway->currency == $currency->code) selected @endif>{{ $currency->code }}
                                                            </option>
                                                        @endforeach
            
                                                    </select>
                                                </div>
            
            
            
                                                @foreach (json_decode($payment_gateway['keys'], true) as $key => $value)
                                                    @if ($key == 'theme_color')
                                                        <label class="mb-2 text-capitalize">{{ get_phrase(str_replace('_', ' ', $key)) }}</label>
                                                        <input type="color" name="{{ $key }}" class="form-control ol-form-control" value="{{ $value }}" required />
                                                    @else
                                                        <div class="fpb-7 mb-3">
                                                            <label class="mb-2 text-capitalize">{{ get_phrase(str_replace('_', ' ', $key)) }}</label>
                                                            <input type="text" name="{{ $key }}" class="form-control ol-form-control" value="{{ $value }}" required />
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="fpb-7 mb-3 col-md-12">
                                                    <select name="status" id="status" class="form-control ol-form-control ol-select2" data-toggle="select2">
                                                        <option value="">{{ get_phrase('Choose an option') }}</option>
                                                        <option value="1" @if ($payment_gateway->status) selected @endif>
                                                            {{ get_phrase('Active') }}</option>
                                                        <option value="0" @if (!$payment_gateway->status) selected @endif>
                                                            {{ get_phrase('Inactive') }}</option>
                                                    </select>
                                                </div>

                                                @foreach (json_decode($payment_gateway['keys'], true) as $key => $value)
                                                    <div class="fpb-7 mb-3">
                                                        <label class="mb-2 text-capitalize">{{ get_phrase(str_replace('_', ' ', $key)) }}</label>
                                                        <textarea name="{{ $key }}" rows="5" class="form-control ol-form-control" required>{{ $value }}</textarea>
                                                    </div>
                                                @endforeach
                                            @endif
            
                                            <div class="row">
                                                <div class="fpb-7 mb-3 col-md-6">
                                                    <button class="btn btn-block ol-btn-primary" type="submit">{{ get_phrase('Update') }}
                                                        {{ $payment_gateway->title }} {{ get_phrase('setting') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@endpush
