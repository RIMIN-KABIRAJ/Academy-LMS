@php
    $thread_info = App\Models\MessageThread::where('code', request()->query('inbox'))->first();
    $contact_id = $thread_info->contact_one == auth()->user()->id ? $thread_info->contact_two : $thread_info->contact_one;
    $contact_details = App\Models\User::where('id', $contact_id)->first();
@endphp

<div class="message-right position-relative">
    <div class="count-files d-flex align-items-center gap-3 cursor-pointer d-none">
        <p></p>
        <i class="fa-regular fa-circle-xmark" id="remove_files"></i>
    </div>
    <div class="tab-content" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
            <div class="message-header d-flex justify-content-between align-items-center pb-20 ">
                <div class="ins-nav w-100">
                    <div class="ins-left">
                        <div class="header-image">
                            <img src="{{ get_image($contact_details->photo) }}" alt="contact-photo">
                        </div>
                        <div class="ins-figure">
                            <h4>{{ $contact_details->name }}</h4>
                            <p>{{ $contact_details->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="custome-height" id="msg-box">
                @include('frontend.default.student.message.body')
            </div>
            @include('frontend.default.student.message.typing_option')
        </div>
    </div>
</div>

@push('js')
    <script>
        "use strict";
        $(document).ready(function() {
            $('.send_message_btn').on('click', function(e) {
                let msg = $('#type-msg').val();
                $('.message-input form').trigger('submit');
            });

            $('#gallery').change(function(e) {
                e.preventDefault();
                var fileCount = $(this)[0].files.length;
                if (fileCount > 0) {
                    $('.count-files').removeClass('d-none');
                    $('.count-files p').text(fileCount + ' files selected');
                    $(this).attr('name', 'media_files[]');
                }
            });

            $('#remove_files').on('click', function(e) {
                $('.count-files').addClass('d-none');
                $('.message-input #gallery').removeAttr('name');
            });
        });
    </script>
    <script>
        "use strict";
        var myDiv = document.getElementById('msg-box');
        myDiv.scrollTop = myDiv.scrollHeight;
    </script>
@endpush
