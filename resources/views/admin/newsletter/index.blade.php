@extends('layouts.admin')
@push('title', get_phrase('Newsletter'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Newsletter') }}
                </h4>

                <a onclick="ajaxModal('{{ route('modal', ['admin.newsletter.create']) }}', '{{ get_phrase('Add Newsletter') }}')" href="#" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add Newsletter') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="accordion" class="custom-accordion mb-4">
                <div class="ol-card p-20px">
                    <div class="ol-card-body">
                        <ul class="ol-my-accordion">
                            @if (count($newsletters) > 0)
                                @foreach ($newsletters as $key => $newsletter)
                                <li class="single-accor-item">
                                    <div class="accordion-btn-wrap">
                                        <div class="accordion-btn-title d-flex align-items-center">
                                            <img src="assets/images/icons/firstline-gray-16.svg" alt="">
                                            <h4 class="title">{{ $key+1 }}. {{ $newsletter->subject }}</h4>
                                        </div>
                                        <div class="accordion-button-buttons">
                                            <a onclick="ajaxModal('{{ route('modal', ['admin.newsletter.send', 'id' => $newsletter->id]) }}', '{{ get_phrase('Send newsletter') }}')" data-bs-toggle="tooltip" title="{{ get_phrase('Send Newsletter') }}" href="#" class="edit"><span class="fi-rr-paper-plane"></span></a>
                                            <a onclick="ajaxModal('{{ route('modal', ['admin.newsletter.edit', 'id' => $newsletter->id]) }}', '{{ get_phrase('Edit Newsletter') }}')" data-bs-toggle="tooltip" title="{{ get_phrase('Edit') }}" href="#" class="edit"><span class="fi fi-rr-pen-clip"></span></a>
                                            <a onclick="confirmModal('{{ route('admin.newsletter.delete', $newsletter->id) }}')" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" href="#" class="delete"><span class="fi-rr-trash"></span></a>
                                        </div>
                                    </div>
                                    <div class="accoritem-body d-hidden">
                                        <div class="py-10px">
                                            {!! removeScripts($newsletter->description) !!}
                                        </div>
                                    </div>
                                </li>
                                @endforeach

                                @if (count($newsletters) > 0)
                                    <div
                                        class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                        <p class="admin-tInfo">
                                            {{ get_phrase('Showing') . ' ' . count($newsletters) . ' ' . get_phrase('of') . ' ' . $newsletters->total() . ' ' . get_phrase('data') }}
                                        </p>
                                        {{ $newsletters->links() }}
                                    </div>
                                @endif
                            @else
                                @include('admin.no_data')
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

    <script type="text/javascript">
        "use strict";
        
        function stopProp(event) {
            event.stopPropagation();
        }
    </script>
@endpush
