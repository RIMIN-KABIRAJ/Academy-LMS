
<link rel="stylesheet" href="{{ asset('assets/global/plyr/plyr.css') }}">

@if (get_frontend_settings('promo_video_provider') == 'youtube')
    <div class="plyr__video-embed" id="promoPlayer">
        <iframe height="500" src="{{ get_frontend_settings('promo_video_link') }}?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1" allowfullscreen allowtransparency allow="autoplay"></iframe>
    </div>
@elseif (get_frontend_settings('promo_video_provider') == 'vimeo')
    <div class="plyr__video-embed" id="promoPlayer">
        <iframe height="500" id="promoPlayer" src="https://player.vimeo.com/video/{{ get_frontend_settings('promo_video_link') }}?loop=false&amp;byline=false&amp;portrait=false&amp;title=false&amp;speed=true&amp;transparent=0&amp;gesture=media" allowfullscreen allowtransparency allow="autoplay"></iframe>
    </div>
@else
    <video id="promoPlayer" playsinline controls>
        <source src="{{ get_frontend_settings('promo_video_link') }}" type="video/mp4">
    </video>
@endif

<script src="{{ asset('assets/global/plyr/plyr.js') }}"></script>
<script>
    "use strict";
    var promoPlayer = new Plyr('#promoPlayer');
</script>
<script>
    "use strict";
    const myModalElPromo = document.getElementById('promoVideo')
    myModalElPromo.addEventListener('hidden.bs.modal', event => {
        promoPlayer.pause();
        $('#promoVideo').toggleClass('in');
    });
    myModalElPromo.addEventListener('shown.bs.modal', event => {
        promoPlayer.play();
        $('#promoVideo').toggleClass('in');
    });

    
</script>