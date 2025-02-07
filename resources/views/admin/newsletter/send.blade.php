@php
    $newsletter = App\Models\Newsletter::where('id', $id)->first();
@endphp

<form action="{{ route('admin.send.newsletters') }}" method="post">
    @csrf
    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="send_to">{{ get_phrase('Send To') }}</label>
        <select name="send_to" class="form-control ol-form-control">
            <option value="selected_user">{{ get_phrase('Selected user') }}</option>

            <option value="all">{{ get_phrase('All user') }}</option>
            <option value="student">{{ get_phrase('All student') }}</option>
            <option value="instructor">{{ get_phrase('All instructor') }}</option>
            <option value="all_subscriber">
                {{ get_phrase('Newsletter subscriber') }}
                ({{ get_phrase('All subscriber') }})
            </option>
            <option value="registered_subscriber">
                {{ get_phrase('Newsletter subscriber') }}
                ({{ get_phrase('Registered user') }})
            </option>
            <option value="non_registered_subscriber">
                {{ get_phrase('Newsletter subscriber') }}
                ({{ get_phrase('Non registered user') }})
            </option>
        </select>
    </div>

    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="subject">{{ get_phrase('Subject') }}</label>
        <input type="text" value="{{ $newsletter->subject }}" name="subject" class="form-control" id="subject">
    </div>

    <div class="fpb7 mb-2">
        <label class="form-label ol-form-label" for="newsletter_description">{{ get_phrase('Description') }}</label>
        <textarea class="form-control ol-form-control text_editor" name="description">{{ $newsletter->subject }}</textarea>
    </div>

    <div class="fpb7 mb-2">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Send') }}</button>
    </div>

</form>

@include('admin.init')

<script type="text/javascript">
    'use strict'

    $(document).ready(function() {
        $(".server-side-select2").each(function() {
            var actionUrl = $(this).attr('action');
            console.log(actionUrl);
            $(this).select2({
                ajax: {
                    url: actionUrl,
                    dataType: 'json',
                    delay: 1000,
                    data: function(params) {
                        return {
                            searchVal: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    }
                },
                placeholder: 'Search here',
                minimumInputLength: 1,
            });
        });
    });
</script>
