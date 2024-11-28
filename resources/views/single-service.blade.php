@extends('layouts.frontend')
@section('headerMeta')
<?php
        $metaTitle = $metaDescription = $metaKeywords = strFilter(config('app.name'));
        $metaImage = 'images/website.png';
        if (!empty($info)) {
            $metaTitle = !empty($info->meta_title) ? $info->meta_title : $info->title;
            $metaDescription = $info->meta_description;
            $metaKeywords = '';

            $allTags = json_decode($info->tags);
            if(!empty($allTags)){
                foreach ($allTags as $value) {
                    $metaKeywords .= $value . ', ';
                }
            }
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
@include('layouts.frontend-partial.breadcrumb')

<section class="sectionGap">
    <div class="container ">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-20 mt-4 lg:mt-8 mb-5 lg:mb-10">
            <div class="space-y-3">
                <h1 class="sectionTitle mb-2">
                    {{ !empty($info->title) ? $info->title : '' }}
                </h1>

                <p>{{ !empty($info->subtitle) ? $info->subtitle : '' }}</p>

                <div>
                    {{ !empty($info->short_description) ? $info->short_description : '' }}
                    <p>{{ !empty($info->tag_title) ? $info->tag_title : '' }}</p>
                </div>

                @if (!empty($info->tags) && $info->tags != 'null')
                @php($feature = json_decode($info->tags))
                <ul
                    class="grid {{ count($feature) > 10 ? 'lg:grid-cols-3 md:grid-cols-2' : (count($feature) > 5 ? ' md:grid-cols-2' : 'grid-cols-1') }} ">
                    @foreach ($feature as $tag)
                    <li
                        class="relative text-lg pl-6 after:absolute after:content-['✔'] after:text-white after:text-[10px] after:flexCenter after:h-4 after:w-4 after:bg-darkblue after:left-0 after:top-1 after:rounded-full mb-[10px]">
                        {{ !empty($tag) ? $tag : '' }}
                    </li>
                    @endforeach
                </ul>
                @endif

                <div class="lg:pt-5 ">
                    <a class="primary-btn" data-text="Get Started" href="{{ url('contact') }}" title="service button">
                        Get Started
                    </a>
                </div>
            </div>

            <div>
                @if (!empty($info->images))
                <img draggable="false" (dragstart)="false;" class=" stopdraggable" src="{{ asset($info->images) }}"
                    loading="lazy" alt="{{ $info->tag_title }}">
                @endif
            </div>
        </div>

        <div
            class="prose-ul:p-0 prose-ol:p-0  prose-ol:grid prose-ul:grid lg:prose-ul:grid-cols-2 lg:prose-ol:grid-cols-2 prose-ul:gap-x-24 prose-li:pb-1 prose-ul:pt-4 prose-ul:pb-6 lg:prose-ul:pb-10 prose-h1:serviceSubTitle  prose-h2:serviceSubTitle  prose-h3:serviceSubTitle  prose-h3:text-3xl prose-h4:text-2xl prose-h5:text-xl  prose-li:list-disc prose-ol:list-inside  prose-ul:list-inside prose-h1:font-inter prose-h2:font-inter prose-h3:font-inter prose-h4:font-inter prose-li:mb-2 prose-p:mb-2">
            {!! (!empty($info->description) ? $info->description : "") !!}
        </div>
    </div>
</section>

{{-- Pricing Section --}}
@include('layouts.frontend-partial.pricing')

@endsection