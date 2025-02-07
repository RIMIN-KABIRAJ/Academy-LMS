<div class="tab-pane p-4 fade @if($tab == 'live-class') show active @endif" id="pills-live-class" role="tabpanel" aria-labelledby="pills-live-class-tab" tabindex="0">
    <div class="row">
        <div class="col-md-12">
            <h6>{{ get_phrase('Class Schedules') }}:</h6>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>#</th>
                        <th>{{ get_phrase('Topic') }}</th>
                        <th>{{ get_phrase('Date & time') }}</th>
                        <th>{{ get_phrase('Action') }}</th>
                    </thead>
                    <tbody>

                        @foreach (App\Models\Live_class::where('course_id', $course_details->id)->get() as $key => $live_class)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    {{ $live_class->class_topic }}
                                </td>
                                <td>{{ date('d M Y - h:i A', strtotime($live_class->class_date_and_time)) }}</td>
                                <td>
                                    <a href="{{ route('live.class.join', ['id' => $live_class->id]) }}"
                                        class="btn py-0 ps-1 pe-1 text-dark" data-bs-toggle="tooltip"
                                        data-bs-title="{{ get_phrase('Join Now') }}"><i
                                            class="fi-rr-video-camera"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
