@extends('layouts.default')
@push('title', get_phrase('Home'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    @php
        $builder = App\Models\Builder_page::where('id', $page_id)->firstOrNew();
    @endphp
    @if($builder->is_permanent)
        @include('components.home_permanent_templates.'.$builder->identifier)
    @else
        @php $builder_files = $builder->html ? json_decode($builder->html, true) : []; @endphp
        @foreach ($builder_files as $builder_file_name)
            @include('components.home_made_by_builder.'.$builder_file_name)
        @endforeach
    @endif
@endsection
