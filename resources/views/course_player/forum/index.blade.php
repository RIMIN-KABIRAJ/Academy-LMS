<div class="tab-pane fade @if ($tab == 'forum') show active @endif" id="pills-forum" role="tabpanel" aria-labelledby="pills-forum-tab" tabindex="0">
    <div class="forum-tab-content">
        <div class="container" id="forum-area">
            @include('course_player.forum.question_body')
        </div>
    </div>
</div>

@push('js')
    <script>
        "use strict";

        $(document).ready(function() {
            function initializeSummernote() {
                $('textarea#summernote').summernote({
                    height: 180, // set editor height
                    minHeight: null, // set minimum height of editor
                    maxHeight: null, // set maximum height of editor
                    focus: true, // set focus to editable area after initializing summernote
                    toolbar: [
                        ['color', ['color']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['para', ['ul', 'ol']],
                        ['table', ['table']],
                        ['insert', ['link']]
                    ]
                });
            }

            initializeSummernote();

            $('#forum-area').on('click', '.show-form', function(e) {
                e.preventDefault();

                let btnType = $(this).attr('id');
                let data = {
                    course_id: "{{ $course_details->id }}"
                };
                let url = "{{ route('forum.question.create') }}";

                // if user click on edit button add a question id
                if (btnType == 'edit-question') {
                    data.question_id = $(this).data('question-id');
                    url = "{{ route('forum.question.edit') }}";
                } else if (btnType == 'reply') {
                    data.parent_question_id = $(this).data('parent-question-id');
                    url = "{{ route('forum.question.reply.create') }}";
                } else if (btnType == 'reply-edit') {
                    data.reply_id = $(this).data('reply-id');
                    url = "{{ route('forum.question.reply.edit') }}";
                }

                $.ajax({
                    type: "get",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('#forum-area').empty().append(response);
                        initializeSummernote();
                    }
                });
            });

            $('#forum-area').on('click', '#questions', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('forum.questions') }}",
                    data: {
                        course_id: "{{ $course_details->id }}"
                    },
                    success: function(response) {
                        $('#forum-area').empty().append(response);
                        initializeSummernote();
                    }
                });
            });
        });
    </script>
@endpush
