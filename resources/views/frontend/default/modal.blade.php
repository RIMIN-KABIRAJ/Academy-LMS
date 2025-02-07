<div class="modal  fade" id="ajaxModal" tabindex="-1" aria-labelledby="ajaxModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-16" id="ajaxModalLabel"></h6>
                <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close"><i class="fi fi-br-cross-small text-20 text-white"></i></button>
            </div>
            <div class="modal-body">
                <div class="w-100 text-center py-5">
                    <div class="spinner-border my-5" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="eBtn gradient border-none" data-bs-dismiss="modal">{{ get_phrase('Close') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- video model --}}
<div class="modal  fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content video_contain">
            <div class="modal-header video_model">
                <h6 class="modal-title text-dark text-16px video_model_header" id="videoModalLabel"></h6>
                <button type="button" class="btn-close video_close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 text-center py-5">
                    <div class="spinner-border my-5" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal eModal fade" id="confirmModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered sweet-alerts text-sweet-alerts">
        <div class="modal-content">
            <div class="modal-body">
                <div class="icon icon-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" height="48" width="48">
                        <path d="M22.5 29V10H25.5V29ZM22.5 38V35H25.5V38Z" />
                    </svg>
                </div>
                <p>{{ get_phrase('Are you sure?') }}</p>
                <p class="focus-text">{{ get_phrase("You can't bring it back!") }}</p>
                <div class="confirmBtn">
                    <button type="button" class="eBtn eBtn-red" data-bs-dismiss="modal">{{ get_phrase('Cancel') }}</button>
                    <a href="" class="confirm-btn eBtn eBtn-green">{{ get_phrase("Yes, I'm sure") }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="right-modal" class="modal fade" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-lg modal-right set-width">
        <div class="modal-content h-100">
            <div class="modal-header border-1">
                <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<script>
    "use strict";

    function showRightModal(url, header) {
        // SHOWING AJAX PRELOADER IMAGE
        jQuery('#right-modal .modal-body').html(
            '<div class="modal-spinner-border"><div class="spinner-border text-secondary" role="status"></div></div>'
        );
        jQuery('#right-modal .modal-title').html('...');
        // LOADING THE AJAX MODAL
        jQuery('#right-modal').modal('show', {
            backdrop: 'true'
        });

        // SHOW AJAX RESPONSE ON REQUEST SUCCESS
        $.ajax({
            url: url,
            success: function(response) {
                jQuery('#right-modal .modal-title').html(header);
                jQuery('#right-modal .modal-body').html(response);

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

    const myModalElModal = document.getElementById('ajaxModal')
    myModalElModal.addEventListener('hidden.bs.modal', event => {
        $('#ajaxModal .modal-body').html(
            '<div class="w-100 text-center py-5"><div class="spinner-border my-5" role="status"><span class="visually-hidden"></span></div></div>'
        );
    })


    function videoModal(url, title, modalClasses = 'modal-md', animation = 'fade') {
        $('#videoModal .modal-dialog').removeClass('modal-sm');
        $('#videoModal .modal-dialog').removeClass('modal-md');
        $('#videoModal .modal-dialog').removeClass('modal-lg');
        $('#videoModal .modal-dialog').removeClass('modal-xl');
        $('#videoModal .modal-dialog').removeClass('modal-xxl');
        $('#videoModal .modal-dialog').removeClass('modal-fullscreen');
        $('#videoModal .modal-dialog').addClass(modalClasses);

        $('#videoModal').removeClass('fade');
        $('#videoModal').addClass(animation);

        $('#videoModal .modal-title').html(title);
        $("#videoModal").modal('show');
        $.ajax({
            type: 'get',
            url: url,
            success: function(response) {
                $('#videoModal .modal-body').html(response);
            }
        });
    }

    const videoModalEl = document.getElementById('videoModal')
    videoModalEl.addEventListener('hidden.bs.modal', event => {
        $('#videoModal .modal-body').html(
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
