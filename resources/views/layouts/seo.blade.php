<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="x-ua-compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

{{ config(['app.name' => get_settings('system_title')]) }}

@php
    //print SEO field values from database 'seo_field table', based on current route
    $current_route = Route::currentRouteName();
    $seo_field = App\Models\SeoField::where('name_route', $current_route);
    
    if($current_route == 'course.details' && isset($course_details)){
        $seo_field->where('course_id', $course_details->id ?? '');
    }
    if($current_route == 'blog.details' && isset($blog_details)){
        $seo_field->where('blog_id', $blog_details->id ?? '');
    }

    $seo_field = $seo_field->firstOrNew();
@endphp

@if (!empty($seo_field['meta_title']))
    <title>{{ $seo_field['meta_title'] }}</title>
@else
    <title>@stack('title') | {{ config('app.name') }}</title>
@endif
<meta name="keywords" content="{{ $seo_field['mets_keywords'] ?? '' }}">
<meta name="description" content="{{ $seo_field['meta_description'] ?? '' }}">
<meta name="robots" content="{{ $seo_field['meta_robot'] ?? '' }}">
<link rel="canonical" href="{{ $seo_field['canonical_url'] ?? '' }}" />
<link rel="custom" href="{{ $seo_field['custom_url'] ?? '' }}" />
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="{{$seo_field['meta_title'] ?? ''}}">

{!! removeScripts($seo_field['json_ld'] != strip_tags($seo_field['json_ld']) ? $seo_field['json_ld']:'') !!}

<meta property="og:title" content="{{ $seo_field['og_title'] ?? '' }}" />
<meta property="og:description" content="{{ $seo_field['og_description'] ?? '' }}" />
<meta property="og:image" content="{{ get_image($seo_field['og_image'] ?? '') }}" />
