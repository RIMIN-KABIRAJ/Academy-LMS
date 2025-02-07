<div class="toast-container position-fixed top-0 end-0 p-3"></div>
<script>
    "use strict";

    function toaster_message(type, icon, header, message) {
        var toasterMessage = '<div class="toast ' + type +
            ' fade text-12" role="alert" aria-live="assertive" aria-atomic="true" class="rounded-3"><div class="toast-header"> <i class="' +
            icon + ' me-2 mt-2px text-14 d-flex"></i> <strong class="me-auto"> ' + header +
            ' </strong><small>{{ get_phrase('Just Now') }}</small><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div><div class="toast-body">' +
            message + '</div></div>';
        $('.toast-container').prepend(toasterMessage);
        const toast = new bootstrap.Toast('.toast')
        toast.show()
    }

    function success(message) {
        toaster_message('success', 'fi-sr-badge-check', '{{ get_phrase('Success !') }}', message);
    }

    function warning(message) {
        toaster_message('warning', 'fi-sr-exclamation', '{{ get_phrase('Attention !') }}', message);
    }

    function error(message) {
        toaster_message('error', 'fi-sr-triangle-warning', '{{ get_phrase('An Error Occurred !') }}', message);
    }
</script>

@if ($message = Session::get('success'))
    <script>
        "use strict";
        success("{{ $message }}");
    </script>
    @php Session()->forget('success'); @endphp
@elseif($message = Session::get('error'))
    <script>
        "use strict";
        error("{{ $message }}");
    </script>
    @php Session()->forget('error'); @endphp
@elseif(isset($errors) && $errors->any())
    @php
        $message = '<ul>';
        foreach ($errors->all() as $error):
            $message .= '<li>' . $error . '</li>';
        endforeach;
        $message .= '</ul>';
    @endphp
    <script>
        "use strict";
        error("{!! $message !!}");
    </script>
@endif
