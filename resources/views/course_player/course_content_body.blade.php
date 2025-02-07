<div class="course-video-area border-primary border">
    <!-- Video -->
    <div class="course-video-wrap">
        <div class="plyr__video-embed">
            @php $watermark_type = get_player_settings('watermark_type'); @endphp
            @if ($watermark_type == 'js')
                @include('course_player.watermark')
            @endif
            @include('course_player.player_page')
        </div>
    </div>
</div>

<!-- Thumb image -->
@if ($lesson_details->lesson_type == 'text' && $lesson_details->attachment_type == 'text')
    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light p-3">
        <div class="h-100">{!! removeScripts($lesson_details->attachment) !!}</div>
        <div class="position-absolute top-50 start-50 translate-middle">
        </div>
    </div>
@elseif ($lesson_details->lesson_type == 'video-url')
    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light">
        <div class="plyr__video-embed " id="player">
            <iframe width="560" height="315"
                src="{{ $lesson_details->lesson_src }}?https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe>
            <div class="position-absolute top-50 start-50 translate-middle">
            </div>
        </div>
    </div>
    @include('frontend.course_player.player_config')
@elseif($lesson_details->lesson_type == 'system-video')
    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light">
        <video poster="" id="player" playsinline controls>
            <source src="{{ asset($lesson_details->lesson_src) }}"
                type="video/mp4">
        </video>
    </div>
    @include('frontend.course_player.player_config')
@elseif($lesson_details->lesson_type == 'image')
    <div class="overflow-hidden bd-r-10 mb-16 position-relative bg-light">
        @php
            $img = asset('uploads/lesson_file/attachment/' . $lesson_details->attachment);
        @endphp
        <img width="100%" class="max-w-auto" height="auto" src="{{ $img }}" />
    </div>
@elseif($lesson_details->lesson_type == 'vimeo-url' && $lesson_details->video_type == 'vimeo')
    @php
        $video_url = $lesson_details->lesson_src;
        $video_id = explode('https://vimeo.com/', $video_url);
        $video_id = str_replace('https://vimeo.com/', '', $video_url);
    @endphp
    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light">
        <div class="plyr__video-embed " id="player">


            <iframe height="500"
                src="https://player.vimeo.com/video/{{ $video_id }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media"
                allowfullscreen allowtransparency allow="autoplay"></iframe>


            <div class="position-absolute top-50 start-50 translate-middle">
            </div>
        </div>
    </div>
    @include('frontend.course_player.player_config')
@elseif($lesson_details->lesson_type == 'google_drive')
    @php
        $video_url = $lesson_details->lesson_src;
        $url_array_1 = explode('/', $video_url . '/');
        $url_array_2 = explode('=', $video_url);
        $video_id = null;
        if ($url_array_1[4] == 'd'):
            $video_id = $url_array_1[5];
        else:
            $video_id = $url_array_2[1];
        endif;
    @endphp

    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light">
        <video id="player" playsinline controls>
            <source class="remove_video_src"
                src="https://www.googleapis.com/drive/v3/files/{{ $video_id }}?alt=media&key={{get_settings('youtube_api_key')}}"
                type="video/mp4">
        </video>
    </div>
    @include('frontend.course_player.player_config')
@elseif($lesson_details->lesson_type == 'html5')
    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light">

        <video id="player" playsinline controls>
            <source class="remove_video_src" src="{{ $lesson_details->lesson_src }}" type="video/mp4">
        </video>
    </div>
    @include('frontend.course_player.player_config')
@elseif($lesson_details->lesson_type == 'document_type')
    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light">
        @if ($lesson_details->attachment_type == 'pdf')
            <iframe class="embed-responsive-item" width="100%" height="500px"
                src="{{ asset('uploads/lesson_file/attachment/' . $lesson_details->attachment) }}"
                allowfullscreen></iframe>
        @elseif($lesson_details->attachment_type == 'doc')
            <iframe
                src="https://view.officeapps.live.com/op/embed.aspx?src={{ asset('uploads/lesson_file/attachment/' . $lesson_details->attachment) }}"
                width='100%' height='650px' frameborder='0'></iframe>

        @elseif($lesson_details->attachment_type == 'txt')
            <iframe src="{{ asset('uploads/lesson_file/attachment/' . $lesson_details->attachment) }}"
                width='100%' height='650px' frameborder='0'></iframe>
        @endif
    </div>
@else
    <div class="overflow-hidden bd-r-10 mb-16 h-314 h-md-428 position-relative bg-light">
        <iframe class="embed-responsive-item" width="100%" height="550px" src="{{ $lesson_details->lesson_src }}"
            allowfullscreen></iframe>
    </div>
@endif
