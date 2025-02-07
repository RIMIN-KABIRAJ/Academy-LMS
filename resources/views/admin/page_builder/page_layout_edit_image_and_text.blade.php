<!-- Editor for  image -->
@if ($tag_name == 'img' || $tag_name == 'IMG')
    <div class="">
        <div class="block_label py-2">{{ get_phrase('Image editor') }}</div>
        <img src="" alt="" id="image_editor" class="w-25 border mb-2">
        <input type="file" id="image_uploader">
    </div>
@else
    <div class="">
        <div class="block_label py-2">{{ get_phrase('Text editor') }}</div>
        <textarea class="block_text_editor py-3" name="" id="text_editor" rows="5"></textarea>

        <div class="row py-3">
            <div class="col-md-9">
                <div class="block_label">{{ get_phrase('Text color') }}</div>
            </div>
            <div class="col-md-3">
                <input type="color" oninput="document.getElementById('{{ $element_id }}').style.setProperty('color', rgbToHex(this.value), 'important');" id="color_editor" />
            </div>
        </div>
    </div>
@endif
<hr>
<!-- Commong styles -->
<div class="py-1">
    <div class="block_label">{{ get_phrase('Padding') }}</div>
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('padding-top', this.value + 'px', 'important');" type="number" id="content_padding_top" class="block_editor_number_first">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('padding-right', this.value + 'px', 'important');"type="number" id="content_padding_right" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('padding-bottom', this.value + 'px', 'important');"type="number" id="content_padding_bottom" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('padding-left', this.value + 'px', 'important');"type="number" id="content_padding_left" class="block_editor_number_last">
</div>
<div class="py-1">
    <div class="block_label">{{ get_phrase('Margin') }}</div>
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('margin-top', this.value + 'px', 'important');" type="number" id="content_margin_top" class="block_editor_number_first">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('margin-right', this.value + 'px', 'important');" type="number" id="content_margin_right" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('margin-bottom', this.value + 'px', 'important');" type="number" id="content_margin_bottom" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('margin-left', this.value + 'px', 'important');" type="number" id="content_margin_left" class="block_editor_number_last">
</div>
<div class="py-1">
    <div class="block_label">{{ get_phrase('Border') }}</div>
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-top-width', this.value + 'px', 'important');" type="number" id="content_border_top" class="block_editor_number_first">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-right-width', this.value + 'px', 'important');" type="number" id="content_border_right" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-bottom-width', this.value + 'px', 'important');" type="number" id="content_border_bottom" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-left-width', this.value + 'px', 'important');" type="number" id="content_border_left" class="block_editor_number_last">

    <select onchange="document.getElementById('{{ $element_id }}').style.setProperty('border-style', this.value, 'important');" class="block_editor_select" id="content_border_style">
        <option value="">{{ get_phrase('none') }}</option>
        <option value="solid">{{ 'solid' }}</option>
        <option value="dashed">{{ get_phrase('dashed') }}</option>
        <option value="dotted">{{ get_phrase('dotted') }}</option>
    </select>

</div>
<div class="py-1">
    <div class="block_label">{{ get_phrase('Border roundness') }}</div>
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-top-left-radius', this.value + 'px', 'important');" type="number" id="content_border_radius_top" class="block_editor_number_first">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-top-right-radius', this.value + 'px', 'important');" type="number" id="content_border_radius_right" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-bottom-right-radius', this.value + 'px', 'important');" type="number" id="content_border_radius_bottom" class="block_editor_number_middle">
    <input oninput="document.getElementById('{{ $element_id }}').style.setProperty('border-bottom-left-radius', this.value + 'px', 'important');" type="number" id="content_border_radius_left" class="block_editor_number_last">
</div>

<div class="">
    <div class="row py-3">
        <div class="col-md-9">
            <div class="block_label">{{ get_phrase('Border color') }}</div>
        </div>
        <div class="col-md-3">
            <input onchange="document.getElementById('{{ $element_id }}').style.setProperty('border-color', rgbToHex(this.value), 'important');" type="color" id="border_color_editor" />
        </div>
    </div>
</div>

<div class="">
    <div class="row py-3">
        <div class="col-md-9">
            <div class="block_label">{{ get_phrase('Background color') }}</div>
        </div>
        <div class="col-md-3">
            <input onchange="document.getElementById('{{ $element_id }}').style.setProperty('background-color', rgbToHex(this.value), 'important');" type="color" id="background_color_editor" />
        </div>
    </div>
</div>


<script>
    "use strict";

    // Editor for text
    @if ($tag_name == 'img' || $tag_name == 'IMG')
        // Bind the uploader to upload new image and update the source
        $(document).ready(function() {
            var current_image = $('#{{ $element_id }}').attr('src');
            $('#image_editor').attr('src', current_image);

            $('#image_uploader').change(function() {
                var file = this.files[0]; // Get the selected file

                // Check if a file is selected
                if (file) {
                    var formData = new FormData(); // Create a FormData object

                    formData.append('file', file); // Append the file to the FormData object with 'file' as the key
                    formData.append('remove_file', $('#image_editor').attr('src')); // Append the file to the FormData object with 'file' as the key

                    // Perform AJAX request to upload the file
                    $.ajax({
                        url: "{{ route('admin.page.layout.image.update') }}", // Replace 'upload.php' with your server-side script URL
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: formData,
                        processData: false, // Prevent jQuery from automatically processing the data
                        contentType: false, // Prevent jQuery from automatically setting the Content-Type header
                        success: function(response) {
                            // Now change the source
                            $('#image_editor').attr('src', response);
                            document.getElementById('{{ $element_id }}').src = response;
                        },
                        error: function(xhr, status, error) {
                            // Handle the error
                            console.error('Error uploading file:', error);
                        }
                    });
                }
            });
        });
    @else
        $(document).ready(function() {
            // get the text value by advacned dom query
            let editing_text = $("#" + {{ $element_id }}).contents().filter(function() {
                return this.nodeType === 3; // Filter only text nodes
            })
            $("#text_editor").val(editing_text[0]['data'])

            // Get the color value
            let text_color = $("#" + {{ $element_id }}).css('color')
            text_color = rgbToHex(text_color)
            $('#color_editor').val(text_color)

            // Bind the editors on change event
            $('#text_editor').on('keyup', function() {
                update_text()
            })
            $('#color_editor').change(function() {
                update_text()
            })
        });

        function update_text() {
            // Change text value
            let new_text = $("#text_editor").val()
            if (new_text == "") new_text = " "
            $("#" + {{ $element_id }}).contents().filter(function() {
                return this.nodeType === 3; // Filter only text nodes
            }).replaceWith(new_text);

        }
    @endif

    // Required for color code conversion | it's a common function
    function rgbToHex(rgb) {
        // Parse the RGB components using regex
        var match = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

        // Convert the parsed RGB components to hexadecimal
        if (match) {
            return '#' +
                ('0' + parseInt(match[1], 10).toString(16)).slice(-2) +
                ('0' + parseInt(match[2], 10).toString(16)).slice(-2) +
                ('0' + parseInt(match[3], 10).toString(16)).slice(-2);
        }
        // If RGB format is incorrect, return original value
        else {
            return rgb;
        }
    }
</script>
<style>
    .block_text_editor {
        width: 100%;
        border: 1px solid #e2dcff;
        border-radius: 6px;
        padding: 6px;
        font-size: 12px;
    }

    .block_label {
        font-size: 12px;
        font-weight: 100;
    }

    .block_editor_number_first {
        width: 50px;
        border: 1px solid #e2dcff;
        border-radius: 5px 0px 0px 5px;
        margin-right: -5px;
        font-size: 12px;
        padding: 0px 0px 0px 8px;
        color: #585858;
    }

    .block_editor_number_middle {
        width: 50px;
        border: 1px solid #e2dcff;
        border-radius: 0px 0px 0px 0px;
        margin-right: -5px;
        font-size: 12px;
        padding: 0px 0px 0px 8px;
        color: #585858;
    }

    .block_editor_number_last {
        width: 50px;
        border: 1px solid #e2dcff;
        border-radius: 0px 5px 5px 0px;
        margin-right: -5px;
        font-size: 12px;
        padding: 0px 0px 0px 8px;
        color: #585858;
    }

    .block_editor_select {
        border: 1px solid #e2dcff;
        border-radius: 5px 5px 5px 5px;
        font-size: 12px;
        color: #585858;
        height: 25px;
        margin: 5px;
    }
</style>