<div class="w-100">
    <!-- Tab-2-Content -->
    <div class="mb-3 d-flex gap-2 align-items-center flex-wrap">
        <a href="#"
            onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_module.create', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Add new module') }}')"
            class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Add module') }}
        </a>

        @if ($modules->count() > 0)
            <a href="#"
                onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_live_class.create', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Add live class') }}', 'modal-lg')"
                class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Add live class') }}
            </a>
        @endif

        @if ($modules->count() > 0)
            <a href="#"
                onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_module.sort', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Sort module') }}')"
                class="btn ol-btn-light ol-btn-sm">{{ get_phrase('Sort Module') }}
            </a>
        @endif
    </div>



    <ul class="ol-my-accordion">
        @forelse ($modules as $key => $module)
            @php
                $live_classes = DB::table('bootcamp_live_classes')
                    ->join('bootcamp_modules', 'bootcamp_live_classes.module_id', 'bootcamp_modules.id')
                    ->select('bootcamp_live_classes.*', 'bootcamp_modules.title as module_title')
                    ->where('bootcamp_live_classes.module_id', $module->id)
                    ->orderBy('sort')
                    ->get();
            @endphp
            <li class="single-accor-item">
                <div class="accordion-btn-wrap">
                    <div class="accordion-btn-title d-flex flex-column">
                        <img src="assets/images/icons/firstline-gray-16.svg" alt="">
                        <h4 class="title">{{ ++$key }}. {{ $module->title }}</h4>
                        @if ($module->restriction == 1)
                            <small>
                                {{ get_phrase('Available from : ') }}
                                {{ date('d-M-Y', $module->publish_date) }}
                            </small>
                        @elseif ($module->restriction == 2)
                            <small>
                                {{ get_phrase('Available within : ') }}
                                {{ date('d-M-Y', $module->publish_date) }} -
                                {{ date('d-M-Y', $module->expiry_date) }}
                            </small>
                        @endif
                    </div>
                    <div class="accordion-button-buttons">

                        @if ($live_classes->count() > 0)
                            <a href="#"
                                onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_live_class.sort', 'id' => $module->id]) }}', '{{ get_phrase('Sort lessons') }}'); event.stopPropagation();"
                                class="btn btn-outline-gray-small">{{ get_phrase('Sort class') }}
                            </a>
                        @endif

                        <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Resources') }}"
                            onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_resource.index', 'id' => $module->id]) }}', '{{ get_phrase('Resources') }}'); event.stopPropagation();"
                            class="edit">
                            <span class="fi fi-rr-box-open-full"></span>
                        </a>

                        <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Edit module') }}"
                            onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_module.edit', 'id' => $module->id]) }}', '{{ get_phrase('Edit module') }}'); event.stopPropagation();"
                            class="edit">
                            <span class="fi-rr-pencil"></span>
                        </a>

                        <a href="#" data-bs-toggle="tooltip" title="{{ get_phrase('Delete module') }}"
                            onclick="confirmModal('{{ route('instructor.bootcamp.module.delete', $module->id) }}'); event.stopPropagation();"
                            class="delete">
                            <span class="fi-rr-trash"></span>
                        </a>
                    </div>
                </div>
                <div class="accoritem-body" style="display: none;">
                    <ul class="list-group-3">
                        @if ($live_classes->count() > 0)
                            @foreach ($live_classes as $key => $class)
                                <li>
                                    <div class="class-data">
                                        <h4 class="title d-flex align-items-center gap-3">
                                            {{ $class->title }}
                                            @if (class_started($class->id))
                                                <span class="live-animation"></span>
                                            @endif
                                        </h4>

                                        <div class="class-ststus">
                                            @if ($class->status == 'live')
                                                <span
                                                    class="badge bg-danger text-white">{{ ucfirst($class->status) }}</span>
                                            @elseif($class->status == 'upcoming')
                                                <span
                                                    class="badge bg-warning text-white">{{ ucfirst($class->status) }}</span>
                                            @elseif($class->status == 'completed')
                                                <span
                                                    class="badge bg-success text-white">{{ ucfirst($class->status) }}</span>
                                            @endif

                                            <small class="ms-3">
                                                {{ date('d-M-y', $class->start_time) }}
                                            </small>

                                            <small>
                                                ({{ date('h:i a', $class->start_time) }} -
                                                {{ date('h:i a', $class->end_time) }})
                                            </small>
                                        </div>
                                    </div>

                                    <div class="buttons">
                                        @if (class_started($class->id))
                                            <a href="{{ route('instructor.bootcamp.class.end', $class->id) }}"
                                                data-bs-toggle="tooltip" title="{{ get_phrase('End Class') }}"
                                                class="edit-delete">
                                                <?xml version="1.0" encoding="UTF-8"?>
                                                <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1"
                                                    data-name="Layer 1" viewBox="0 0 24 24" width="18"
                                                    height="18">
                                                    <path
                                                        d="m12,0C5.383,0,0,5.383,0,12s5.383,12,12,12,12-5.383,12-12S18.617,0,12,0Zm0,21c-4.962,0-9-4.038-9-9S7.038,3,12,3s9,4.038,9,9-4.038,9-9,9Zm4-11v4c0,1.105-.895,2-2,2h-4c-1.105,0-2-.895-2-2v-4c0-1.105.895-2,2-2h4c1.105,0,2,.895,2,2Z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('instructor.bootcamp.live.class.join', slugify($class->title)) }}"
                                                data-bs-toggle="tooltip" title="{{ get_phrase('Join Class') }}" class="edit-delete">
                                                <?xml version="1.0" encoding="UTF-8"?>
                                                <svg xmlns="http://www.w3.org/2000/svg" id="live-class-icon"
                                                    data-name="Layer 1" viewBox="0 0 24 24" width="18"
                                                    height="18">
                                                    <path
                                                        d="m14.417,16.902c.492.559.691,1.327.578,2.224l-.541,2.865c-.257,1.172-1.454,2.009-2.454,2.009s-2.172-.837-2.423-1.98l-.536-2.834c-.124-.956.076-1.725.568-2.283.528-.599,1.333-.902,2.392-.902,1.083,0,1.888.304,2.416.902Zm-.417-4.902c0-1.105-.895-2-2-2s-2,.895-2,2,.895,2,2,2,2-.895,2-2ZM12,0C5.383,0,0,5.383,0,12c0,4.071,2.039,7.831,5.453,10.059.463.301,1.083.171,1.384-.292.302-.462.171-1.082-.291-1.384-2.847-1.856-4.546-4.99-4.546-8.383C2,6.486,6.486,2,12,2s10,4.486,10,10c0,3.393-1.699,6.526-4.546,8.383-.462.302-.593.922-.291,1.384.191.294.512.454.838.454.188,0,.376-.053.545-.162,3.415-2.228,5.453-5.987,5.453-10.059C24,5.383,18.617,0,12,0Zm5.833,15.871c.764-1.148,1.167-2.487,1.167-3.871,0-3.859-3.14-7-7-7s-7,3.141-7,7c0,1.336.402,2.657,1.163,3.822.302.463.921.593,1.384.29.462-.302.592-.921.291-1.384-.548-.839-.837-1.782-.837-2.729,0-2.757,2.243-5,5-5s5,2.243,5,5c0,.988-.288,1.944-.833,2.764-.306.46-.181,1.081.279,1.387.17.113.363.167.553.167.324,0,.641-.156.833-.446Z" />
                                                </svg>
                                            </a>
                                        @endif

                                        <a href="#" data-bs-toggle="tooltip"
                                            title="{{ get_phrase('Edit class') }}"
                                            onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_live_class.edit', 'id' => $class->id]) }}', '{{ get_phrase('Edit class') }}', 'modal-lg')"
                                            class="edit-delete">
                                            <span class="fi-rr-pencil"></span>
                                        </a>

                                        <a href="#" data-bs-toggle="tooltip"
                                            title="{{ get_phrase('Delete class') }}"
                                            onclick="confirmModal('{{ route('instructor.bootcamp.live.class.delete', $class->id) }}')"
                                            class="edit-delete">
                                            <span class="fi-rr-trash"></span>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li>
                                <h4 class="title">{{ get_phrase('No live classes are available.') }}</h4>
                            </li>
                        @endif
                    </ul>
                </div>
            </li>
        @empty
            <li>
                <div class="row">
                    <div class="offset-lg-2 col-md-8">
                        <a onclick="ajaxModal('{{ route('modal', ['instructor.bootcamp_module.create', 'id' => $bootcamp_details->id]) }}', '{{ get_phrase('Add new module') }}')"
                            href="#" class="add-section-block text-center mt-4">
                            <p class="sub-title"><i class="fi-rr-add"></i></p>
                            <h3 class="title text-15px mt-2 fw-500">{{ get_phrase('Add new module') }}</h3>
                        </a>
                    </div>
                </div>
            </li>
        @endforelse
    </ul>
</div>
