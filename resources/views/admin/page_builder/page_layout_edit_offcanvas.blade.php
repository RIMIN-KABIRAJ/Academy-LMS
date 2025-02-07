<div class="builderOffcanvas offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ get_phrase('Manage content') }}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div id="offcanvas_content" class="offcanvas-body"></div>
</div>


<script type="text/javascript">
    "use strict";
    var builderOffcanvas;
    $(document).ready(function() {
        builderOffcanvas = new bootstrap.Offcanvas(document.querySelector('.builderOffcanvas'));
        builder_initiated();
    });

    function show_offcanvas(url) {


        if (!url) {
            url = "{{ route('view', ['path' => 'admin.page_builder.page_layout_edit_offcanvas_body']) }}";
        }
        $.ajax({
            url: url,
            success: function(offcanvas_content) {
                $('#offcanvas_content').html(offcanvas_content);
            },
            error: function(xhr, status, error) {
                // Handle the error
                console.error('Error uploading file:', error);
            }
        });

        builderOffcanvas.show();
    }

    function add_block_html_content_by_select_from_offcanvas(file_name, folder = "home_made_by_developer") {
        var identifier = Math.floor(Math.random() * 100000000);

        $.ajax({
            url: "{{ route('view', ['path' => 'components.']) }}" + folder + '.' + file_name,
            success: function(block_html_content) {
                var block_html_content = '<div builder-block-identifier="' + identifier + '" builder-block-file-name="' + file_name + '">' + block_html_content + '</div>';
                if ($('#main *').length == 0 || $('#main').html() == "") {
                    $('#placeholder_block').remove();
                    $('#main').html(block_html_content);
                } else {
                    if ($('#main .selected-block').length > 0) {
                        $('#main .selected-block').after(block_html_content);
                    } else {
                        $('#main').append(block_html_content);
                    }
                }
                builder_initiated();
            },
            error: function(xhr, status, error) {
                // Handle the error
                console.error('Error uploading file:', error);
            }
        });
    }

    function text_and_image_make_editable() {
        $('#main .builder-editable:not(.initialized)').each(function(index, elem) {
            var identifier = Math.floor(Math.random() * 100000000000) + index;
            $(this).attr('id', identifier);
            let tag_name = $(this).prop('tagName');
            let url = "{{ route('view', ['path' => 'admin.page_builder.page_layout_edit_image_and_text']) }}?element_id=" + identifier + "&tag_name=" + tag_name;

            //this is only for image to add overlay on image
            if (tag_name == 'img' || tag_name == 'IMG') {
                // Wrap the image in a container so that the button can be positioned relatively
                $(this).wrap(`<div class="builder-editable-wraper" onclick="show_offcanvas('${url}');"></div>`);
            } else {
                $(this).attr('onclick', `show_offcanvas('${url}');`);
            }

            $(this).addClass('initialized');
        });
    }

    function escapeHtml(html) {
        var text = document.createTextNode(html);
        var div = document.createElement('div');
        div.appendChild(text);
        return div.innerHTML;
    }


    function add_block_html_content_by_select_from_offcanvas_after_an_identified_element(identifier) {
        $('#main .selected-block').removeClass('selected-block');
        $("[builder-block-identifier='" + identifier + "']").addClass('selected-block');
        show_offcanvas();
    }

    function remove_block_html_content(identifier) {
        // Remove the block
        $("[builder-block-identifier='" + identifier + "']").remove();
        // If no block found, show a placeholder block to add new block
        if ($.trim($("#main").html()) == '') assign_initial_block();
    }

    function assign_initial_block() {
        var placeholder_block = `<div class="container placeholder_block_holder" id="placeholder_block">\
            <div class="row">\
                <div class="col-md-6 offset-3">\
                    <div class="placeholder_block">\
                        <i class="fi-rr-cube text-30px"></i>\
                        <div>Get started by adding new blocks</div>\
                        <button class="btn btn-primary btn-lg" onclick="show_offcanvas();" add-id="main">\
                        <i class="fi-rr-square-plus"></i> Add a new block</button>\
                    </div>\
                </div>\
            </div>\
        </div>`;
        $("#main").after(placeholder_block);
    }

    function builder_initiated() {

        //hide offcanvas
        builderOffcanvas.hide();

        // Initiate sortable
        $("#main").sortable({
            axis: 'y'
        });

        //Add "selected-block" class if click on any block to select
        $("[builder-block-identifier]").on('click', function() {
            $('#main .selected-block').removeClass('selected-block');
            $(this).addClass('selected-block');
        });

        // If no block found, assign a placeholder block to main section
        if ($.trim($("#main").html()) == '') assign_initial_block();

        $('#main a[href]').on('click', function(event) {
            event.preventDefault(); // Prevent the default action (e.g., navigation)
        });

        //Add Section add and remove buttons
        $('[builder-block-identifier]').each(function() {
            var attributeValue = $(this).attr('builder-block-identifier');
            var content_editor_buttons = `<div class="content_editor_buttons"><button class="btn btn-lg btn-primary block_delete" onclick="remove_block_html_content('${attributeValue}', this)"><i class="fi-rr-cross"></i></button><button class="btn btn-lg btn-primary block_add" onclick="add_block_html_content_by_select_from_offcanvas_after_an_identified_element('${attributeValue}');"><i class="fi-rr-plus"></i></button></div>`;
            if ($(this).find('.content_editor_buttons').length == 0) {
                $(this).prepend(content_editor_buttons);
            }
        });

        text_and_image_make_editable();
    }
</script>


<style>
    .offcanvas {
        /* transition: none !important; */
        width: 350px !important;
        z-index: 9999999 !important;
    }

    .builder-blocks {
        zoom: 20%;
        border: 8px solid #c4cdde;
        margin: 2px;
        border-radius: 12px;
        cursor: pointer;
        min-height: 500px;
        padding: 20px;
    }

    .builder-blocks:hover {
        border: 8px solid #97a8e4;
    }

    .builder-blocks>* {
        margin: 0px !important;
        border-radius: 12px;
    }

    .builder-block-placeholder i {
        color: transparent;
    }

    .builder-block-placeholder {
        top: 0;
        height: calc(100% - 7px);
        position: absolute;
        width: calc(100% - 12px);
        background-color: transparent;
        z-index: 99999;
        margin: 3.5px 3.5px;
        border-radius: 3px;
    }

    .builder-block-placeholder:hover {
        background-color: #0000004f;
    }

    .builder-block-placeholder:hover i {
        color: #fff;
    }




    [builder-block-identifier] {
        position: relative;
        border: 2px solid #00000000;
        margin-bottom: 5px;
    }


    [builder-block-identifier]:hover,
    [builder-block-identifier].selected-block {
        border: 2px dashed #737373;
        cursor: move;
    }

    [builder-block-identifier] .content_editor_buttons {
        position: absolute;
        display: none;
        left: 50%;
        transform: translateX(-50%);
        z-index: 999999;
        margin-top: 5px;
    }

    [builder-block-identifier]:hover .content_editor_buttons {
        display: block;
    }

    /* overlay button */
    .builder-editable,
    .builder-editable-wraper {
        position: relative !important;
        cursor: pointer;
        display: block;
        width: fit-content;
    }

    .builder-editable:hover::after,
    .builder-editable:focus::after,
    .builder-editable-wraper:hover::after,
    .builder-editable-wraper:focus::after {
        font-family: uicons-regular-rounded !important;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        z-index: 23;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        color: #fff;
    }

    .builder-editable:hover::after,
    .builder-editable:focus::after,
    .builder-editable-wraper:hover::after,
    .builder-editable-wraper:focus::after {
        content: "\f617";
        background-color: #b9b9b97d;
        color: #000;
        border: 2px dotted #a6a6a6;
        width: calc(100% + 8px);
        margin-left: -5px;
    }

    /* overlay button */
</style>
