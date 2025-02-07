@php
    $width = get_player_settings('watermark_width');
    $height = get_player_settings('watermark_height');
    $top = get_player_settings('watermark_top');
    $left = get_player_settings('watermark_left');
    $logo = get_player_settings('watermark_logo');
    $opacity = get_player_settings('watermark_opacity');
@endphp

<div id="watermarkLabelLogo" class="watermark-container" style="width:{{ $width }}px; height:{{ $height }}px; top:{{ $top }}px; left:{{ $left }}px; opacity:.{{ $opacity / 10 }}">
    <img src="{{ get_image($logo) }}" style="width:{{ $width }}px; height:{{ $height }}px;">
</div>
<div id="watermarkStudentInfo" class="watermark-container d-none" style="width:{{ $width }}px; height:{{ $height }}px; top:{{ $top }}px; left:{{ $left }}px; opacity:.{{ $opacity / 10 }}">
    <div class="d-flex">
        <img class="image-30" src="{{ get_image(Auth()->user()->photo) }}" style="width:{{ $width }}px; height:{{ $height }}px;">
        <div class="ps-1">
            <p class="p-0 m-0 text-10px">{{ Auth()->user()->name }}</p>
            <p class="p-0 m-0 text-10px" style="margin-top: -5px !important;">{{ Auth()->user()->email }}</p>
        </div>
    </div>
</div>

<script>
    setInterval(() => {
        if ($('#watermarkLabelLogo').hasClass('d-none')) {
            $('.watermark-container').addClass('d-none');
            $('#watermarkLabelLogo').removeClass('d-none');
        } else {
            $('.watermark-container').addClass('d-none');
            $('#watermarkStudentInfo').removeClass('d-none');
        }
    }, 20000);
</script>


<style>    

    /* Watermark moving animation */
    @keyframes moveWatermark {
        0% {
            top: 20px;
            left: 20px;
        }

        25% {
            top: 20px;
            left: calc(100% - 150px);
            /* Move right */
        }

        50% {
            top: calc(100% - 50px);
            /* Move down */
            left: calc(100% - 150px);
        }

        75% {
            top: calc(100% - 50px);
            left: 20px;
            /* Move left */
        }

        100% {
            top: 20px;
            left: 20px;
            /* Back to the start */
        }
    }

    .watermark-container {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 20;
        font-size: 18px;
        color: white;
        pointer-events: none;
        /* Make sure the watermark doesn't interfere with video controls */
        animation: moveWatermark {{ get_player_settings('animation_speed') }}s linear infinite !important;
    }
</style>
