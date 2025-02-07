<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <style>
        html {
            background-color: #333333;
        }

        #my_pdf_viewer {
            margin-bottom: 50px;
        }

        #canvas_container {
            width: 100%;
            height: 100%;
            overflow: auto;
            background: #333;
            text-align: center;
        }

        #navigation_controls {
            background-color: #4b9d8a;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            display: flex;
        }

        #go_previous {
            width: 50%;
            max-width: 200px;
            height: 100%;
            background-color: #ffffff;
            border: none;
            cursor: pointer;
        }

        #go_next {
            width: 50%;
            max-width: 200px;
            height: 100%;
            background-color: #ffffff;
            border: none;
            cursor: pointer;
        }

        #current_page {
            height: 48px;
            width: 100%;
            border: none;
            background-color: #ffcd99;
            text-align: center;
            font-weight: 900;
            font-size: 18px;
        }

        #zoom_controls {
            background-color: #0000;
            position: fixed;
            bottom: 55px;
            right: 0;
            left: 0;
            text-align: center;
        }
    </style>
    <script src="<?php echo site_url('assets/global/pdf-canvas/'); ?>pdf.min.js"></script>
    <script src="<?php echo site_url('assets/global/pdf-canvas/'); ?>pdf.worker.min.js"></script>

</head>

<body>
    <div id="my_pdf_viewer">
        <div id="canvas_container">
            <canvas id="pdf_renderer"></canvas>
        </div>

        <div id="navigation_controls">
            <button id="go_previous"><?php echo get_phrase('Previous'); ?></button>
            <input id="current_page" value="1" type="number" />
            <button id="go_next"><?php echo get_phrase('Next'); ?></button>
        </div>

        <div id="zoom_controls">
            <button id="zoom_in">+</button>
            <button id="zoom_out">-</button>
        </div>
    </div>

    <script>
        "use strict";
        var myState = {
            pdf: null,
            currentPage: 1,
            zoom: 1
        }

        pdfjsLib.getDocument('<?php echo site_url('files?course_id=' . $course_id . '&lesson_id=' . $lesson_id . '&type=image'); ?>').then((pdf) => {

            myState.pdf = pdf;
            render();

        });

        function render() {
            myState.pdf.getPage(myState.currentPage).then((page) => {

                var canvas = document.getElementById("pdf_renderer");
                var ctx = canvas.getContext('2d');

                var viewport = page.getViewport(myState.zoom);

                canvas.width = viewport.width;
                canvas.height = viewport.height;

                page.render({
                    canvasContext: ctx,
                    viewport: viewport
                });
            });
        }

        document.getElementById('go_previous').addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage == 1)
                return;
            myState.currentPage -= 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });

        document.getElementById('go_next').addEventListener('click', (e) => {
            if (myState.pdf == null || myState.currentPage > myState.pdf._pdfInfo.numPages)
                return;
            myState.currentPage += 1;
            document.getElementById("current_page").value = myState.currentPage;
            render();
        });

        document.getElementById('current_page').addEventListener('keypress', (e) => {
            if (myState.pdf == null) return;

            // Get key code
            var code = (e.keyCode ? e.keyCode : e.which);

            // If key code matches that of the Enter key
            if (code == 13) {
                var desiredPage =
                    document.getElementById('current_page').valueAsNumber;

                if (desiredPage >= 1 && desiredPage <= myState.pdf._pdfInfo.numPages) {
                    myState.currentPage = desiredPage;
                    document.getElementById("current_page").value = desiredPage;
                    render();
                }
            }
        });

        document.getElementById('zoom_in').addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom += 0.2;
            render();
        });

        document.getElementById('zoom_out').addEventListener('click', (e) => {
            if (myState.pdf == null) return;
            myState.zoom -= 0.2;
            render();
        });

        //Disable right button
        document.addEventListener('contextmenu', event => event.preventDefault());
    </script>
</body>

</html>
