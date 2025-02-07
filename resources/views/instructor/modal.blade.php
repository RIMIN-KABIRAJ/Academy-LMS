<div class="modal  fade" id="ajaxModal" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-dark text-16px" id="ajaxModalLabel"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 text-center py-5">
                    <div class="spinner-border my-5" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn ol-btn-secondary" data-bs-dismiss="modal">{{ get_phrase('Close') }}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content pt-2">
            <div class="modal-body text-center">
                <div class="icon icon-confirm">
                    <i class="fi-rr-exclamation"></i>
                </div>
                <p class="title">{{ get_phrase('Are you sure?') }}</p>
                <p class="text-muted">{{ get_phrase("You can't bring it back!") }}</p>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn ol-btn-secondary fw-500" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                <a href="" class="confirm-btn btn ol-btn-success fw-500">{{ get_phrase('Confirm') }}</a>
            </div>
        </div>
    </div>
</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="right-modal" aria-labelledby="right-modalLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title title text-16px" id="right-modalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    </div>
</div>

<script>
    "use strict";

    function showRightModal(url, header) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#right-modal .offcanvas-body').html(
            '<div class="modal-spinner-border"><div class="spinner-border text-secondary" role="status"></div></div>'
        );
        jQuery('#right-modal .offcanvas-title').html("{{ get_phrase('Loading') }}...");
        // LOADING THE AJAX MODAL


        const bsOffcanvas = new bootstrap.Offcanvas('#right-modal');
        bsOffcanvas.show();

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#right-modal .offcanvas-title').html(header);
                jQuery('#right-modal .offcanvas-body').html(response);

            }
        });
    }
</script>

<script type="text/javascript">
    "use strict";

    function ajaxModal(url, title, modalClasses = 'modal-md', animation = 'fade') {
        $('#ajaxModal .modal-dialog').removeClass('modal-sm');
        $('#ajaxModal .modal-dialog').removeClass('modal-md');
        $('#ajaxModal .modal-dialog').removeClass('modal-lg');
        $('#ajaxModal .modal-dialog').removeClass('modal-xl');
        $('#ajaxModal .modal-dialog').removeClass('modal-xxl');
        $('#ajaxModal .modal-dialog').removeClass('modal-fullscreen');
        $('#ajaxModal .modal-dialog').addClass(modalClasses);

        $('#ajaxModal').removeClass('fade');
        $('#ajaxModal').addClass(animation);

        $('#ajaxModal .modal-title').html(title);
        $("#ajaxModal").modal('show');
        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                $('#ajaxModal .modal-body').html(response);
            }
        });
    }

    const myModalElModal2 = document.getElementById('ajaxModal')
    myModalElModal2.addEventListener('hidden.bs.modal', event => {
        $('#ajaxModal .modal-body').html(
            '<div class="w-100 text-center py-5"><div class="spinner-border my-5" role="status"><span class="visually-hidden"></span></div></div>'
        );
    })



    function confirmModal(url, elem = false, actionType = null, content = null) {
        $("#confirmModal").modal('show');

        if (elem != false) {
            $.ajax({
                url: url,
                success: function(response) {
                    response = JSON.parse(response);
                    //For redirect to another url
                    if (typeof response.success != "undefined") {
                        window.location.href = response.success;
                    }
                    distributeServerResponse(response);
                }
            });
        } else {
            $('#confirmModal .confirm-btn').attr('href', url);
            $('#confirmModal .confirm-btn').removeAttr('onclick');
        }
    }
</script>




<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ get_phrase('AI Assistant') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form class="aiAjaxFormSubmission" action="{{ route('instructor.open.ai.generate') }}" method="post">
            @csrf

            <div class="mb-3">
                <label class="form-label ol-form-label" for="ai_service_selector">{{ get_phrase('Select your service') }}</label>
                <select class="ol-select2" id="ai_service_selector" name="service_type" onchange="if(this.value == 'Course thumbnail'){$('#aiLanguageField').hide()}else{$('#aiLanguageField').show()}">
                    <option value="Course title" data-select2-id="2">{{ get_phrase('Course title') }}</option>
                    <option value="Course short description">{{ get_phrase('Course short description') }}</option>
                    <option value="Course short description">{{ get_phrase('Course long description') }}</option>
                    <option value="Course requirements">{{ get_phrase('Course requirements') }}</option>
                    <option value="Course outcomes">{{ get_phrase('Course outcomes') }}</option>
                    <option value="Course FAQ">{{ get_phrase('Course faq') }}</option>
                    <option value="Course SEO Tags">{{ get_phrase('Course seo tags') }}</option>
                    <option value="Course lesson text">{{ get_phrase('Course lesson text') }}</option>
                    <option value="Course certificate text">{{ get_phrase('Course certificate text') }}</option>
                    <option value="Course quiz text">{{ get_phrase('Course quiz text') }}</option>
                    <option value="Course blog title">{{ get_phrase('Course blog title') }}</option>
                    <option value="Course blog post">{{ get_phrase('Course blog post') }}</option>
                    <option value="Course thumbnail">{{ get_phrase('Course thumbnail') }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label ol-form-label" for="ai_keywords">{{ get_phrase('Enter your keyword') }}</label>
                <input type="text" class="form-control ol-form-control" id="ai_keywords" name="ai_keywords">
            </div>

            <div class="mb-3" id="aiLanguageField">
                <label class="form-label ol-form-label" for="language">{{ get_phrase('Language') }}</label>
                <select class="ol-select2" name="language">
                    @foreach (App\Models\Language::get() as $language)
                        <option value="{{ strtolower($language->name) }}" class="text-capitalize">{{ $language->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" id="aiSubmissionBtn" class="btn ol-btn-primary w-100">{{ get_phrase('Generate') }}</button>
        </form>

        <div class="row mt-3">
            <div class="col-md-12">
                <h5 id="aiResultHeader"></h5>
                <div id="aiGeneratedText" contenteditable="true"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    "use strict";


    $(function() {
        //The form of submission to RailTeam js is defined here.(Form class or ID)
        $('.aiAjaxFormSubmission').ajaxForm({
            beforeSend: function() {
                $('#aiSubmissionBtn').html("{{ get_phrase('Generating') }}");
                $('#aiSubmissionBtn').attr('disabled', true);
            },
            uploadProgress: function(event, position, total, percentComplete) {

            },
            complete: function(xhr) {
                var response = xhr.responseText;

                if (/^[\],:{}\s]*$/.test(response.replace(/\\["\\\/bfnrtu]/g, '@').replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
                        ']').replace(/(?:^|:|,)(?:\s*\[)+/g, '')) && $('#ai_service_selector').val() == 'Course thumbnail') {
                    var parsedJson = JSON.parse(response);
                    $('#aiGeneratedText').html('<div class="row"></div>');
                    console.log(parsedJson.length);
                    for (let i = 0; i < parsedJson.length; i++) {
                        var exi = i + 1;
                        var img =
                            '<div class="w-50 p-2 position-relative"><a class="position-absolute btn btn-success px-1 py-0 m-1" href="admin/ai_img_download?index=' +
                            exi + '" target="_blank"><i class="fas fa-download"></i></a><img class="radius-5px" width="100%" src="' + parsedJson[i].url +
                            '"></div>';
                        $('#aiGeneratedText .row').append(img);
                    }
                    $('#aiResultHeader').html('{{ get_phrase('Your images') }}:');
                    $('#aiGeneratedText').attr('contenteditable', 'false');
                } else {
                    $('#aiGeneratedText').html(response);
                    $('#aiGeneratedText').append('<input type="text" value="' + response + '" id="generatedAiText" class="visibility-hidden">');
                    $('#aiResultHeader').html(
                        '<span class="text-14px">{{ get_phrase('Generated text') }}:</span> <a href="javascript:;" onclick="copy_text(this)" data-toggle="tooltip" data-placement="top" title="{{ get_phrase('Copy') }}" class="float-right btn p-0"><i class="far fa-copy"></i> {{ get_phrase('Copy') }}</a>'
                    );
                }


                $('#aiSubmissionBtn').html("{{ get_phrase('Generate') }}");
                $('#aiSubmissionBtn').attr('disabled', false);
            },
            error: function() {
                //You can write here your js error message
            }
        });
    });

    function copy_text(e) {
        // Get the text field
        var copyText = document.getElementById("generatedAiText");
        console.log(copyText);

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        $(e).html('<i class="far fa-copy"></i> {{ get_phrase('Copied') }}!')
    }
</script>
