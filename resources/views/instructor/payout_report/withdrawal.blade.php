@php
    $requested_withdrawals = App\Models\Payout::where('user_id', auth()->user()->id)
        ->where('status', 0)
        ->exists();
    $balance = instructor_available_balance();
@endphp

@if ($requested_withdrawals)
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">{{ get_phrase('Opps!') }}!</h4>
        <p><strong>{{ get_phrase('You already requested a withdrawal') }}</strong></p>
        <p>{{ get_phrase('If you want to make another') }},
            {{ get_phrase('You have to delete the requested one first') }}</p>
    </div>
@elseif($balance > 0)
    <form class="required-form" action="{{ route('instructor.payout.request') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="withdrawal_amount" class="form-label ol-form-label">{{ get_phrase('Withdrawal amount') }}</label>
            <input type="number" class="form-control ol-form-control" name="amount" id="withdrawal_amount" aria-describedby="withdrawal_amount-help" min="0" max="{{ currency(number_format($balance, 2)) }}" required>
            <small id="withdrawal_amount-help" class="form-text text-muted">{{ get_phrase('The amount should not be more than') . ' ' . currency(number_format($balance, 2)) }}</small>
        </div>
        <button type="submit" class="btn btn-primary mt-3 text-center">{{ get_phrase('Request') }}</button>
    </form>
@else
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">{{ get_phrase('Ops!') }}!</h4>
        <p><strong>{{ get_phrase('You got nothing to withdraw') }}</strong></p>
    </div>
@endif
