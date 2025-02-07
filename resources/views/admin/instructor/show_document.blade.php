@php
    $applicant_details = App\Models\Application::where('id', $id)->first();
    $user = get_user_info($applicant_details->user_id);
@endphp

<style>
    .instructor-info li:nth-last-child(1){
        border: none;
    }
    .instructor-info li{
        display: flex;
        align-content: center;
        justify-content: space-between;
        border-bottom: 1px solid var(--borderColor);
        padding: 16px 0;
    }
    .instructor-info li span:nth-child(1){
        font-size: 14px;
        font-weight: 600;
        color: var(--darkColor);
    }
    .instructor-info li span:nth-child(2){
        font-size: 14px;
        font-weight: 500;
        color: var(--grayColor);
    }
</style>

<div class="text-center mb-2">
    <img class="mr-2 rounded-circle image-100" src="{{ asset(get_user_info($applicant_details->user_id)->photo) }}" alt=""
        height="80">
</div>

<ul class="instructor-info">
    <li>
        <span>{{ get_phrase('Applicant') }}</span>
        <span>{{ $user->name }}</span>
    </li>
    <li>
        <span>{{ get_phrase('Email') }}</span>
        <span>{{ $user->email }}</span>
    </li>
    <li>
        <span>{{ get_phrase('Phone number') }}</span>
        <span>{{ $user->phone }}</span>
    </li>
    <li>
        <span>{{ get_phrase('Address') }}</span>
        <span>{{ $user->address }}</span>
    </li>
    <li>
        <span>{{ get_phrase('Message') }}&nbsp</span>: &nbsp
        <span>{{ $applicant_details->description }}</span>
    </li>
    <li>
        <span>{{ get_phrase('Status') }}</span>
        @if ($applicant_details->status)
            <span class="badge bg-success">{{ get_phrase('Accepted') }}</span>
        @else
            <span class="badge bg-danger">{{ get_phrase('Pending') }}</span>
        @endif
    </li>
</ul>
