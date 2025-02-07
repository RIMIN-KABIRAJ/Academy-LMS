<form action="{{ route('admin.bootcamp.resource.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="module_id" value="{{ $id }}">

    <div class="fpb-7 mb-3">
        <label for="upload_type"
            class="form-label ol-form-label">{{ get_phrase('Upload File Type') }}
            <span class="text-danger">*</span>
        </label>
        <select class="ol-select2" name="upload_type" id="upload_type" required>
            <option value="">{{ get_phrase('Select an option') }}</option>
            <option value="resource">{{ get_phrase('Resource') }}</option>
            <option value="record">{{ get_phrase('Class record') }}</option>
        </select>
    </div>

    <div class="row">
        <div class="fpb-7 col-sm-9">
            <label for="files"
                class="form-label ol-form-label">{{ get_phrase('Files') }}
                <span class="text-danger">*</span>
            </label>
            <input type="file" name="files[]" class="form-control ol-form-control"
                id="files" multiple required />
        </div>

        <div class="col-sm-3 d-flex align-items-end">
            <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Upload') }}</button>
        </div>
    </div>
</form>

@php
    $files = App\Models\BootcampResource::where('module_id', $id)->latest('id')->get();
@endphp
@if ($files->count() > 0)
    <h4 class="mt-4 resource-title mb-3">{{ get_phrase('Resource files') }}</h4>
    <ul class="bootcamp-resource">
        @foreach ($files as $file)
            <li class="file">
                <span class="badge {{ $file->upload_type == 'resource' ? 'bg-success' : 'bg-primary'}} text-white">{{ Str::ucfirst($file->upload_type) }}</span>
                <p class="cursor-pointer" data-bs-toggle="tooltip" title="{{ $file->title }}" data-bs-placement="bottom">{{ ellipsis($file->title, 40) }}</p>
                <div class="d-flex align-items-center gap-2 ms-auto action-btns">
                    <a href="{{ route('admin.bootcamp.resource.download', $file->id) }}" data-bs-toggle="tooltip" title="{{ get_phrase('Download') }}" data-bs-placement="bottom"><i class="fi fi-rr-down-to-line"></i></a>
                    <a class="dropdown-item" href="javascript:void(0);" onclick="confirmModal('{{ route('admin.bootcamp.resource.delete', $file->id) }}')" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" data-bs-placement="bottom"><span class="fi-rr-trash"></span></a>
                </div>
            </li>
        @endforeach
    </ul>
@endif

@include('admin.init')
