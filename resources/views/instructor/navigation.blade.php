@php $current_route = Route::currentRouteName(); @endphp

<div class="sidebar-logo-area">
    <a href="#" class="sidebar-logos">
        <img class="sidebar-logo-lg" height="50px" src="{{ get_image(get_frontend_settings('dark_logo')) }}" alt="">
        <img class="sidebar-logo-sm" height="40px" src="{{ get_image(get_frontend_settings('favicon')) }}" alt="">
    </a>
    <button class="sidebar-cross menu-toggler d-block d-lg-none">
        <span class="fi-rr-cross"></span>
    </button>
</div>
<h3 class="sidebar-title fs-12px px-30px pb-20px text-uppercase mt-4">{{ get_phrase('Main Menu') }}</h3>
<div class="sidebar-nav-area">
    <nav class="sidebar-nav">
        <ul class="px-14px pb-24px">

            <li class="sidebar-first-li {{ $current_route == 'instructor.dashboard' ? 'active' : '' }}">
                <a href="{{ route('instructor.dashboard') }}">
                    <span class="icon fi-rr-house-blank"></span>
                    <div class="text">
                        <span>{{ get_phrase('Dashboard') }}</span>
                    </div>
                </a>
            </li>


            <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'instructor.courses' || $current_route == 'instructor.course.create' || $current_route == 'instructor.course.edit') active showMenu @endif">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-rr-e-learning"></span>
                    <div class="text">
                        <span>{{ get_phrase('Course') }}</span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Course') }}</li>
                    <li class="sidebar-second-li @if ($current_route == 'instructor.courses' || $current_route == 'instructor.course.edit') active @endif">
                        <a href="{{ route('instructor.courses') }}">{{ get_phrase('Manage Courses') }}</a>
                    </li>
                    <li class="sidebar-second-li @if ($current_route == 'instructor.course.create') active @endif">
                        <a href="{{ route('instructor.course.create') }}">{{ get_phrase('Add New Course') }}</a>
                    </li>
                </ul>
            </li>


            <li
                class="sidebar-first-li first-li-have-sub {{ $current_route == 'instructor.bootcamps' || $current_route == 'instructor.bootcamp.purchase.history' || $current_route == 'instructor.bootcamp.purchase.invoice' || $current_route == 'instructor.bootcamp.create' || $current_route == 'instructor.bootcamp.edit' || $current_route == 'instructor.bootcamp.categories' ? 'active' : '' }}">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-sr-users-alt"></span>
                    <div class="text">
                        <span>{{ get_phrase('Bootcamp') }}</span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Bootcamp') }}</li>

                    <li class="sidebar-second-li @if (($current_route == 'instructor.bootcamps' || $current_route == 'instructor.bootcamp.edit') && request('type') == '') active @endif"><a href="{{ route('instructor.bootcamps') }}">{{ get_phrase('Manage Bootcamps') }}</a></li>
                    <li class="sidebar-second-li @if ($current_route == 'instructor.bootcamp.create') active @endif">
                        <a href="{{ route('instructor.bootcamp.create') }}">{{ get_phrase('Add New Bootcamp') }}</a>
                    </li>
                    <li class="sidebar-second-li {{ $current_route == 'instructor.bootcamp.purchase.history' || $current_route == 'instructor.bootcamp.purchase.invoice' ? 'active' : '' }}">
                        <a href="{{ route('instructor.bootcamp.purchase.history') }}">{{ get_phrase('Purchase History') }}</a>
                    </li>
                </ul>
            </li>


            {{-- <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'instructor.team.packages' || $current_route == 'instructor.team.packages.create' || $current_route == 'instructor.team.packages.edit' || $current_route == 'instructor.team.packages.purchase.history' || $current_route == 'instructor.team.packages.purchase.invoice') active showMenu @endif">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-rr-document-signed"></span>
                    <div class="text">
                        <span>{{ get_phrase('Team Training') }}</span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Team Training') }}</li>
                    <li class="sidebar-second-li @if ($current_route == 'instructor.team.packages' || $current_route == 'instructor.team.packages.edit') active @endif">
                        <a href="{{ route('instructor.team.packages') }}">{{ get_phrase('Manage Packages') }}</a>
                    </li>
                    <li class="sidebar-second-li @if ($current_route == 'instructor.team.packages.create') active @endif">
                        <a href="{{ route('instructor.team.packages.create') }}">{{ get_phrase('Add New Package') }}</a>
                    </li>
                    <li class="sidebar-second-li {{ $current_route == 'instructor.team.packages.purchase.history' || $current_route == 'instructor.team.packages.purchase.invoice' ? 'active' : '' }}">
                        <a href="{{ route('instructor.team.packages.purchase.history') }}">{{ get_phrase('Purchase History') }}</a>
                    </li>
                </ul>
            </li> --}}


            <li class="sidebar-first-li {{ $current_route == 'instructor.sales.report' ? 'active' : '' }}">
                <a href="{{ route('instructor.sales.report') }}">
                    <span class="icon fi fi-sr-arrow-trend-up"></span>
                    <div class="text">
                        <span>{{ get_phrase('Sales') }}</span>
                    </div>
                </a>
            </li>

            <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'instructor.payout.reports' || $current_route == 'instructor.payout.setting') active showMenu @endif">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-rr-file-invoice-dollar"></span>
                    <div class="text">
                        <span>{{ get_phrase('Payout') }}</span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Payout') }}</li>
                    <li class="sidebar-second-li @if ($current_route == 'instructor.payout.reports' || $current_route == 'instructor.course.edit') active @endif">
                        <a href="{{ route('instructor.payout.reports') }}">{{ get_phrase('Withdraw') }}</a>
                    </li>
                    <li class="sidebar-second-li @if ($current_route == 'instructor.payout.setting') active @endif">
                        <a href="{{ route('instructor.payout.setting') }}">{{ get_phrase('Settings') }}</a>
                    </li>
                </ul>
            </li>


            @if (get_frontend_settings('instructors_blog_permission'))
                <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'instructor.blogs' || $current_route == 'instructor.blog.create' || $current_route == 'instructor.blog.edit' || $current_route == 'instructor.blog.pending') active showMenu @endif">
                    <a href="javascript:void(0);">
                        <span class="icon fi fi-rr-blog-text"></span>
                        <div class="text">
                            <span>{{ get_phrase('Blogs') }}</span>
                        </div>
                    </a>
                    <ul class="first-sub-menu">
                        <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Blogs') }}</li>
                        <li class="sidebar-second-li @if ($current_route == 'instructor.blogs' || $current_route == 'instructor.blog.edit') active @endif">
                            <a href="{{ route('instructor.blogs') }}">{{ get_phrase('Manage Blogs') }}</a>
                        </li>
                        <li class="sidebar-second-li @if ($current_route == 'instructor.blog.create') active @endif">
                            <a href="{{ route('instructor.blog.create') }}">{{ get_phrase('Add New Blog') }}</a>
                        </li>
                        <li class="sidebar-second-li @if ($current_route == 'instructor.blog.pending') active @endif">
                            <a href="{{ route('instructor.blog.pending') }}">{{ get_phrase('Pending Blogs') }}</a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="sidebar-first-li {{ $current_route == 'instructor.manage.profile' ? 'active' : '' }}">
                <a href="{{ route('instructor.manage.profile') }}">
                    <span class="icon fi-rr-circle-user"></span>
                    <div class="text">
                        <span>{{ get_phrase('Manage Profile') }}</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
</div>
