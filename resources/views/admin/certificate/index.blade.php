@extends('layouts.admin')
@push('title', get_phrase('Certificate'))
@push('meta')@endpush
@push('css')
    <style>
        .remove-item,
        .ui-resizable-handle {
            display: none !important;
        }

        .certificate-layout-module {
            left: unset !important;
            top: unset !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
    </style>
@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Certificate') }}
                </h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="ol-card p-4">
                <p class="title text-14px mb-3">{{ get_phrase('Certificate template') }}</p>
                <div class="ol-card-body certificate_builder_view" id="certificate_builder_view">
                    @php
                        $htmlContent = get_settings('certificate_builder_content');
                        // Use regex to update the src attribute of the <img> tag with the class 'certificate-template'.
                        $newSrc = get_image(get_settings('certificate_template'));
                        $certificate_builder_content = preg_replace('/(<img[^>]*class=["\']certificate-template["\'][^>]*src=["\'])([^"\']*)(["\'])/i', '${1}' . $newSrc . '${3}', $htmlContent);
                    @endphp
                    {!! $certificate_builder_content !!}
                    <a class="btn ol-btn-primary mt-3" href="{{ route('admin.certificate.builder') }}">{{ get_phrase('Build your certificate') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ol-card p-4">
                <p class="title text-14px mb-3">{{ get_phrase('Certificate template') }}</p>
                <div class="ol-card-body">
                    <form action="{{ route('admin.certificate.update.template') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group text-start mb-3">
                            <img class="my-2" height="200px" src="{{ get_image(get_settings('certificate_template')) }}" alt="">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label ol-form-label" for="certificate_template">{{ get_phrase('Upload your certificate template') }}</label>
                            <input type="file" class="form-control" name="certificate_template" id="certificate_template"rows="4">
                        </div>
                        <div class="form-group">
                            <button class="btn ol-btn-primary" type="submit">{{ get_phrase('Upload') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";

        $(function() {
            var certificate_builder_view_width = $('.certificate_builder_view').width();
            var certificate_layout_module = $('.certificate_builder_view .certificate-layout-module').width();
            var zoomScaleValue = ((certificate_builder_view_width / certificate_layout_module) * 100) - 8;
            $('.certificate_builder_view .certificate-layout-module').css('zoom', zoomScaleValue + '%');
        });
    </script>
@endpush
