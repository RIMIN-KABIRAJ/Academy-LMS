@php
    $course_progress_out_of_100 = progress_bar($course_details->id);
    if (isset($_GET['tab'])) {
        $tab = $_GET['tab'];
    } elseif (Session::has('forum_tab')) {
        $tab = Session::get('forum_tab');
    } else {
        $tab = 'summary';
    }
@endphp
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($tab == 'summary') active @endif" id="pills-summary-tab" data-bs-toggle="pill" data-bs-target="#pills-summary" type="button" role="tab" aria-controls="pills-summary" aria-selected="true">
            <i class="fi-rr-blog-text"></i>
            <span>{{ get_phrase('Summary') }}</span>
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($tab == 'live-class') active @endif" id="pills-live-class-tab" data-bs-toggle="pill" data-bs-target="#pills-live-class" type="button" role="tab" aria-controls="pills-live-class" aria-selected="true">
            <i class="fi-rr-video-camera-alt"></i>
            <span>{{ get_phrase('Live class') }}</span>
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($tab == 'certificate') active @endif" id="pills-certificate-tab" data-bs-toggle="pill" data-bs-target="#pills-certificate" type="button" role="tab" aria-controls="pills-certificate" aria-selected="true">
            <i class="fi-rr-graduation-cap"></i>
            <span>{{ get_phrase('Certificate') }}</span>
        </button>
    </li>

    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($tab == 'forum') active @endif" id="pills-forum-tab" data-bs-toggle="pill" data-bs-target="#pills-forum" type="button" role="tab" aria-controls="pills-forum" aria-selected="true">
            <i class="fi fi-rr-users-alt"></i>
            <span>{{ get_phrase('Forum') }}</span>
        </button>
    </li>
</ul>

<div class="tab-content" id="pills-tabContent">
    @include('course_player.summary.index')
    @include('course_player.live_class.index')
    @include('course_player.certificate.index')
    @include('course_player.forum.index')
</div>

@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('button.nav-link').on('click', function(e) {
                e.preventDefault();
                let tab = $(this).data('bs-target');
                $.ajax({
                    type: "get",
                    url: "{{ route('forum.tab.active') }}",
                    data: {
                        tab: tab
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endpush
