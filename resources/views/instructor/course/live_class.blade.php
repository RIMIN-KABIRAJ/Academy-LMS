<div class="row">
    <div class="col-md-12 pb-3">
        <a class="btn ol-btn-primary float-end" onclick="ajaxModal('{{ route('modal', ['view_path' => 'instructor.course.create_live_class', 'course_id' => $course_details->id]) }}', '{{ get_phrase('Add a new live class') }}')"><i class="fi-rr-plus"></i> {{ get_phrase('Schedule a new live class') }}</a>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table eTable table-hover">
                <thead>
                    <th>#</th>
                    <th>{{ get_phrase('Class topic') }}</th>
                    <th>{{ get_phrase('Class Schedule') }}</th>
                    <th>{{ get_phrase('Action') }}</th>
                </thead>
                <tbody>

                    @foreach (App\Models\Live_class::where('course_id', $course_details->id)->get() as $key => $live_class)
                        <tr>
                            <td class="p-0">{{ ++$key }}</td>
                            <td class="p-0">
                                {{ $live_class->class_topic }}
                            </td>
                            <td class="p-0">{{ date('d M Y - h:i A', strtotime($live_class->class_date_and_time)) }}
                            </td>
                            <td class="p-0">
                                <a href="{{ route('instructor.live.class.start', ['id' => $live_class->id]) }}" class="btn py-0 ps-1 pe-1 text-dark" data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Start live class') }}"><i class="fi-rr-video-camera"></i></a>
                                <a href="#" class="btn py-0 px-1 text-dark" onclick="ajaxModal('{{ route('modal', ['view_path' => 'instructor.course.edit_live_class', 'id' => $live_class->id]) }}', '{{ get_phrase('Edit live class') }}')" data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Edit') }}"><i class="fi-rr-pencil"></i></a>
                                <a href="#" class="btn py-0 px-1 text-danger" onclick="confirmModal('{{ route('instructor.live.class.delete', ['id' => $live_class->id]) }}')" data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Delete') }}"><i class="fi-rr-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
