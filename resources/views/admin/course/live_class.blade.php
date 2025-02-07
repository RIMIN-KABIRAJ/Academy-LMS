<div class="row">
    <div class="col-md-12 pb-3">
        <a class="btn ol-btn-primary float-end"
            onclick="ajaxModal('{{ route('modal', ['view_path' => 'admin.course.create_live_class', 'course_id' => $course_details->id]) }}', '{{ get_phrase('Add a new live class') }}')"><i
                class="fi-rr-plus"></i> {{ get_phrase('Schedule a new live class') }}</a>
    </div>
    <div class="col-md-12">
        <div class="table-responsive overflow-auto">
            <table class="table eTable eTable-2">
                <thead>
                    <th>{{ get_phrase('Instructor') }}</th>
                    <th>{{ get_phrase('Class topic') }}</th>
                    <th>{{ get_phrase('Class Schedule') }}</th>
                    <th>{{ get_phrase('Action') }}</th>
                </thead>
                <tbody>

                    @foreach (App\Models\Live_class::where('course_id', $course_details->id)->get() as $key => $live_class)
                        <tr>
                            <td>
                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                    <div class="dAdmin_profile_img">
                                        <img class="img-fluid rounded-circle image-45" width="40" height="40" src="{{ get_image($live_class->user->photo) }}" />
                                    </div>
                                    <div class="ms-1">
                                        <h4 class="title fs-14px">{{ $live_class->user->name }}</h4>
                                        <p class="sub-title2 text-12px">{{ $live_class->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-0 pt-3">
                                <p class="title text-12px">{{ $live_class->class_topic }}</p>
                            </td>
                            <td class="p-0 pt-3">
                                <p class="sub-title text-12px">{{ date('d M Y - h:i A', strtotime($live_class->class_date_and_time)) }}</p>
                            </td>
                            <td class="p-0 pt-3">
                                <a href="{{ route('admin.live.class.start', ['id' => $live_class->id]) }}" class="btn py-0 ps-1 pe-1 text-dark" data-bs-toggle="tooltip"
                                    data-bs-title="{{ get_phrase('Start live class') }}"><i class="fi-rr-video-camera"></i></a>
                                <a href="#" class="btn py-0 px-1 text-dark"
                                    onclick="ajaxModal('{{ route('modal', ['view_path' => 'admin.course.edit_live_class', 'id' => $live_class->id]) }}', '{{ get_phrase('Edit live class') }}')"
                                    data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Edit') }}"><i class="fi-rr-pencil"></i></a>
                                <a href="#" class="btn py-0 px-1 text-danger" onclick="confirmModal('{{ route('admin.live.class.delete', ['id' => $live_class->id]) }}')"
                                    data-bs-toggle="tooltip" data-bs-title="{{ get_phrase('Delete') }}"><i class="fi-rr-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
