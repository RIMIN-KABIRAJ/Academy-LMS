<form class="mt-3" method="get">
    <div class="form-group">
        <label for="purchase_code_form_field">{{ get_phrase('Purchase code') }}</label>
        <input type="text" class="form-control mb-1" name="purchase_code" id="purchase_code_form_field">
        <small id="invalid_purchase_code_message" class="d-none badge bg-danger">
            {{ get_phrase('Invalid purchase code') }}
        </small>
    </div>
    <div class="form-group mt-3">
        <button class="btn ol-btn-primary" onclick="save_purchase_code()"
            type="button">{{ get_phrase('Submit') }}</button>
    </div>
</form>

<script type="text/javascript">
    "use strict";

    function save_purchase_code() {
        var purchase_code = $('#purchase_code_form_field').val();
        $.ajax({
            url: "{{ route('admin.save_valid_purchase_code', 'update') }}",
            type: 'get',
            data: {
                purchase_code: purchase_code
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response == 1) {
                    window.location.reload();
                } else {
                    $('#invalid_purchase_code_message').removeClass('d-none');
                }
            }
        });
    }
</script>
