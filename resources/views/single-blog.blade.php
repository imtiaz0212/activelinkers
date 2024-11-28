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
@include('layouts.frontend-partial.breadcrumb')
<section>
    <div class="container max-w-4xl">
        <div class="sectionGap">
            <div class="aspect-video  block rounded-[20px] overflow-hidden">
                <img class="w-full h-full object-cover" src="{{ asset($info->featured_image) }}" width="370"
                    height="251" alt="{{ $info->title }}">
            </div>
            <div class="mt-10">
                <div class="space-y-4 mt-4 lg:mt-0">
                    <h2 class="sectionTitle lg:text-4xl">
                        {{ $info->title }}
                    </h2>
                    <div class="flex flex-col gap-2">

                        <div class="flex items-center mb-3 gap-2.5 text-lg">
                            <img src="{{ asset($info->userList->avatar) }}" alt="{{ $info->userList->name }}" width="35"
                                height="35" class="rounded-full">
                            <span class="text-[#212121] font-semibold">{{ $info->userList->name }}</span>
                        </div>

                        <div class="flex gap-5 text-sm">
                            <span class="flex items-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.66699 1.66675V4.16675" stroke="#908E8E" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M13.333 1.66675V4.16675" stroke="#908E8E" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M2.91699 7.57495H17.0837" stroke="#908E8E" stroke-width="1.5"
                                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M17.5 7.08341V14.1667C17.5 16.6667 16.25 18.3334 13.3333 18.3334H6.66667C3.75 18.3334 2.5 16.6667 2.5 14.1667V7.08341C2.5 4.58341 3.75 2.91675 6.66667 2.91675H13.3333C16.25 2.91675 17.5 4.58341 17.5 7.08341Z"
                                        stroke="#908E8E" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M13.0791 11.4167H13.0866" stroke="#908E8E" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M13.0791 13.9167H13.0866" stroke="#908E8E" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.99607 11.4167H10.0036" stroke="#908E8E" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.99607 13.9167H10.0036" stroke="#908E8E" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.91209 11.4167H6.91957" stroke="#908E8E" stroke-width="2"
                                        troke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.91209 13.9167H6.91957" stroke="#908E8E" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="uppercase">{{ !empty($info->created) ? date('M d, Y',
                                    strtotime($info->created)) : date('M d, Y') }}</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24" height="1em"
                                    width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 19C10.067 19 8.31704 18.2165 7.05029 16.9498L12 12L12 5C15.866 5 19 8.13401 19 12C19 15.866 15.866 19 12 19Z"
                                        fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12ZM21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                        fill="currentColor"></path>
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($info->created_at)->diffForhumans() }}</span>
                            </span>
                            <span class="flex items-center gap-2">
                                <svg class="h-5 w-5" stroke="currentColor" fill="currentColor" stroke-width="0"
                                    viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.5 7.25a.75.75 0 0 0-1.5 0v5.5c0 .27.144.518.378.651l3.5 2a.75.75 0 0 0 .744-1.302L12.5 12.315V7.25Z">
                                    </path>
                                    <path
                                        d="M12 1c6.075 0 11 4.925 11 11s-4.925 11-11 11S1 18.075 1 12 5.925 1 12 1ZM2.5 12a9.5 9.5 0 0 0 9.5 9.5 9.5 9.5 0 0 0 9.5-9.5A9.5 9.5 0 0 0 12 2.5 9.5 9.5 0 0 0 2.5 12Z">
                                    </path>
                                </svg>
                                <span>{{ $info->read_time }} min read</span>
                            </span>
                        </div>
                    </div>
                    <div
                        class="prose prose-h3:text-2xl prose-h3:text-darkblue prose-h3:font-semibold prose-h3 prose-h4:mt-4 prose-h4:text-xl prose-h4:font-medium prose-h4:mb-2 prose-h4:text-darkblue prose-p:text-[#627193] prose-p:text-lg prose-p:font-medium">
                        {!! $info->description !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- read more blogs part begins --}}
<section class="bg-gray-100 sectionGap">
    <div class="container">
        <div class="text-left mb-10">
            <h2 class="sectionTitle">Read more stories</h2>
        </div>
        @include('layouts.frontend-partial.recent-blog')
    </div>
</section>
{{-- read more blogs part begins --}}
@endsection