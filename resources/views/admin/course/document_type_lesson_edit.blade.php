<input type="hidden" name="lesson_type" value="document_type">
<input type="hidden" name="lesson_provider" value="file">

<div class="form-group mb-2">
    <label class="form-label ol-form-label" for="document_type">{{ get_phrase('Document type') }}</label>
    <select class="form-control ol-form-control" name="attachment_type" id="attachment_type" required>
        <option value="" >{{ get_phrase('Select type of document') }}</option>
        <option value="txt" @if($lessons->attachment_type == 'txt') selected @endif>{{ get_phrase('Text file') }}</option>
        <option value="pdf" @if($lessons->attachment_type == 'pdf') selected @endif>{{ get_phrase('Pdf file') }}</option>
        <option value="doc" @if($lessons->attachment_type == 'doc') selected @endif>{{ get_phrase('Document file') }}</option>
    </select>
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label" for="attachment">{{ get_phrase('Attachment') }}</label>
    <div class="input-group">
        <div class="custom-file w-100">
            <input type="file" class="form-control ol-form-control" id="attachment" name="attachment">
        </div>
    </div>
</div>
