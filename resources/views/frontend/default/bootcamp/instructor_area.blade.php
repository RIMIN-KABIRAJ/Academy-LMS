@php
    $instructor = get_user_info($bootcamp_details->user_id);
@endphp

<div class="row">
    <div class="col-lg-12" id="instructor">
        <div class="ps-box eInstructor">
            <h4 class="g-title mb-20">{{ get_phrase('Instructor') }}</h4>
            <div class="istructor-info">
                <div class="ins-left">
                    <img src="{{ get_image($instructor->photo) }}" alt="...">
                    <div class="ins-designation">
                        <h5>{{ ucfirst($instructor->name) }}</h5>
                        <p class="description">
                            @php
                                $skills = json_decode($instructor->skills, true);
                                if (is_array($skills) && count($skills) > 0) {
                                    $skills = array_column($skills, 'value');
                                }
                            @endphp
                            {{ $skills ? implode(', ', $skills) : '' }}
                        </p>
                    </div>
                </div>
                <div class="ins-right">
                    <p>{{ instructor_rating($instructor->id) }}</p>
                    <ul class="d-flex re-star">
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                    </ul>
                </div>
            </div>
            <ul class="instructor-motion">
                <li>
                    <img src="{{ asset('assets/frontend/default/image/m1.png') }}" alt="...">
                    {{ count_student_by_instructor($bootcamp_details->user_id) }}
                </li>
                <li>
                    <img src="{{ asset('assets/frontend/default/image/m2.png') }}" alt="...">
                    {{ count_instructor_bootcamps($bootcamp_details->user_id) }}
                </li>
                <li>
                    <img src="{{ asset('assets/frontend/default/image/m3.png') }}" alt="...">
                    {{ instructor_reviews($instructor->id) }}
                </li>
            </ul>
            <p class="description mt-20 mb-5">
                {{ ucfirst($instructor->about) }}
            </p>
            <a href="{{ route('instructor.details', ['name' => slugify($instructor->name), 'id' => $instructor->id]) }}"
                class="eBtn gradient">{{ get_phrase('View Details') }}</a>
        </div>
    </div>
</div>
