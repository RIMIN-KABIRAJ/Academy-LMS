@php
    $lessons = DB::table('lessons')->where('section_id', $id)->orderBy('sort')->get();
    $quizzes = DB::table('quizzes')->where('section_id', $id)->orderBy('sort')->get();
@endphp
<div class="row">
    <div class="col-12">
        <div id="lesson-list" class="list-group d-grid gap-2 border-0 mb-3">
            @foreach ($lessons as $key => $lesson)
                <div class="list-group-item rounded-3 py-2 px-2 border-1 draggable-item-lesson hover-parent d-flex" dataId="{{ $lesson->id }}">
                    {{ $lesson->title }} <span class="ms-auto">
                        <i class="fi-rr-apps-sort text-muted ps-2 border-start me-2 mt-1 hover-show cursor-move"></i></span>
                </div>
            @endforeach
        </div>
        <button class="btn ol-btn-primary" onclick="sort('{{ $id }}')">{{ get_phrase('Save Changes') }}</button>
    </div> <!-- end col -->
</div>

<script>
    "use strict";

    $(function() {
        $("#lesson-list").sortable({
            axis: "y"
        });
    });

    function sort(id) {
        var containerArray = ['lesson-list'];
        var itemArray = [];
        var lessons;
        var quizzes;
        let course_id = id;


        for (var i = 0; i < containerArray.length; i++) {
            $('#' + containerArray[i]).each(function() {
                $(this).find('.draggable-item-lesson').each(function() {
                    itemArray.push(this.getAttribute('dataId'));
                });
            });
        }

        var itemJSON = JSON.stringify(itemArray);
        $.ajax({
            url: "{{ route('admin.lesson.sort') }}",
            type: 'POST',
            data: {
                itemJSON: itemJSON,
                course_id: course_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
                location.reload();
            }
        });
    }
</script>
