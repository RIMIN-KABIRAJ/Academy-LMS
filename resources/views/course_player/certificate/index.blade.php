<div class="tab-pane fade @if ($tab == 'certificate') show active @endif" id="pills-certificate" role="tabpanel" aria-labelledby="pills-certificate-tab" tabindex="0">
    <div class="row justify-content-center my-4">
        <div class="col-md-6">


            @php
                $certificate = App\Models\Certificate::where('course_id', $course_details->id);
            @endphp
            @if ($certificate->count() > 0 && $course_progress_out_of_100 >= 100)
                <div class="alert alert-success text-center" role="alert">
                    <h4 class="alert-heading mb-4 mt-3">{{ get_phrase('Congratulations!') }}</h4>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning" style="width: {{ $course_progress_out_of_100 }}%">
                                    {{ round($course_progress_out_of_100) }}%</div>
                            </div>
                        </div>
                    </div>
                    <p class="text-13px mt-4">
                        {{ get_phrase('Your hard work has paid off. Here is to new beginnings and endless opportunities ahead!') }}
                        🎉👏</p>
                    <hr>
                    <a class="btn btn-warning" href="{{ route('certificate', ['identifier' => $certificate->value('identifier')]) }}">{{ get_phrase('Get Certificate') }}</a>
                </div>
            @else
                <div class="alert alert-primary text-center" role="alert">
                    <h5 class="alert-heading mb-3 mt-3">{{ get_phrase('Keep up the great work!') }}</h5>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning" style="width: {{ $course_progress_out_of_100 }}%">
                                    {{ round($course_progress_out_of_100) }}%</div>
                            </div>
                        </div>
                    </div>
                    <p class="text-13px mt-4">{{ get_phrase('Your dedication to ongoing progress is inspiring.') }}
                        {{ get_phrase('Every step forward is a testament to your commitment to growth and excellence.') }}
                        {{ get_phrase('Stay focused, stay determined, and continue to push yourself to new heights.') }}
                    </p>
                    <hr>
                    {{ get_phrase('You have got this!') }} 🌟💪
                </div>
            @endif
        </div>
    </div>
</div>
