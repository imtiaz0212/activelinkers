@extends('layouts.frontend')
@section('headerMeta')
<?php
    $metaTitle = $metaDescription = $metaKeywords = strFilter(config('app.name'));
    $metaImage = 'images/website.png';
    if (!empty($info)) {
        $metaTitle = $info->meta_title;
        $metaDescription = $info->meta_description;
        $metaKeywords = $info->meta_tag;
        $metaImage = !empty($info->meta_image) ? $info->meta_image : $metaImage;
    } elseif (!empty($siteInfo)) {
        $metaTitle = $siteInfo->meta_title;
        $metaDescription = $siteInfo->meta_description;
        $metaKeywords = $siteInfo->meta_tag;
        $metaImage = !empty($siteInfo->meta_image) ? $siteInfo->meta_image : $metaImage;
    }
    ?>
<title>{{ $metaTitle }}</title>

<meta name="title" content="{{ $metaTitle }}">
<meta name="description" content="{{ $metaDescription }}">
<meta name="keywords" content="{{ $metaKeywords }}">

<meta name='og:title' content="{{ $metaTitle }}">
<meta name='og:image' content="{{ asset( $metaImage) }}">
<meta name='og:site_name' content="{{ $metaTitle }}">
<meta name='og:description' content="{{ $metaDescription }}">
@endsection

@section('content')
@if ($info->status == 'publish')
<!-- Page Title -->
@include('layouts.frontend-partial.breadcrumb')
<!-- History Section -->
<div class="container">
    {{-- @if (!empty($info->featured_image))
    <div class="aspect-[370/251] block rounded-[20px] overflow-hidden">
        <img class="w-full h-full object-cover" src="{{ asset($info->featured_image) }}" width="370" height="251"
            alt="feature image">
    </div>
    @endif --}}
    <div
        class="py-10 prose prose-headings:mt-[.8em] prose-headings:md:mt-[1.2em] prose-headings:mb-[.2em] prose-headings:text-darkblue prose-headings:md:mb-[.5em] prose-p:my-[.5em] prose-p:md:my-[.8em] prose-ul:my-[.5em] prose-ul:md:my-[.8em]">
        {!! $info->description !!}
    </div>
</div>
@else
<h4>This page is under construction.</h4>
@endif
@endsection
