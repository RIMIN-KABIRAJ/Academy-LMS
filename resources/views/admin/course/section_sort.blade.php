@php
    $sections = DB::table('sections')
        ->where('course_id', $id)
        ->orderBy('sort')
    ->get(); @endphp
<div class="row">
    <div class="col-12">
        <div id="section-list" class="list-group d-grid gap-2 border-0 mb-3">
            @foreach ($sections as $key => $section)
                <div class="list-group-item rounded-3 py-2 px-2 border-1 draggable-item hover-parent d-flex" id="{{ $section->id }}">
                    {{ $section->title }} <span class="ms-auto"><i class="fi-rr-apps-sort text-muted ps-2 border-start me-2 mt-1 hover-show cursor-move"></i></span>
                </div>
            @endforeach
        </div>
        <button class="btn ol-btn-primary" onclick="sort('{{ $id }}')">{{ get_phrase('Save Changes') }}</button>
    </div> <!-- end col -->
</div>

<script>
    'use strict';

    $(function() {
        $("#section-list").sortable({
            axis: "y"
        });
    });

    function sort(id) {
        var containerArray = ['section-list'];
        var itemArray = [];
        var itemJSON;
        let course_id = id;

        
        for (var i = 0; i < containerArray.length; i++) {
            $('#' + containerArray[i]).each(function() {
                $(this).find('.draggable-item').each(function() {
                    itemArray.push(this.id);
                });
            });
        }

        itemJSON = JSON.stringify(itemArray);
        $.ajax({
            url: "{{ route('admin.section.sort') }}",
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
