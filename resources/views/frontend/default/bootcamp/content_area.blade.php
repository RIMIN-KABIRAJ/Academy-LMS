<div class="row">
    <div class="col-lg-12" id="coursecontent">
        <div class="ps-box">
            <h4 class="g-title mb-15">{{ get_phrase('Course Content') }}</h4>
            <div class="lesson-play-list p-0">
                @if ($modules->count() > 0)
                    <div class="accordion" id="bootcamp-classes">
                        @foreach ($modules as $module)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse_{{ $module->id }}" aria-expanded="true"
                                        aria-controls="collapse_{{ $module->id }}">{{ ucfirst($module->title) }}
                                    </button>
                                </h2>
                                <div id="collapse_{{ $module->id }}" class="accordion-collapse collapse"
                                    data-bs-parent="#bootcamp-classes">
                                    <div class="accordion-body">
                                        <ul class="lesson-list course_list">
                                            @php
                                                $classes = DB::table('bootcamp_live_classes')
                                                    ->where('module_id', $module->id)
                                                    ->get();
                                            @endphp
                                            @if ($classes->count() > 0)
                                                @foreach ($classes as $class)
                                                    <li>
                                                        <a href="{{ $bootcamp_details->is_paid ? 'javascript:: void(0);' : route('course.player', $bootcamp_details->slug) }}"
                                                            class="d-flex justify-content-between align-items-center">
                                                            <p class="d-flex">
                                                                <i class="fi fi-sr-signal-stream"></i>
                                                                {{ ucfirst($class->title) }}
                                                            </p>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <p class="text-center mb-4">
                                                    {{ get_phrase('No classes available in this module.') }}</p>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">{{ get_phrase('Bootcamp Content Empty') }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
