@php
    $requirements = $bootcamp_details->requirements ? json_decode($bootcamp_details->requirements) : [];
    $outcomes = $bootcamp_details->outcomes ? json_decode($bootcamp_details->outcomes) : [];
@endphp


<div class="row">
    <div class="col-lg-12" id="details">
        <div class="ps-box">
            <div class="requirment d-block">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="requirment-left ">
                            <h4 class="g-title mb-20">{{ get_phrase('Requirment') }}</h4>
                            <ul>
                                @foreach ($requirements as $requirement)
                                    <li class="d-flex">
                                        <i class="fa-solid fa-check"></i>
                                        <p class="description">{{ $requirement }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="requirment-right">
                            <h4 class="g-title mb-20">{{ get_phrase('Outcomes') }}</h4>
                            <ul>
                                @foreach ($outcomes as $outcome)
                                    <li class="d-flex">
                                        <i class="fa-solid fa-check"></i>
                                        <p class="description">{{ $outcome }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
