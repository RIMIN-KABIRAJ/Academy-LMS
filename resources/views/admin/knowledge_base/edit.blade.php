@php
    $data = App\Models\Knowledge_base::where('id', $id)->first();
@endphp

<form action="{{ route('admin.knowledge.base.update', $id) }}" method="post">@csrf
    <div class="mb-3">
        <label for="title" class="form-label ol-form-label">{{ get_phrase('title') }}</label>
        <input type="text" name="title" class="form-control ol-form-control" id="title" value="{{ $data->title }}" placeholder="{{ get_phrase('Title') }}" required>
    </div>

    {{-- <div class="mb-3">
        <label for="title" class="form-label ol-form-label">{{ get_phrase('Description') }}</label>
        <textarea name="title" id="title" required>{{ $data->title }}</textarea>
    </div> --}}

    <div class="fpb-7">
        <button type="submit" class="ol-btn-primary">{{ get_phrase('Submit') }}</button>
    </div>
</form>

{{-- <script type="text/javascript">
    "use strict";

    $('#title').summernote({
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
</script> --}}
