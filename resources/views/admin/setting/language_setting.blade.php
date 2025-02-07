@extends('layouts.admin')
@push('title', get_phrase('Multi language setting'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Manage Language') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <p class="title text-14px mb-3">{{ get_phrase('Manage Language') }}</p>
        <div class="ol-card-body">
            <ul class="nav nav-tabs eNav-Tabs-custom eTab" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="cHome-tab" data-bs-toggle="tab" data-bs-target="#cHome" type="button" role="tab" aria-controls="cHome" aria-selected="true">
                        {{ get_phrase('Language list') }}
                        <span></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cProfile-tab" data-bs-toggle="tab" data-bs-target="#cProfile" type="button" role="tab" aria-controls="cProfile" aria-selected="false">
                        {{ get_phrase('Add Language') }}
                        <span></span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cMessage-tab" data-bs-toggle="tab" data-bs-target="#cMessage" type="button" role="tab" aria-controls="cMessage" aria-selected="false">
                        {{ get_phrase('Import Language') }}
                        <span></span>
                    </button>
                </li>
            </ul>
            <div class="tab-content eNav-Tabs-content" id="myTabContent">
                <div class="tab-pane fade show active" id="cHome" role="tabpanel" aria-labelledby="cHome-tab">
                    <!----TABLE LISTING STARTS-->
                    <div class="tab-pane show active" id="list">

                        <div class="table-responsive">
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ get_phrase('Language') }}</th>
                                        <th scope="col">{{ get_phrase('Direction') }}</th>
                                        <th scope="col">{{ get_phrase('Option') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $languages = App\Models\Language::get();
                                    @endphp
                                    @foreach ($languages as $language)
                                        <tr>
                                            <td class="text-capitalize">{{ $language->name }}</td>
                                            <td>
                                                <div class="form-group">
                                                    <form action="#">
                                                        <input onchange="update_language_dir('{{ $language->id }}', 'ltr')" name="direction" id="direction_ltr{{ $language->id }}" type="radio" value="ltr" @if ($language->direction == 'ltr') checked @endif>
                                                        <label for="direction_ltr{{ $language->id }}">{{ get_phrase('LTR') }}</label>
                                                        &nbsp;&nbsp;
                                                        <input onchange="update_language_dir('{{ $language->id }}', 'rtl')" name="direction" id="direction_rtl{{ $language->id }}" type="radio" value="rtl" @if ($language->direction == 'rtl') checked @endif>
                                                        <label for="direction_rtl{{ $language->id }}">{{ get_phrase('RTL') }}</label>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="">
                                                <a href="{{ route('admin.language.phrase.edit', ['lan_id' => $language->id]) }}" class="btn btn-light-white">{{ get_phrase('Edit phrase') }}</a>

                                                @if ($language->name == 'english' || $language->name == 'English')
                                                @else
                                                    <a href="javascript:;" onclick="confirmModal('{{ route('admin.language.delete', ['id' => $language->id]) }}')" class="btn btn-light-white">{{ get_phrase('Delete language') }}</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                    <!----TABLE LISTING ENDS--->
                </div>
                <div class="tab-pane fade" id="cProfile" role="tabpanel" aria-labelledby="cProfile-tab">
                    <!----ADD NEW LANGUAGE---->
                    <div class="tab-pane" id="add_lang">
                        <div class="row m-2">
                            <div class="col-md-8">
                                <form action="{{ route('admin.language.store') }}" method="post">
                                    @csrf
                                    <div class="fpb7 mb-2">
                                        <label for="language" class="form-label ol-form-label">{{ get_phrase('Add new language') }}</label>
                                        <input type="text" class="form-control ol-form-control" id="language" name="language" placeholder="{{ get_phrase('No special character or space is allowed. Valid examples: French, Spanish, Bengali etc') }}">

                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn ol-btn-primary">
                                            {{ get_phrase('Save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!----LANGUAGE ADDING FORM ENDS-->
                </div>

                <div class="tab-pane fade" id="cMessage" role="tabpanel" aria-labelledby="cMessage-tab">
                    <!----ADD NEW LANGUAGE---->
                    <div class="tab-pane p-3" id="import_language">
                        <div class="row">
                            <form action="{{ route('admin.language.import') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-8 fpb-7 mb-2">
                                    <label for="formFile" class="form-label ol-form-label">{{ get_phrase('Import your language files from here. (Ex: english.json)') }}</label>
                                    <input class="form-control ol-form-control" type="file" id="formFile" name="language_file" id="language_files" accept=".json" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn ol-btn-primary"> {{ get_phrase('Import') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!----LANGUAGE ADDING FORM ENDS-->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        "use strict";

        function updatePhrase(key, key_main) {
            $('#btn-' + key).text('...');
            var updatedValue = $('#phrase-' + key).val();
            var currentEditingLanguage = '<?php echo isset($current_editing_language) ? $current_editing_language : ''; ?>';
            $.ajax({
                type: "POST",
                url: "",
                data: {
                    updatedValue: updatedValue,
                    currentEditingLanguage: currentEditingLanguage,
                    key: key_main
                },
                success: function(response) {
                    $('#btn-' + key).html('<i class = "mdi mdi-check-circle"></i>');
                    success('<?php echo get_phrase('phrase_updated'); ?>');
                }
            });
        }

        function update_language_dir(language_id, dir) {
            $.ajax({
                type: 'post',
                url: '{{ route('admin.language.direction.update') }}',
                data: {
                    language_id: language_id,
                    direction: dir
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    success('{{ get_phrase('Direction has been updated') }}');
                }
            });
        }
    </script>
@endpush
