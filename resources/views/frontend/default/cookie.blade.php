<style>
    .cookieConsentContainer {
        z-index: 999;
        width: 450px;
        min-height: 20px;
        box-sizing: border-box;
        padding: 25px 25px 25px 25px;
        background: #232323;
        overflow: hidden;
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
        border-radius: 5px !important;
    }

    .cookieConsentContainer .cookieTitle a {
        font-family: OpenSans, arial, sans-serif;
        color: #fff;
        font-size: 22px;
        line-height: 20px;
        display: block
    }

    .cookieConsentContainer .cookieDesc p {
        margin: 0;
        padding: 0;
        font-family: OpenSans, arial, sans-serif;
        color: #fff;
        font-size: 13px;
        line-height: 20px;
        display: block;
        margin-top: 10px
    }

    .cookieConsentContainer .cookieDesc a {
        font-family: OpenSans, arial, sans-serif;
        color: #fff;
        text-decoration: underline
    }

    .link-cookie-policy {
        opacity: .6
    }

    .link-cookie-policy:hover {
        opacity: .8
    }

    @media (max-width:980px) {
        .cookieConsentContainer {
            bottom: 0 !important;
            left: 0 !important;
            width: 100% !important
        }
    }

    .cookieConsentContainer {
        opacity: .95;
        display: block;
        display: none
    }
    .cookieButton a{
        box-shadow: none;
    }
</style>

<div class="cookieConsentContainer" id="cookieConsentContainer" style="opacity: .95; display: block; display: none;">
    <!-- <div class="cookieTitle">
    <a>Cookies.</a>
  </div> -->
    <div class="cookieDesc">
        <p>
            {{get_frontend_settings('cookie_note')}}
            <a class="link-cookie-policy" href="{{route('cookie.policy')}}"><?php echo get_phrase('Cookie policy'); ?></a>
        </p>
    </div>
    <div class="cookieButton">
        <a class="eBtn gradient mt-4" href="#" onclick="cookieAccept();">{{get_phrase('Accept')}}</a>
    </div>
</div>

<script>
    $(document).ready(function() {
        if (localStorage.getItem("accept_cookie_laravel_academy")) {
            // localStorage.removeItem("accept_cookie_laravel_academy");
        } else {
            $('#cookieConsentContainer').fadeIn(1000);
        }
    });

    function cookieAccept() {
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem("accept_cookie_laravel_academy", true);
            localStorage.setItem("accept_cookie_academy_laravel_time", "<?php echo date('m/d/Y'); ?>");
            $('#cookieConsentContainer').fadeOut(1200);
        }
    }
</script>
