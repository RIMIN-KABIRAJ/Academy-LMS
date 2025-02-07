@extends('layouts.admin')
@push('title', get_phrase('Multi language setting'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Edit ____ phrases', [$language->name]) }}
                </h4>

                <a href="{{ route('admin.language.phrase.import', ['lan_id' => $language->id]) }}" class="ms-auto btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-cloud-upload"></span>
                    <span>{{ get_phrase('Import all phrases from english') }}</span>
                </a>
                <a href="{{ route('admin.manage.language') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-alt-left"></span>
                    <span>{{ get_phrase('Back') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-primary" role="alert">
                The symbol ___ represents dynamic values that will be replaced dynamically. So, do not remove the ___ symbol.
            </div>
        </div>
        @foreach ($phrases as $phrase)
            <div class="col-md-4 mb-3">
                <div class="ol-card p-4">
                    <div class="ol-card-body translation-fields">
                        <label class="ol-form-label" for="translated_phrase_{{ $phrase->id }}">{{ $phrase->phrase }}</label>
                        <input type="text" id="translated_phrase_{{ $phrase->id }}" value="{{ $phrase->translated }}" class="form-control ol-form-control">
                        <button type="button" onclick="updatePhrase({{ $phrase->id }})" class="btn ol-btn-primary mt-3 update-translation-fields">{{ get_phrase('Update') }}</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        "use strict";

        function replaceInputData(){
            $('.translation-fields:not(.added)').each(function(index){
                var element = $(this);
                var translated_text = element.find('label').text();
                element.find('input').val(translated_text);
                element.addClass('added');
                console.log(translated_text)
            });
        }

        function replaceInputDataUpdate(){
            $('.update-translation-fields').each(function(index){
                var element = $(this);
                setTimeout(function(){
                    element.trigger('click');
                    element.addClass('d-none');
                }, index * 1000); // index * 1000 will delay each by 1 second
            });
        }
        

        function updatePhrase(phrase_id) {
            var translated_phrase = $('#translated_phrase_' + phrase_id).val();
            $.ajax({
                type: "POST",
                url: `{{ route('admin.language.phrase.update') }}/${phrase_id}`,
                data: {
                    translated_phrase: translated_phrase
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    success('{{ get_phrase('Phrase updated') }}');
                }
            });
        }
    </script>
@endpush
