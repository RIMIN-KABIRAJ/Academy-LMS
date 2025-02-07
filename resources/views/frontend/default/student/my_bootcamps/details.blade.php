@extends('layouts.default')
@push('title', get_phrase('My Bootcamps'))
@section('content')
    <section class="my-course-content mt-50">
        <div class="profile-banner-area"></div>
        <div class="container profile-banner-area-container">
            <div class="row">
                @include('frontend.default.student.left_sidebar')

                <div class="col-lg-9">
                    <h4 class="g-title text-capitalize">{{ get_phrase('My Bootcamps') }}</h4>
                    <div class="my-panel mt-5">
                        <div class="bootcamp my-bootcamp-details">
                            <div class="row">
                                <div class="col-sm-4 col-md-3">
                                    <div class="bootcamp-thumbnail">
                                        <img src="{{ get_image($bootcamp->thumbnail) }}">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-7 py-4 py-sm-0">
                                    <div class="bootcamp-details">
                                        <div class="inner d-flex justify-content-between align-items-start">
                                            <div class="d-flex flex-column gap-2">
                                                <h4 class="bootcamp-title ellipsis-3" data-bs-toggle="tooltip"
                                                    title="{{ $bootcamp->title }}">
                                                    <a href="{{ route('bootcamp.details', $bootcamp->slug) }}"
                                                        class="color-2">{{ $bootcamp->title }}</a>
                                                </h4>
                                                @php
                                                    $user = get_user_info($bootcamp->user_id);
                                                @endphp

                                                <p class="text-14">{{ get_phrase('By ') }}
                                                    <a href="{{ route('instructor.details', ['name' => slugify($user->name), $user->id]) }}"
                                                        class="text-color">{{ $user->name }}</a>
                                                </p>
                                                <div class="d-flex gap-3">
                                                    <p class="module-details">
                                                        <span>
                                                            <svg width="20" height="20" viewBox="0 0 20 20"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                class="m-0">
                                                                <path
                                                                    d="M18.3307 10.0003C18.3307 14.6003 14.5974 18.3337 9.9974 18.3337C5.3974 18.3337 1.66406 14.6003 1.66406 10.0003C1.66406 5.40033 5.3974 1.66699 9.9974 1.66699C14.5974 1.66699 18.3307 5.40033 18.3307 10.0003Z"
                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                                <path
                                                                    d="M13.0875 12.65L10.5042 11.1083C10.0542 10.8416 9.6875 10.2 9.6875 9.67497V6.2583"
                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                        </span>
                                                        {{ date('d M, Y', $bootcamp->publish_date) }}
                                                    </p>

                                                    <p class="module-details">
                                                        <span>
                                                            <svg width="20" height="20" viewBox="0 0 20 20"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg"
                                                                class="m-0">
                                                                <path
                                                                    d="M1.67188 7.5V6.66667C1.67188 4.16667 3.33854 2.5 5.83854 2.5H14.1719C16.6719 2.5 18.3385 4.16667 18.3385 6.66667V13.3333C18.3385 15.8333 16.6719 17.5 14.1719 17.5H13.3385"
                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M3.07812 9.7583C6.92813 10.25 9.75313 13.0833 10.2531 16.9333"
                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M2.1875 12.5586C5.0125 12.9169 7.08751 15.0003 7.45417 17.8253"
                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                                <path
                                                                    d="M1.65234 15.7168C3.06068 15.9001 4.10235 16.9335 4.28568 18.3501"
                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                        <span>{{ count_bootcamp_classes($bootcamp->id) }}</span>
                                                        <span>{{ get_phrase('Live class') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2 col-md-2 p-0">
                                    <a href="{{ route('my.bootcamps') }}"
                                        class="eBtn gradient float-md-end">{{ get_phrase('Back') }}</a>
                                </div>
                            </div>
                        </div>

                        <!------------ modules ------------>
                        <div class="row">
                            @php
                                $modules = App\Models\BootcampModule::where('bootcamp_id', $bootcamp->id)->get();
                            @endphp
                            @if ($modules->count() > 0)
                                <div class="modules">
                                    @foreach ($modules as $module)
                                        @php
                                            $is_available = 1;

                                            if ($module->restriction == 1) {
                                                $is_available = time() >= $module->publish_date ? 1 : 0;
                                            } elseif ($module->restriction == 2) {
                                                $is_available =
                                                    time() >= $module->publish_date && time() <= $module->expiry_date
                                                        ? 1
                                                        : 0;
                                            }
                                        @endphp
                                        <div class="accordion accordion-flush" id="module-{{ $module->id }}">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="module-label-{{ $module->id }}">
                                                    <button class="accordion-button collapsed d-block" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#module-content-{{ $module->id }}"
                                                        aria-expanded="true"
                                                        aria-controls="module-content-{{ $module->id }}">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <span class="module-title ellipsis-2 pb-1"
                                                                    data-bs-target="tooltip" title="{{ $module->title }}">
                                                                    {{ $module->title }}
                                                                </span>

                                                                <small class="text-12 d-block fw-light text-color">
                                                                    @if ($module->restriction == 1)
                                                                        {{ get_phrase('Available from : ') }}
                                                                        {{ date('d-M-Y', $module->publish_date) }}
                                                                    @elseif ($module->restriction == 2)
                                                                        {{ get_phrase('Available within : ') }}
                                                                        {{ date('d-M-Y', $module->publish_date) }} -
                                                                        {{ date('d-M-Y', $module->expiry_date) }}
                                                                    @endif
                                                                </small>
                                                            </div>
                                                            <div class="col-md-4 d-flex justify-content-end">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <p class="module-details">
                                                                        <span>
                                                                            <svg width="20" height="20"
                                                                                viewBox="0 0 20 20" fill="none"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                class="m-0">
                                                                                <path
                                                                                    d="M1.67188 7.5V6.66667C1.67188 4.16667 3.33854 2.5 5.83854 2.5H14.1719C16.6719 2.5 18.3385 4.16667 18.3385 6.66667V13.3333C18.3385 15.8333 16.6719 17.5 14.1719 17.5H13.3385"
                                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                </path>
                                                                                <path
                                                                                    d="M3.07812 9.7583C6.92813 10.25 9.75313 13.0833 10.2531 16.9333"
                                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                </path>
                                                                                <path
                                                                                    d="M2.1875 12.5586C5.0125 12.9169 7.08751 15.0003 7.45417 17.8253"
                                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                </path>
                                                                                <path
                                                                                    d="M1.65234 15.7168C3.06068 15.9001 4.10235 16.9335 4.28568 18.3501"
                                                                                    stroke="#6B7385" stroke-width="1.25"
                                                                                    stroke-linecap="round"
                                                                                    stroke-linejoin="round">
                                                                                </path>
                                                                            </svg>
                                                                        </span>
                                                                        <span>{{ count_bootcamp_classes($module->id, 'module') }}</span>
                                                                        <span>{{ get_phrase('Live class') }}</span>
                                                                    </p>
                                                                    @if (!$is_available)
                                                                        <span class="fi fi-sr-lock text-color"></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="module-content-{{ $module->id }}"
                                                    class="accordion-collapse collapse"
                                                    aria-labelledby="module-label-{{ $module->id }}"
                                                    data-bs-parent="#module-{{ $module->id }}">
                                                    <div class="accordion-body">
                                                        @php
                                                            $live_classes = App\Models\BootcampLiveClass::where(
                                                                'module_id',
                                                                $module->id,
                                                            )->get();
                                                            $resources = App\Models\BootcampResource::where(
                                                                'module_id',
                                                                $module->id,
                                                            )->get();
                                                        @endphp

                                                        @if ($is_available)
                                                            @if ($live_classes->count() > 0)
                                                                <ul class="live-classes">
                                                                    @foreach ($live_classes as $class)
                                                                        <li>
                                                                            <div class="class-details">
                                                                                <p class="class-title">{{ $class->title }}
                                                                                </p>

                                                                                <div class="d-flex gap-3">
                                                                                    <div class="class-status">
                                                                                        @if ($class->status == 'live')
                                                                                            <span
                                                                                                class="badge bg-danger text-capitalize">{{ $class->status }}</span>
                                                                                        @elseif($class->status == 'upcoming')
                                                                                            <span
                                                                                                class="badge bg-warning text-capitalize">{{ $class->status }}</span>
                                                                                        @elseif($class->status == 'completed')
                                                                                            <span
                                                                                                class="badge bg-success text-capitalize">{{ $class->status }}</span>
                                                                                        @endif
                                                                                    </div>

                                                                                    <small class="text-12 text-color">
                                                                                        {{ date('d M, y', $class->start_time) }}
                                                                                    </small>

                                                                                    <small class="text-12 text-color">
                                                                                        ({{ date('h:i a', $class->start_time) }}
                                                                                        -
                                                                                        {{ date('h:i a', $class->end_time) }})
                                                                                    </small>
                                                                                </div>
                                                                            </div>

                                                                            <div class="class-btns">
                                                                                <a href="{{ class_started($class->id) ? route('bootcamp.live.class.join', slugify($class->title)) : 'javascript:void(0);' }}"
                                                                                    class="join-now {{ class_started($class->id) ? '' : 'disable' }}">{{ get_phrase('Join Now') }}</a>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif

                                                            @if ($resources->count() > 0)
                                                                <h4 class="mt-4 resource-title mb-3">
                                                                    {{ get_phrase('Resource files') }}</h4>
                                                                <ul class="live-classes">
                                                                    @foreach ($resources as $resource)
                                                                        <li>
                                                                            <div class="class-details">
                                                                                <p class="class-title ellipsis-1"
                                                                                    data-bs-target="tooltip"
                                                                                    title="{{ $resource->title }}">
                                                                                    {{ $resource->title }}
                                                                                </p>

                                                                                <div class="d-flex gap-3">
                                                                                    <div class="class-status">
                                                                                        @if ($resource->upload_type == 'resource')
                                                                                            <span
                                                                                                class="badge bg-success text-capitalize">{{ get_phrase('Resource') }}</span>
                                                                                        @elseif($resource->upload_type == 'record')
                                                                                            <span
                                                                                                class="badge bg-primary text-capitalize">{{ get_phrase('Record') }}</span>
                                                                                        @endif
                                                                                    </div>
                                                                                    <small
                                                                                        class="text-12 text-color fw-400">
                                                                                        {{ date('d M, Y', $resource->create_at) }}
                                                                                    </small>
                                                                                </div>
                                                                            </div>

                                                                            <div class="class-btns">
                                                                                @if ($resource->upload_type == 'resource')
                                                                                    <a href="{{ route('bootcamp.resource.download', $resource->id) }}"
                                                                                        class="join-now">{{ get_phrase('Download') }}</a>
                                                                                @else
                                                                                    <a href="{{ route('bootcamp.resource.play', $resource->title) }}"
                                                                                        class="join-now">{{ get_phrase('Play Now') }}</a>
                                                                                @endif
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif

                                                            @if ($live_classes->count() < 1 && $resources->count() < 1)
                                                                <p class="module-details no-data">
                                                                    {{ get_phrase('Module has no class available.') }}</p>
                                                            @endif
                                                        @else
                                                            <p class="module-details no-data">
                                                                {{ get_phrase('Module is not available.') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------ My wishlist area End  ------------>
@endsection
