@extends('layouts.default')
@push('title', get_phrase('Bootcamps'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="eNtry-breadcum">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ get_phrase('Home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ get_phrase(' Article') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <h1 class="showing-text mt-15"></h1>
    </div>
<div class="">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-8 ">
            <h3 class="g-title">{{$article->topic_name}}</h3>
            <p class=" mt-3 mb-3 overflow-auto">{!! $article->description !!}</p>
            <hr>
                <span class="showing-text pe-3">{{get_phrase(' Share On :')}}</span>
                @if (get_frontend_settings('twitter') != '')
                    <a href="{{ get_frontend_settings('twitter') }}">
                        <i class="fa-brands fa-twitter pe-3"></i>
                    </a>
                @endif
                @if (get_frontend_settings('linkedin') != '')
                    <a href="{{ get_frontend_settings('linkedin') }}">
                        <i class="fa-brands fa-linkedin pe-3"></i>
                    </a>
                @endif
                @if (get_frontend_settings('facebook') != '')
                    <a href="{{ get_frontend_settings('facebook') }}">
                        <i class="fa-brands fa-square-facebook pe-3"></i>
                    </a>
                @endif
            </div>


            <div class="col-sm-12 col-md-4">
                <div class="shadow-sm p-4 rounded-3">
                    <div class="m-3">
                    @php
                        $topicks = App\Models\Knowledge_base_topick::where('knowledge_base_id', $title->id)->orderBy('updated_at', 'desc')->get();

                    @endphp
        
                    <h3 class="showing-text  pb-3">{{ ucwords($title->title) }}</h3>
                        @foreach($topicks as $topic)
                        <h4 ><a class="text-decoration-underline  {{$article->id == $topic->id ? 'text-primary' : '' }}" href="{{route('knowledge.base.article', ['id'=> $topic->id])}}">{{ucwords($topic->topic_name)}}</a></h4>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>>
</div>
@endsection
@push('js')@endpush