<!DOCTYPE html>
<html>

<head>
    <title>{{ get_phrase('Certificate') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/vendors/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/global/jquery-ui-themes-1.13.2/themes/base/jquery-ui.css') }}">

    {{-- FlatIcons --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-solid-rounded/css/uicons-solid-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-bold-rounded/css/uicons-bold-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-bold-straight/css/uicons-bold-straight.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-regular-rounded/css/uicons-regular-rounded.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/icons/uicons-thin-rounded/css/uicons-thin-rounded.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/css/style.css') }}">

    <script type="text/javascript" src="{{ asset('assets/backend/js/jquery-3.7.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/global/jquery-ui-1.13.2/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <style type="text/css">
        body {
            font-family: 'Roboto', sans-serif;
        }

        .draggable {
            border: 2px dashed rgb(255, 255, 255);
            cursor: move;
            background-color: #15b57e33;
            top: 0;
        }

        .hidden-position:not(.certificate-layout-module) {
            background-color: #ffd3d3 !important;
        }

        .resizeable-canvas {
            width: 400px;
            padding: 10px;
            box-shadow: 1px 3px 11px -4px #565656;
            border-radius: 5px;
        }

        .certificate-layout-module.resizeable-canvas {
            padding: 0px !important;
        }

        .certificate-layout-module {
            background-color: #fff;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            bottom: 0;
            z-index: 200;
            background-color: #ffffff;
            width: 300px;
            height: 100%;
        }

        .sidebar.open {
            right: 0;
        }

        .sidebar-header {
            width: 100%;
            padding: 10px;
        }

        .sidebar-toggle {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 150;
        }

        .remove-item {
            position: absolute;
            top: -20px;
            right: -17px;
            background-color: white;
            border-radius: 50%;
            padding: 2px;
            height: 20px;
            width: 20px;
            font-size: 16px;
        }

        i:not(.fas, .fa, .fab) {
            line-height: 1.5em !important;
            vertical-align: -0.14em !important;
            display: inline-flex !important;
        }

        .dotted-background {
            width: 200px;
            height: 200px;
            background-image: radial-gradient(circle, #afafaf 1px, transparent 1px);
            background-size: 10px 10px;
            /* Adjust size of dots as needed */

            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 100;
            background-color: #e4e5ff;
            width: 100%;
            height: 100%;
            padding-left: 10px;
            padding-top: 10px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .sidebar-body {
            height: 100%;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <a onclick="$('.sidebar').addClass('open')" href="#" class="sidebar-toggle">
        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g id="SVGRepo_bgCarrier" stroke-width="0" />
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
            <g id="SVGRepo_iconCarrier">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H4ZM7 12C7 11.4477 7.44772 11 8 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H8C7.44772 13 7 12.5523 7 12ZM13 18C13 17.4477 13.4477 17 14 17H20C20.5523 17 21 17.4477 21 18C21 18.5523 20.5523 19 20 19H14C13.4477 19 13 18.5523 13 18Z" fill="#000000" />
            </g>
        </svg>
    </a>

    <div class="sidebar open">
        <div class="sidebar-header border-bottom d-flex align-items-center">
            <a class="btn" href="#" onclick="$('.sidebar').removeClass('open')">
                <i class="fi-rr-cross-small"></i>
            </a>
            {{ get_phrase('Certificate elements') }}
            <a class="ms-auto" href="{{ route('admin.certificate.settings') }}">{{ get_phrase('Back') }}</a>
        </div>

        <div class="sidebar-body">
            <div class="card border-0 m-2">
                <div class="card-body pt-0">
                    <h6 class="card-title mt-3">{{ get_phrase('Available Variable Data') }}</h6>
                    <span class="badge bg-secondary rounded-1">{course_duration}</span>
                    <span class="badge bg-secondary rounded-1">{instructor_name}</span>
                    <span class="badge bg-secondary rounded-1">{student_name}</span>
                    <span class="badge bg-secondary rounded-1">{course_title}</span>
                    <span class="badge bg-secondary rounded-1">{number_of_lesson}</span>
                    <span class="badge bg-secondary rounded-1">{qr_code}</span>
                    <span class="badge bg-secondary rounded-1">{course_completion_date}</span>
                    <span class="badge bg-secondary rounded-1">{certificate_download_date}</span>
                    <span class="badge bg-secondary rounded-1">{course_level}</span>
                    <span class="badge bg-secondary rounded-1">{course_language}</span>
                </div>
            </div>
            <div class="card border-0 m-2" id="custom_elem_form">
                <div class="card-body pt-2">
                    <h6 class="card-title">{{ get_phrase('Add a new element') }}</h6>
                    <form action="#">
                        <div class="mb-3">
                            <label for="certificate_element_content" class="form-label">{{ get_phrase('Enter Text with variable data') }}</label>
                            <textarea name="certificate_element_content" placeholder="{{ get_phrase('Total Lesson') }}:{number_of_lesson}" id="certificate_element_content" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="font_family_auto" class="form-label">{{ get_phrase('Choice a font-family') }}</label><br>
                            <input type="radio" name="font_family" value="auto" id="font_family_auto" checked> <label for="font_family_auto">{{ get_phrase('Auto') }}</label><br>
                            <input type="radio" name="font_family" value="Pinyon Script" id="font_family_pinyon_script"> <label for="font_family_pinyon_script">{{ get_phrase('Pinyon Script') }}</label><br>
                        </div>
                        <div class="mb-3">
                            <label for="font_size" class="form-label">{{ get_phrase('Font Size') }}</label><br>
                            <input type="number" name="font_size" value="16" id="font_size" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn ol-btn-light-primary w-100" onclick="addElemToCertificate()">{{ get_phrase('Add') }}</button>
                        </div>
                        <div class="mb-5">
                            <button type="button" class="btn ol-btn-primary w-100" onclick="saveTemplate()">{{ get_phrase('Save Template') }}</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>


    <div id="certificate_builder_content" class="builder dotted-background">

        {{-- Common style for page builder start --}}
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Italianno&display=swap');
            @import url('https://fonts.googleapis.com/css2?family=Pinyon+Script&display=swap%27');
            @import url('https://fonts.googleapis.com/css2?family=Miss+Fajardose&display=swap%27');
        </style>
        {{-- Common style for page builder END --}}

        @if (get_settings('certificate_builder_content'))
            @php
                $htmlContent = get_settings('certificate_builder_content');

                // Use regex to update the src attribute of the <img> tag with the class 'certificate-template'.
                $newSrc = get_image(get_settings('certificate_template'));

                $certificate_builder_content = preg_replace('/(<img[^>]*class=["\']certificate-template["\'][^>]*src=["\'])([^"\']*)(["\'])/i', '${1}' . $newSrc . '${3}', $htmlContent);
            @endphp
            {!! $certificate_builder_content !!}
        @else
            <div id="certificate-layout-module" class="certificate-layout-module resizeable-canvas draggable position-relative">
                <img class="certificate-template w-100 h-100" src="{{ get_image(get_settings('certificate_template')) }}">
            </div>
        @endif
    </div>
    <script>
        "use strict";

        function saveTemplate() {
            var certificate_builder_content = $('#certificate_builder_content').html();
            $.ajax({
                type: 'POST',
                url: "{{ route('admin.certificate.certificate.builder.update') }}",
                data: {
                    certificate_builder_content: certificate_builder_content
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $(location).attr('href', response);
                    console.log(response)
                }
            });
        }

        function addElemToCertificate() {
            var font_family = $("input[type='radio'][name='font_family']:checked").val();
            console.log(font_family);
            var font_size = $("#font_size").val();
            var certificate_element_content = $('#certificate_element_content').val();
            var certificateElem = `<div class="draggable resizeable-canvas" style="padding: 5px !important; position: absolute; font-size: ${font_size}px; top: 10px; left: 10px; width: min-content; font-family: '${font_family}';">
                ${certificate_element_content}
                <i class="remove-item fi-rr-cross-circle cursor-pointer" onclick="$(this).parent().remove()">
            </div>`;

            if (certificate_element_content != '') {
                $('#certificate-layout-module').append(certificateElem);
                $('#certificate_element_content').val('');
                $("#font_size").val(16);
                $("#font_family_auto").attr('checked', 'checked');
                initialize();
            }
        }

        $(document).ready(function() {
            initialize();
        });

        function initialize() {
            $(".draggable").draggable();

            $(".resizeable-canvas").resizable({
                resize: function(event, ui) {
                    // When resizing starts, temporarily disable dragging
                    $(".draggable").draggable("disable");
                    positionTracking(this);
                },
                stop: function(event, ui) {
                    $(".draggable").draggable("enable");
                    positionTracking(this);
                }
            });


            $(".draggable").on("dragend", function(e, pos) {}).on("dragstart", function(e, pos) {}).on("dragstop", function(e, pos) {
                positionTracking(this);
            });
        }

        function positionTracking(e) {
            var layoutCanvasOffset = $('#certificate-layout-module').offset();
            var layoutCanvasRight = $('#certificate-layout-module').width() + layoutCanvasOffset.left;
            var layoutCanvasBottom = $('#certificate-layout-module').height() + layoutCanvasOffset.top;

            if ($(e).attr('id') != 'certificate-layout-module') {
                var itemOffset = $(e).offset();
                var itemRight = $(e).width() + itemOffset.left;
                var itemBottom = $(e).height() + itemOffset.top;

                if (
                    layoutCanvasOffset.left < itemOffset.left &&
                    layoutCanvasOffset.top < itemOffset.top &&
                    layoutCanvasRight > itemRight &&
                    layoutCanvasBottom > itemBottom
                ) {
                    $(e).removeClass('hidden-position');
                } else {
                    $(e).addClass('hidden-position');
                }
            } else {
                var draggableItems = document.getElementsByClassName("draggable");
                for (var i = 0; i < draggableItems.length; i++) {
                    var itemOffset = $(draggableItems.item(i)).offset();
                    var itemRight = $(draggableItems.item(i)).width() + itemOffset.left;
                    var itemBottom = $(draggableItems.item(i)).height() + itemOffset.top;

                    if (
                        layoutCanvasOffset.left < itemOffset.left &&
                        layoutCanvasOffset.top < itemOffset.top &&
                        layoutCanvasRight > itemRight &&
                        layoutCanvasBottom > itemBottom
                    ) {
                        $(draggableItems.item(i)).removeClass('hidden-position');
                    } else {
                        $(draggableItems.item(i)).addClass('hidden-position');
                    }
                }
            }
        }
    </script>

</body>

</html>
