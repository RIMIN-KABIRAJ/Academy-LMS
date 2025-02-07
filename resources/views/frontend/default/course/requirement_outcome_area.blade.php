@php
    $requirements = $course_details->requirements ? json_decode($course_details->requirements) : [];
    $outcomes = $course_details->outcomes ? json_decode($course_details->outcomes) : [];
@endphp

<div class="ps-box p-0 shadow-none">
    <div class="requirment d-block">
        <div class="row row-gap-4">
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