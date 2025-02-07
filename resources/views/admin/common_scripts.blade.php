<script>
    "use strict";

    $(function() {
        $('a[href="#"]').on('click', function(event) {
            event.preventDefault();
        });
    });

    function redirectTo(url) {
        $(location).attr('href', url);
    }

    function actionTo(url, type = "get") {
        //Start prepare get url to post value
        var jsonFormate = '{}';
        if (type == 'post') {
            let pieces = url.split(/[\s?]+/);
            let lastString = pieces[pieces.length - 1];
            jsonFormate = '{"' + lastString.replace('=', '":"').replace("&", '","').replace("=", '":"').replace("&",
                '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=",
                '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&",
                '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=",
                '":"').replace("&", '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&",
                '","').replace("=", '":"').replace("&", '","').replace("=", '":"').replace("&", '","') + '"}';
        }
        jsonFormate = JSON.parse(jsonFormate);
        //End prepare get url to post value
        $.ajax({
            type: type,
            url: url,
            data: jsonFormate,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                distributeServerResponse(response);
            }
        });
    }

    //Server response distribute
    function distributeServerResponse(response) {
        try {
            JSON.parse(response);
            var isValidJson = true;
        } catch (error) {
            var isValidJson = false;
        }
        if (isValidJson) {
            response = JSON.parse(response);

            //For reload after submission
            if (typeof response.reload != "undefined" && response.reload != 0) {
                location.reload();
            }

            //For redirect to another url
            if (typeof response.redirectTo != "undefined" && response.redirectTo != 0) {
                $(location).attr('href', response.redirectTo);
            }

            //for show a element
            if (typeof response.show != "undefined" && response.show != 0 && $(response.show).length) {
                $(response.show).css('display', 'inline-block');
            }
            //for hide a element
            if (typeof response.hide != "undefined" && response.hide != 0 && $(response.hide).length) {
                $(response.hide).hide();
            }
            //for fade in a element
            if (typeof response.fadeIn != "undefined" && response.fadeIn != 0 && $(response.fadeIn).length) {
                $(response.fadeIn).fadeIn();
            }
            //for fade out a element
            if (typeof response.fadeOut != "undefined" && response.fadeOut != 0 && $(response.fadeOut).length) {
                $(response.fadeOut).fadeOut();
            }

            //For adding a class
            if (typeof response.addClass != "undefined" && response.addClass != 0 && $(response.addClass.elem).length) {
                $(response.addClass.elem).addClass(response.addClass.content);
            }
            //For remove a class
            if (typeof response.removeClass != "undefined" && response.removeClass != 0 && $(response.removeClass.elem)
                .length) {
                $(response.removeClass.elem).removeClass(response.removeClass.content);
            }
            //For toggle a class
            if (typeof response.toggleClass != "undefined" && response.toggleClass != 0 && $(response.toggleClass.elem)
                .length) {
                $(response.toggleClass.elem).toggleClass(response.toggleClass.content);
            }

            //For showing error message
            if (typeof response.error != "undefined" && response.error != 0) {
                error(response.error);
            }
            //For showing warning message
            if (typeof response.warning != "undefined" && response.warning != 0) {
                warning(response.warning);
            }
            //For showing success message
            if (typeof response.success != "undefined" && response.success != 0) {
                success(response.success);
            }

            //For replace texts in a specific element
            if (typeof response.text != "undefined" && response.text != 0 && $(response.text.elem).length) {
                $(response.text.elem).text(response.text.content);
            }
            //For replace elements in a specific element
            if (typeof response.html != "undefined" && response.html != 0 && $(response.html.elem).length) {
                $(response.html.elem).html(response.html.content);
            }
            //For replace elements in a specific element
            if (typeof response.load != "undefined" && response.load != 0 && $(response.load.elem).length) {
                $(response.load.elem).html(response.load.content);
            }
            //For appending elements
            if (typeof response.append != "undefined" && response.append != 0 && $(response.append.elem).length) {
                $(response.append.elem).append(response.append.content);
            }
            //Fo prepending elements
            if (typeof response.prepend != "undefined" && response.prepend != 0 && $(response.prepend.elem).length) {
                $(response.prepend.elem).prepend(response.prepend.content);
            }
            //For appending elements after a element
            if (typeof response.after != "undefined" && response.after != 0 && $(response.after.elem).length) {
                $(response.after.elem).after(response.after.content);
            }

            //For function call
            if (typeof response.functionCall != "undefined" && response.functionCall != 0) {
                eval(response.functionCall)
            }

            // Update the browser URL and add a new entry to the history
            if (typeof response.pushState != "undefined" && response.pushState != 0) {
                history.pushState({}, response.pushState.title, response.pushState.url);
            }
            //For form validation Error
            if (typeof response.validationError != "undefined" && response.validationError != 0) {
                $('.form-validation-error-label').remove();
                let errorList = '<ul>';
                Object.keys(response.validationError).forEach(key => {
                    if ($("[name=" + key + "]").length > 0) {
                        $("[name=" + key + "]").after(
                            '<small class="text-danger text-12px form-validation-error-label">' + response
                            .validationError[key][0] + '</small>');
                    } else if ($("input[name='" + key + "[]']").length > 0) {
                        $("input[name='" + key + "[]']").after(
                            '<small class="text-danger text-12px form-validation-error-label">' +
                            response.validationError[key][0] + '</small>');
                    }

                    errorList = errorList + '<li>' + response.validationError[key][0] + '</li>';
                });
                errorList = errorList + '</ul>';

                error(errorList);
            }

            if (typeof response.script != "undefined" && response.script != 0) {
                response.script
            }
        }
    }

    function loadView(url, element, check_already_loaded) {
        if ($(element).text() == '' && check_already_loaded || !check_already_loaded) {
            $.ajax({
                url: url,
                success: function(response) {
                    $(element).html(response);
                }
            });
        }
    }

    function downloadPDF(elem = ".print-table", fileName = 'data') {
        $('.print-d-none:not(.row, .ol-header, .ol-card)').addClass('d-none');
        // Get the table element as HTML
        const table = document.querySelector(elem);

        // Options for html2pdf
        const options = {
            margin: 0.5,
            filename: fileName,
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait'
            }
        };

        // Generate PDF from the table
        if (html2pdf().from(table).set(options).save()) {
            setInterval(() => {
                $('.print-d-none').removeClass('d-none');
            }, 2000);
        }

    }

    function downloadTableAsCSV(elem, filename = 'data.csv') {
        // Select the table element
        var table = document.querySelector(elem);

        // Initialize CSV string
        var csv = [];

        // Iterate over table rows
        var rows = table.rows;
        for (var i = 0; i < rows.length; i++) {
            var row = [],
                cols = rows[i].cells;

            // Iterate over table cells
            for (var j = 0; j < cols.length; j++) {
                row.push(cols[j].innerText);
            }

            // Join the row elements with commas
            csv.push(row.join(','));
        }

        // Join the rows with newline character
        var csvData = csv.join('\n');

        // Create a Blob object containing the CSV data
        var blob = new Blob([csvData], {
            type: 'text/csv'
        });

        // Create a temporary link to trigger the download
        var link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = filename + '.csv';
        document.body.appendChild(link);
        link.trigger('click');
        document.body.removeChild(link);
    }

    function loadImage(elem, preview) {
        var x = URL.createObjectURL(event.target.files[0]);
        console.log(x);
        $(preview).attr('src', x);
    }
</script>
