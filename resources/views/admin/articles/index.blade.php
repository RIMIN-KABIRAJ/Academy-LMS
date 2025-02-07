@extends('layouts.admin')
@push('title', get_phrase('Knowledge_base'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-settings-sliders me-2"></i>
                {{$articleTitle->title}}
            </h4>
                
                <a href="{{ route('admin.articles.create',['id'=>$articleTitle->id]) }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span>{{ get_phrase('Add Article') }}</span>
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
                         @if (count($articles) > 0)

                            @foreach ($articles as $key => $article)
                            <li class="single-accor-item">
                                 <div class="accordion-btn-wrap">
                                    <div class="accordion-btn-title d-flex align-items-center">
                                        <img src="assets/images/icons/firstline-gray-16.svg" alt="">
                                        <h3 class="title">{{ $key+1 }}. {{ $article->topic_name }}</h3>
                                    </div>
                                    <div class="accordion-button-buttons">
                                        <a onclick="ajaxModal('{{ route('modal', ['admin.articles.edit', 'id' => $article->id]) }}', '{{ get_phrase('Edit Articles') }}')" data-bs-toggle="tooltip" title="{{ get_phrase('Edit') }}" href="#" class="edit"><span class="fi fi-rr-pen-clip"></span></a>
                                        <a onclick="confirmModal('{{ route('admin.articles.delete', $article->id) }}')" data-bs-toggle="tooltip" title="{{ get_phrase('Delete') }}" href="#" class="delete"><span class="fi-rr-trash"></span></a>
                                    </div>
                                </div>
                                <div class="accoritem-body d-hidden">
                                    <div class="py-10px">
                                        {!! removeScripts($article->description) !!}
                                    </div>
                                </div>
                            </li>
                            @endforeach

                            @if (count($articles) > 0)
                                <div
                                    class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                                    <p class="admin-tInfo">
                                        {{ get_phrase('Showing') . ' ' . count($articles) . ' ' . get_phrase('of') . ' ' . $articles->total() . ' ' . get_phrase('data') }}
                                    </p>
                                    {{ $articles->links() }}
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

