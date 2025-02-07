<!-- Header -->
<div class="ol-header print-d-none d-flex align-items-center justify-content-between py-2 ps-3">
    <div class="header-title-menubar d-flex align-items-center">
        <button class="menu-toggler sidebar-plus">
            <span class="fi-rr-menu-burger"></span>
        </button>

        <div class="main-header-title">
            <h1 class="page-title fs-18px d-flex align-items-center gap-3">
                {{ get_settings('system_title') }}
            </h1>
            <span class="text-12px d-none d-md-inline-block">{{ get_phrase('Admin Panel') }}</span>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm pt-0 d-none d-md-inline-block text-14px text-muted">
            <span>{{ get_phrase('View site') }}</span>
            <i class="fi-rr-arrow-up-right-from-square text-12px text-muted"></i>
        </a>
    </div>
    <div class="header-content-right d-flex align-items-center justify-content-end">

        <!-- language Select -->
        <div class="d-none d-sm-block">
            <div class="img-text-select ">
                @php
                    $activated_language = strtolower(session('language') ?? get_settings('language'));
                @endphp
                <div class="selected-show" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ get_phrase('Language') }}">
                    <i class="fi-rr-language text-20px py-2"></i>
                </div>
                <div class="drop-content">
                    <ul>
                        @foreach (App\Models\Language::get() as $lng)
                            <li>
                                <a href="{{ route('admin.select.language', ['language' => $lng->name]) }}" class="select-text text-capitalize">

                                    <i class="fi fi-br-check text-10px me-1 @if ($activated_language != strtolower($lng->name)) visibility-hidden @endif"></i>
                                    {{ $lng->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>



        <a href="#" class="list text-18px d-inline-flex" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
            <span class="d-block h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ get_phrase('AI Assistant') }}">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class="">
                    <g>
                        <g fill="#424242">
                            <path d="M36.5 20C27.953 20 21 13.047 21 4.5a.5.5 0 0 0-1 0C20 13.047 13.047 20 4.5 20a.5.5 0 0 0 0 1C13.047 21 20 27.953 20 36.5a.5.5 0 0 0 1 0C21 27.953 27.953 21 36.5 21a.5.5 0 0 0 0-1zM60 34.5a.5.5 0 0 0-.5-.5C52.607 34 47 28.393 47 21.5a.5.5 0 0 0-1 0C46 28.393 40.393 34 33.5 34a.5.5 0 0 0 0 1C40.393 35 46 40.607 46 47.5a.5.5 0 0 0 1 0C47 40.607 52.607 35 59.5 35a.5.5 0 0 0 .5-.5zM38 49.5a.5.5 0 0 0-.5-.5c-5.238 0-9.5-4.262-9.5-9.5a.5.5 0 0 0-1 0c0 5.238-4.262 9.5-9.5 9.5a.5.5 0 0 0 0 1c5.238 0 9.5 4.262 9.5 9.5a.5.5 0 0 0 1 0c0-5.238 4.262-9.5 9.5-9.5a.5.5 0 0 0 .5-.5z" fill="#424242" opacity="1" data-original="#424242" class=""></path>
                        </g>
                    </g>
                </svg>
            </span>
        </a>


        <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ get_phrase('Help Center') }}">
            <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fi-rr-messages-question text-20px"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <div class="p-2">
                    <h5 class="title text-14px">{{ get_phrase('Help center') }}</h6>
                </div>
                <li>
                    <a href="https://creativeitem.com/docs/academy-lms" target="_blank" class="dropdown-item">
                        <i class="fi-rr-document-signed"></i>
                        <span>{{ get_phrase('Read documentation') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://www.youtube.com/watch?v=-HHhJUGQPeU&list=PLR1GrQCi5Zqvhh7wgtt-ShMAM1RROYJgE" target="_blank" class="dropdown-item">
                        <i class="fi-rr-video-arrow-up-right"></i>
                        <span>{{ get_phrase('Watch video tutorial') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="dropdown-item">
                        <i class="fi-rr-envelope-plus"></i>
                        <span>{{ get_phrase('Get customer support') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="dropdown-item">
                        <i class="fi-rr-box-up"></i>
                        <span>{{ get_phrase('Order customization') }}</span>
                    </a>
                </li>

                <li>
                    <a href="https://support.creativeitem.com" target="_blank" class="select-text text-capitalize">
                        <i class="fi-rr-add"></i>
                        <span>{{ get_phrase('Request a new feature') }}</span>
                    </a>
                </li>
                <li>
                    <a href="https://creativeitem.com/services" target="_blank" class="text-premium select-text text-capitalize d-flex align-items-center">
                        <i class="fi-rr-settings-sliders me-1"></i>
                        <span>{{ get_phrase('Get Services') }}</span>
                        <i class="fi-rr-crown ms-auto"></i>
                    </a>
                </li>
            </ul>
        </div>


        <!-- Profile -->
        <div class="header-dropdown-md">
            <button class="header-dropdown-toggle-md" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-profile-sm">
                    <img src="{{ get_image(auth()->user()->photo) }}" alt="">
                </div>
            </button>
            <div class="header-dropdown-menu-md p-3">
                <div class="d-flex column-gap-2 mb-12px pb-12px ol-border-bottom-2">
                    <div class="user-profile-sm">
                        <img src="{{ get_image(auth()->user()->photo) }}" alt="">
                    </div>
                    <div>
                        <h6 class="title fs-12px mb-2px">{{ auth()->user()->name }}</h6>
                        <p class="sub-title fs-12px">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
                <ul class="mb-12px pb-12px ol-border-bottom-2">
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="{{ route('admin.manage.profile') }}">{{ get_phrase('My Profile') }}</a></li>
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="{{ route('admin.system.settings') }}">{{ get_phrase('Settings') }}</a></li>
                </ul>
                <ul>
                    <li class="dropdown-list-1"><a class="dropdown-item-1" href="{{ route('logout') }}">{{ get_phrase('Sign Out') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
