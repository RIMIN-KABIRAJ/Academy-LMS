@php
    $article = App\Models\Knowledge_base_topick::where('id', $id)->first();
@endphp
 <form action="{{ route('admin.articles.update', $id) }}" method="post">@csrf
    <div class="mb-3">
        <label for="topic_name" class="form-label ol-form-label">{{ get_phrase('topic_name') }}</label>
        <input type="text" name="topic_name" class="form-control ol-form-control" id="topic_name" value="{{ $article->topic_name }}" placeholder="{{ get_phrase('Topick Name') }}" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="description" id="description" required>{{ $article->description }}</textarea>
    </div>

    <div class="fpb-7">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Submit') }}</button>
    </div>
</form> 

<script type="text/javascript">
    "use strict";

    $('#description').summernote({
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
</script>
