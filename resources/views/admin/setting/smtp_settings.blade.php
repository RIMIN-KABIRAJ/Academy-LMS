<div class="row">
    <div class="col-md-12">
        <form class="required-form" action="{{ route('admin.notification.settings.store', 'smtp_settings') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label" for="smtp_protocol">{{ get_phrase('Protocol') }}<small>(smtp or ssmtp or
                        mail)</small><span class="required">*</span></label>
                <input type="text" name = "protocol" id = "smtp_protocol" class="form-control ol-form-control" value="{{ get_settings('protocol') }}" required>
            </div>

            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label" for="smtp_crypto">{{ get_phrase('Smtp crypto') }} <small>(ssl or
                        tls)</small><span class="required">*</span></label>
                <input type="text" name = "smtp_crypto" id = "smtp_crypto" class="form-control ol-form-control" value="{{ get_settings('smtp_crypto') }}">
            </div>

            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label" for="smtp_host">{{ get_phrase('Smtp host') }}<span class="required">*</span></label>
                <input type="text" name = "smtp_host" id = "smtp_host" class="form-control ol-form-control" value="{{ get_settings('smtp_host') }}" required>
            </div>

            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label" for="smtp_port">{{ get_phrase('Smtp port') }}<span class="required">*</span></label>
                <input type="text" name = "smtp_port" id = "smtp_port" class="form-control ol-form-control" value="{{ get_settings('smtp_port') }}" required>
            </div>

            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label" for="smtp_from_email">{{ get_phrase('Smtp from email') }}<span class="required">*</span></label>
                <input type="text" name = "smtp_from_email" id = "smtp_from_email" class="form-control ol-form-control" value="{{ get_settings('smtp_from_email') }}" required>
            </div>

            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label" for="smtp_user">{{ get_phrase('Smtp username') }}<span class="required">*</span></label>
                <input type="text" name = "smtp_user" id = "smtp_user" class="form-control ol-form-control" value="{{ get_settings('smtp_user') }}" required>
            </div>

            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label" for="smtp_pass">{{ get_phrase('Smtp password') }}<span class="required">*</span></label>
                <input onfocus="$(this).attr('type', 'text');" onblur="$(this).attr('type', 'password');" type="password" name = "smtp_pass" id = "smtp_pass" class="form-control ol-form-control" value="{{ get_settings('smtp_pass') }}" required>
            </div>

            <button type="submit" class="btn ol-btn-primary" onclick="checkRequiredFields()">{{ get_phrase('Save') }}</button>
        </form>
    </div>
</div>
