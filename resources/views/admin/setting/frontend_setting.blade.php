<h4 class="title mt-4 mb-3">{{ get_phrase('Frontend website settings') }}</h4>
<form class="required-form" action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="frontend_settings">
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" class="form-label ol-form-label" for="banner_title">{{ get_phrase('Banner title') }}<span class="required">*</span></label>
        <input type="text" name = "banner_title" id = "banner_title" class="form-control ol-form-control" value="{{ get_frontend_settings('banner_title') }}" required>
    </div>
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="banner_sub_title">{{ get_phrase('Banner sub title') }}<span class="required">*</span></label>
        <input type="text" name = "banner_sub_title" id = "banner_sub_title" class="form-control ol-form-control" value="{{ get_frontend_settings('banner_sub_title') }}" required>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="youtube_promo_video">{{ get_phrase('Promo Video Provider') }}<span class="required">*</span></label><br>
        <input type="radio" class="form-check-input" value="youtube" name="promo_video_provider" id="youtube_promo_video" @if (get_frontend_settings('promo_video_provider') == 'youtube') checked @endif>&nbsp;<label for="youtube_promo_video">{{ get_phrase('Youtube Video Link') }}</label>

        &nbsp;&nbsp;
        <input type="radio" class="form-check-input" value="vimeo" name="promo_video_provider" id="vimeo_promo_video" @if (get_frontend_settings('promo_video_provider') == 'vimeo') checked @endif>&nbsp;<label for="vimeo_promo_video">{{ get_phrase('Vimeo Video Link') }}</label>

        &nbsp;&nbsp;
        <input type="radio" class="form-check-input" value="html5" name="promo_video_provider" id="html5_promo_video" @if (get_frontend_settings('promo_video_provider') == 'html5') checked @endif>&nbsp;<label for="html5_promo_video">{{ get_phrase('HTML5 Video link') }}</label>

    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="promo_video_link">{{ get_phrase('Promo video link') }}<span class="required">*</span></label>
        <input type="text" name = "promo_video_link" id = "promo_video_link" class="form-control ol-form-control" value="{{ get_frontend_settings('promo_video_link') }}" required>
    </div>


    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label">{{ get_phrase('Cookie status') }}<span class="required">*</span></label><br>
        <input type="radio" class="form-check-input" value="1" name="cookie_status" @if (get_frontend_settings('cookie_status') == 1) checked @endif>&nbsp;{{ get_phrase('Active') }}

        &nbsp;&nbsp;
        <input type="radio" class="form-check-input" value="0" name="cookie_status" @if (get_frontend_settings('cookie_status') != 1) checked @endif>&nbsp;{{ get_phrase('Inactive') }}

    </div>
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="cookie_note">{{ get_phrase('Cookie note') }}</label>
        <textarea name="cookie_note" id = "cookie_note" class="form-control ol-form-control" rows="5">{{ get_frontend_settings('cookie_note') }}</textarea>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="facebook">{{ get_phrase('Facebook') }}</label>
        <input type="text" name = "facebook" id = "facebook" class="form-control ol-form-control" value="{{ get_frontend_settings('facebook') }}">
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="twitter">{{ get_phrase('Twitter') }}</label>
        <input type="text" name = "twitter" id = "twitter" class="form-control ol-form-control" value="{{ get_frontend_settings('twitter') }}">
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="linkedin">{{ get_phrase('Linkedin') }}</label>
        <input type="text" name = "linkedin" id = "linkedin" class="form-control ol-form-control" value="{{ get_frontend_settings('linkedin') }}">
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="cookie_policy">{{ get_phrase('Cookie policy') }}</label>
        <textarea name="cookie_policy" id = "cookie_policy" class="form-control ol-form-control text_editor" rows="5">{!! removeScripts(get_frontend_settings('cookie_policy')) !!}</textarea>
    </div>
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="about_us">{{ get_phrase('About us') }}</label>
        <textarea name="about_us" id = "about_us" class="form-control ol-form-control text_editor" rows="5">{!! removeScripts(get_frontend_settings('about_us')) !!}</textarea>
    </div>
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="terms_and_condition">{{ get_phrase('Terms and condition') }}</label>
        <textarea name="terms_and_condition" id ="terms_and_condition" class="form-control ol-form-control text_editor" rows="5">{{ get_frontend_settings('terms_and_condition') }}</textarea>
    </div>
    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="privacy_policy">{{ get_phrase('Privacy policy') }}</label>
        <textarea name="privacy_policy" id = "privacy_policy" class="form-control ol-form-control text_editor" rows="5">{{ get_frontend_settings('privacy_policy') }}</textarea>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" for="refund_policy">{{ get_phrase('Refund policy') }}</label>
        <textarea name="refund_policy" id = "refund_policy" class="form-control ol-form-control text_editor" rows="5">{{ get_frontend_settings('refund_policy') }}</textarea>
    </div>

    <div class="fpb-7 mb-3">
        <label class="form-label ol-form-label" class="form-label ol-form-label" for="mobile_app_link">{{ get_phrase('Mobile App download Link') }}<span class="required">*</span></label>
        <input type="text" name = "mobile_app_link" id = "mobile_app_link" class="form-control ol-form-control" value="{{ get_frontend_settings('mobile_app_link') }}">
    </div>

    <div class="fpb-7 mb-3">
        <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update Settings') }}</button>
    </div>
</form>
