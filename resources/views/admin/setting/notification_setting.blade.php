@extends('layouts.admin')
@push('title', get_phrase('Notification settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Payment Settings') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-8">
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('SMTP Settings') }}</h3>
                <div class="ol-card-body">
                    @include('admin.setting.smtp_settings')
                </div>
            </div> <!-- end card-body-->
        </div>
    </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        "use strict";
        $(document).ready(function() {
            function notification_enable_disable(id, user_type, notification_type) {

                alert();
                var input_val = $('#' + id + user_type + '_' + notification_type).prop('checked');
                if (!input_val) {
                    input_val = 1;
                } else {
                    input_val = 0;
                }
                console.log(user_type);

                $.ajax({
                    type: "get",
                    url: '{{ route('admin.notification.settings.store', ['param1' => 'notification_enable_disable']) }}',
                    data: {
                        id: id,
                        user_types: user_type,
                        notification_type: notification_type,
                        input_val: input_val
                    },


                    success: function(response) {
                        if (response.status == 'success') {
                            console.log(response.msg);
                            success_notify(response.msg);
                        }
                    }
                });
            }
        });
    </script>



@endpush
