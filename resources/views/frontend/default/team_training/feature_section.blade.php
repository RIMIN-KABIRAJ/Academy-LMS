<div class="ps-box">
    <div class="requirment d-block">
        <div class="requirment-left">
            <h4 class="g-title mb-15">{{ get_phrase('Features') }}</h4>
            <ul>
                @php
                    $features = $package->features ? json_decode($package->features, true) : [];
                @endphp
                @foreach ($features as $feature)
                    <li class="d-flex">
                        <i class="fa-solid fa-check"></i>
                        <p class="description">{{ $feature }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
