@extends('layouts.default')
@push('title', get_phrase('Bootcamps'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
<section class="breadcum-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="eNtry-breadcum">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase(' Knowledge Base') }}</li>
                        </ol>
                    </nav>
                    <h3 class="g-title">{{ get_phrase(' Knowledge Base') }}</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="eNtery-item d-flex h-100">
    <div class="container " >
        <div class=" row" >
            <div class=" col-sm-12 col-md-6 "  >
                @foreach($articles as $index => $article)
                @php

                    $devided_val = (count($articles) / 2) - 1;

                    if($index > $devided_val){
                    continue;
                    }

                @endphp
                <div class="accordion" id="accordionExample-{{ $index }}">
                    <div class=" mb-3 p-3 sidebar">
                        <div class="accordion-item ">
                            <h2 class="accordion-header" id="heading-{{ $index }}">
                                <button class="accordion-button p-3 @if($index !== 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index }}">{{ ucwords($article->title) }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $index }}" class="accordion-collapse collapse @if($index === 0) show @endif" aria-labelledby="heading-{{ $index }}" data-bs-parent="#accordionExample-{{ $index }}">
                                <div class="accordion-body">
                                @php
                                    $topics = App\Models\Knowledge_base_topick::where('knowledge_base_id', $article->id)->orderBy('updated_at', 'desc')->get();
                                @endphp
                                        <ul>
                                            @foreach($topics as $key => $topic)
                                                <li class="topic-name" id="topic-name-{{$key}}">
                                                    <a href="{{ route('knowledge.base.article', ['id' => $topic->id]) }}">
                                                        {{ ucwords($topic->topic_name) }}
                                                    </a>
                                                </li>
                                                <hr>
                                            @endforeach
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>     
                </div> 
                @endforeach              
            </div>
            <div class=" col-sm-12 col-md-6 "  >
                @foreach($articles as $index => $article)
                @php

                    $devided_val = (count($articles) / 2) - 1;

                    if($index <= $devided_val){
                    continue;
                    }
                    
                @endphp
                <div class="accordion" id="accordionExample-{{ $index }}">
                    <div class=" mb-3 p-3 sidebar">
                        <div class="accordion-item ">
                            <h2 class="accordion-header" id="heading-{{ $index }}">
                                <button class="accordion-button p-3 @if($index !== 0) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse-{{ $index }}">{{ ucwords($article->title) }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $index }}" class="accordion-collapse collapse @if($index === 0) show @endif" aria-labelledby="heading-{{ $index }}" data-bs-parent="#accordionExample-{{ $index }}">
                                <div class="accordion-body">
                                @php
                                    $topics = App\Models\Knowledge_base_topick::where('knowledge_base_id', $article->id)->orderBy('updated_at', 'desc')->get();
                                @endphp
                                        <ul>
                                            @foreach($topics as $key => $topic)
                                                <li class="topic-name" id="topic-name-{{$key}}">
                                                    <a href="{{ route('knowledge.base.article', ['id' => $topic->id]) }}">
                                                        {{ ucwords($topic->topic_name) }}
                                                    </a>
                                                </li>
                                                <hr>
                                            @endforeach
                                        </ul>
                                </div>
                            </div>
                        </div>
                    </div>     
                </div> 
                @endforeach              
            </div>
            {{$articles->links()}}
        </div>
            @if ($articles->count() == 0)
            <div class="col-12 bg-white radius-10 py-5">
                @include('frontend.default.empty')
            </div>
            @endif
    </div>
</div>
{{-- <script>
    const topicName =document.querySelectorAll('.topic-name');
    for(let i = 0; i < topicName.length; i++){
        const topicNameId =document.querySelectorAll(`#topic-name-${i}`);
    

    }    for(let v =0; v < topicNameId.length; v++){
            console.log(v)

        }
  </script> --}}


@endsection
@push('js')@endpush
