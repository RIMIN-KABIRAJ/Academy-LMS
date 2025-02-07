<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ get_phrase('Download Certificate') }}</title>
    <link rel="shortcut icon" href="{{ asset(get_frontend_settings('favicon')) }}" />
    <script src="{{ asset('assets/frontend/default/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/global/html2canvas/html2canvas.min.js') }}"></script>

</head>

<body>
    <style>
        html, body{
            overflow-x: hidden;
        }
        body {
            position: relative;
        }

        .remove-item,
        .ui-resizable-handle {
            display: none !important;
        }

        .certificate-layout-module {
            left: unset !important;
            top: unset !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        svg {
            width: 100%;
            height: 100%;
        }

        .download-btn {
            position: fixed;
            bottom: 10px;
            right: 10px;
            padding: 20px 32px;
            border-radius: 5px;
            color: #3d9bff;
            background-color: #d3e8ff;
            z-index: 100;
        }

        .absolute-view{
            background-color: #fff;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            overflow-y: auto;
            z-index: 50;
            width: 100%;
        }

        .certificate_builder_view{
            width: 60%;
            height: auto;
            min-width: 350px;
            margin-left: auto;
            margin-right: auto;
            padding-top: 60px;
        }
    </style>


    {{-- Downloadable canvas --}}
    <div class="captureCertificate" id="captureCertificate">
        @php
            $course_duration = $certificate->course->total_duration();
            $student_name = $certificate->user->name;
            $course_title = $certificate->course->title;
            $number_of_lesson = $certificate->course->lessons->count();
            $qr_code = $qrcode;
            $course_completion_date = date_formatter($certificate->created_at);
            $certificate_download_date = date('d M Y');
            $course_level = ucfirst($certificate->course->level);
            $course_language = ucfirst($certificate->course->language);
            $instructor_name = '';

            foreach ($certificate->course->instructors() as $instructor) {
                $instructor_name .= '<p>' . $instructor->name . '</p>';
            }

            $certificate_builder_content = get_settings('certificate_builder_content');
            $certificate_builder_content = str_replace('{course_duration}', $course_duration, $certificate_builder_content);
            $certificate_builder_content = str_replace('{instructor_name}', $instructor_name, $certificate_builder_content);
            $certificate_builder_content = str_replace('{student_name}', $student_name, $certificate_builder_content);
            $certificate_builder_content = str_replace('{course_title}', $course_title, $certificate_builder_content);
            $certificate_builder_content = str_replace('{number_of_lesson}', $number_of_lesson, $certificate_builder_content);
            $certificate_builder_content = str_replace('{qr_code}', $qr_code, $certificate_builder_content);
            $certificate_builder_content = str_replace('{course_completion_date}', $course_completion_date, $certificate_builder_content);
            $certificate_builder_content = str_replace('{certificate_download_date}', $certificate_download_date, $certificate_builder_content);
            $certificate_builder_content = str_replace('{course_level}', $course_level, $certificate_builder_content);
            $certificate_builder_content = str_replace('{course_language}', $course_language, $certificate_builder_content);

            // Use regex to update the src attribute of the <img> tag with the class 'certificate-template'.
            $newSrc = get_image(get_settings('certificate_template'));
            $certificate_builder_content = preg_replace('/(<img[^>]*class=["\']certificate-template["\'][^>]*src=["\'])([^"\']*)(["\'])/i', '${1}' . $newSrc . '${3}', $certificate_builder_content);
        @endphp

        {!! $certificate_builder_content !!}
    </div>
    {{-- Downloadable canvas end--}}


    {{-- Preview certificate --}}
    <div class="absolute-view">
        <div class="certificate_builder_view" id="certificate_builder_view">
            {!! $certificate_builder_content !!}
        </div>
    </div>
    {{-- Preview certificate end--}}


    <a class="download-btn" href="#" onclick="setTimeout(() => renderCanvasToImage(), 500);">{{ get_phrase('Download') }}</a>

    <script>
        "use strict";

        $(function() {
            var certificate_builder_view_width = $('.certificate_builder_view').width();
            var certificate_layout_module = $('.certificate_builder_view .certificate-layout-module').width();
            var zoomScaleValue = ((certificate_builder_view_width/certificate_layout_module)*100) - 8;
            $('.certificate_builder_view .certificate-layout-module').css('zoom', zoomScaleValue+'%');
        });
    
        function renderCanvasToImage() {
            
            var certificate_width = $('#captureCertificate > div').width();
            html2canvas(document.querySelector("#captureCertificate > div"), {
                allowTaint: true,
                useCORS: true,
                width: certificate_width,
                scale: 2
            }).then(canvas => {
                document.querySelector("#captureCertificate").appendChild(canvas);
                $("canvas").hide();

                setTimeout(function() {
                    var canvas = document.querySelector("canvas");
                    downloadCanvas(canvas, "certificate.png");
                }, 2000);
            });
        }


        function downloadCanvas(canvas, filename) {
            // Convert canvas to data URL
            var dataUrl = canvas.toDataURL("image/png");

            // Create a temporary link element
            var link = document.createElement("a");
            link.href = dataUrl;
            link.download = filename;

            // Append the link to the body
            document.body.appendChild(link);

            // Create a new MouseEvent and dispatch it
            var event = new MouseEvent('click', {
                view: window,
                bubbles: true,
                cancelable: true
            });
            link.dispatchEvent(event);

            // Remove the link from the body
            document.body.removeChild(link);
        }
    </script>
</body>

</html>
