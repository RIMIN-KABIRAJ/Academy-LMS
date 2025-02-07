@php
    $classes = DB::table('bootcamp_live_classes')->where('module_id', $id)->orderBy('sort')->get();
@endphp
<div class="row">
    <div class="col-12">
        <div id="lesson-list" class="list-group d-grid gap-2 border-0 mb-3">
            @foreach ($classes as $key => $class)
                <div class="list-group-item rounded-3 py-2 px-2 border-1 draggable-item-lesson hover-parent d-flex"
                    dataId="{{ $class->id }}">
                    {{ $class->title }}
                    <span class="ms-auto">
                        <i class="fi-rr-apps-sort text-muted ps-2 border-start me-2 mt-1 hover-show cursor-move"></i>
                    </span>
                </div>
            @endforeach
        </div>
        <button class="btn ol-btn-primary" onclick="sort('{{ $id }}')">{{ get_phrase('Save Changes') }}</button>
    </div> <!-- end col -->
</div>

<script>
    $(function() {
        $("#lesson-list").sortable({
            axis: "y"
        });
    });
</script>

<script type="text/javascript">
    function sort(id) {
        var containerArray = ['lesson-list'];
        var itemArray = [];
        var lessons;
        var quizzes;
        let module_id = id;


        for (var i = 0; i < containerArray.length; i++) {
            $('#' + containerArray[i]).each(function() {
                $(this).find('.draggable-item-lesson').each(function() {
                    itemArray.push(this.getAttribute('dataId'));
                });
            });
        }

        itemJSON = JSON.stringify(itemArray);
        $.ajax({
            url: "{{ route('admin.bootcamp.live.class.sort') }}",
            type: 'get',
            data: {
                itemJSON: itemJSON,
                module_id: module_id,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
                if (response.status) {
                    success(response.success)
                }
                location.reload()
            }
        });
    }
</script>
