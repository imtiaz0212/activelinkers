@extends('layouts.frontend')
@section('headerMeta')
<?php
    $metaTitle = $metaDescription = $metaKeywords = strFilter(config('app.name'));
    $metaImage = 'images/website.png';
    if (!empty($info)) {
        $metaTitle = !empty($info->meta_title) ? $info->meta_title : $siteInfo->meta_title;
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

<section class="sectionGap">
    <div class="container">
        <div class="relative lg:grid grid-cols-12  gap-10 xl:gap-[100px] items-center">
            <img class="absolute animate-updown -left-8 -z-10 -top-7 hidden xl:block"
                src="{{ asset('public') }}/images/about/footer-top-bg.svg" alt="about us top image" loading="lazy">

            <div class=" lg:col-span-6 ">
                <div class="overflow-hidden relative">
                    @if (!empty($info->images))
                    <img class="aspect-[494/541] w-full !max-w-[494px] mx-auto rounded-[20px]" rel="preload"
                        fetchpriority="high" src="{{ asset($info->images) }}" alt="about us top image" width="500"
                        height="470">
                    @endif

                    <div
                        class="absolute top-1/2 -translate-y-1/2 right-0 flex items-center gap-4 border-primary/20 border bg-white rounded-xl p-[15px_25px_15px_15px] shadow-[rgba(0,0,0,0.1)_-4px_0px_25px_-6px]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 50 50" fill="none">
                            <path
                                d="M9.08205 10.5955L10.5371 13.6033L13.8379 14.0525C14.4922 14.1404 14.7266 14.9509 14.2774 15.3806L11.8653 17.6951L12.461 20.9763C12.5781 21.6209 11.8946 22.1091 11.3281 21.7966L8.38869 20.2146L5.44924 21.7966C4.88283 22.0994 4.16994 21.6306 4.32619 20.9275L4.91213 17.6853L2.50002 15.3709C2.03127 14.9216 2.28518 14.1209 2.94924 14.033L6.24026 13.5837L7.69533 10.5759C7.96877 9.99976 8.80862 10.0095 9.08205 10.5955ZM9.31643 14.658L8.38869 12.7244L7.45119 14.658C7.34377 14.8826 7.11916 15.0584 6.85549 15.0974L4.73635 15.3806L6.28908 16.865C6.46486 17.0408 6.56252 17.2947 6.51369 17.5584L6.13283 19.6677L8.00783 18.6619C8.23244 18.5447 8.51565 18.5252 8.75002 18.6619L10.6348 19.6775L10.2637 17.6072C10.2051 17.3533 10.2735 17.0701 10.4785 16.865L12.0313 15.3806L9.93166 15.0974C9.67776 15.0681 9.43362 14.9021 9.31643 14.658ZM25.7031 3.51539L27.1582 6.5232L30.4688 6.97242C31.1231 7.06031 31.3574 7.87086 30.9082 8.31031L28.4961 10.6248L29.0918 13.906C29.209 14.5505 28.5254 15.0388 27.959 14.7263L25 13.1443L22.0606 14.7263C21.4942 15.0291 20.7813 14.5603 20.9375 13.8572L21.5235 10.615L19.1016 8.30054C18.6328 7.85133 18.8867 7.05054 19.5508 6.96265L22.8418 6.51344L24.2969 3.51539C24.5899 2.91969 25.4199 2.92945 25.7031 3.51539ZM25.9375 7.57789L25 5.64429L24.0723 7.57789C23.9649 7.8025 23.7403 7.97828 23.4766 8.01734L21.3477 8.30054L22.9004 9.78492C23.086 9.9607 23.1738 10.2146 23.125 10.4783L22.7442 12.5877L24.6289 11.5818C24.8535 11.4646 25.127 11.4451 25.3711 11.5818L27.2559 12.5974L26.8848 10.5271C26.8262 10.2732 26.8946 9.99 27.0996 9.78492L28.6524 8.30054L26.5528 8.00758C26.2891 7.98804 26.0547 7.82203 25.9375 7.57789ZM42.3145 10.5955L43.7696 13.6033L47.0703 14.0525C47.7246 14.1404 47.9688 14.9509 47.5098 15.3806L45.0977 17.6951L45.6934 20.9763C45.8106 21.6209 45.127 22.1091 44.5606 21.7966L41.6211 20.2146L38.6817 21.7966C38.1153 22.0994 37.4024 21.6306 37.5489 20.9275L38.1348 17.6853L35.7227 15.3709C35.2539 14.9216 35.5078 14.1209 36.1719 14.033L39.4629 13.5837L40.918 10.5759C41.2012 9.99976 42.041 10.0095 42.3145 10.5955ZM42.5489 14.658L41.6211 12.7244L40.6836 14.658C40.5762 14.8826 40.3614 15.0584 40.0879 15.0974L37.9688 15.3806L39.5117 16.865C39.6875 17.0408 39.7852 17.2947 39.7364 17.5584L39.3555 19.6677L41.2403 18.6619C41.4649 18.5447 41.7481 18.5252 41.9824 18.6619L43.877 19.6775L43.5059 17.6072C43.4473 17.3533 43.5156 17.0701 43.7207 16.865L45.2637 15.3806L43.1641 15.0974C42.9102 15.0681 42.666 14.9021 42.5489 14.658ZM21.377 30.5369C21.1621 30.1658 21.2891 29.6873 21.6602 29.4724C22.0313 29.2576 22.5098 29.3845 22.7246 29.7556L23.75 31.533L27.3926 27.8904C27.6953 27.5877 28.1934 27.5877 28.4961 27.8904C28.7988 28.1931 28.7988 28.6912 28.4961 28.9939L24.1309 33.3591C23.7696 33.7205 23.1641 33.6423 22.9102 33.2029L21.377 30.5369ZM25 22.2849C29.2481 22.2849 32.6953 25.7322 32.6953 29.9802C32.6953 34.2283 29.2481 37.6755 25 37.6755C20.752 37.6755 17.3047 34.2283 17.3047 29.9802C17.3047 25.7322 20.752 22.2849 25 22.2849ZM29.336 25.6443C26.9434 23.2517 23.0567 23.2517 20.6641 25.6443C18.2715 28.0369 18.2715 31.9236 20.6641 34.3162C23.0567 36.7087 26.9434 36.7087 29.336 34.3162C31.7285 31.9138 31.7285 28.0369 29.336 25.6443ZM25 17.4509C31.9141 17.4509 37.5196 23.0564 37.5196 29.9705C37.5196 32.5877 36.7188 35.0193 35.3418 37.031L39.0821 43.5056C39.4434 44.1111 38.9453 44.7947 38.3008 44.697L34.4727 44.0916L32.4219 46.6111C32.0606 47.0798 31.3867 47.0017 31.1231 46.533L28.5059 42.0017C26.2207 42.6658 23.7696 42.6658 21.4942 42.0017L18.877 46.533C18.6133 47.0017 17.9395 47.0798 17.5781 46.6111L15.5274 44.0916L11.6992 44.697C11.0449 44.8045 10.586 44.0916 10.8985 43.5349L14.6582 37.031C11.2598 32.0603 11.8946 25.3709 16.1524 21.113C18.4082 18.8572 21.543 17.4509 25 17.4509ZM34.3067 38.3494C33.1153 39.6775 31.6504 40.742 29.9903 41.4646L31.9043 44.7752L33.5449 42.7634C33.7305 42.5291 34.0137 42.4412 34.2871 42.49L36.9239 42.9099L34.3067 38.3494ZM20 41.4646C18.3496 40.742 16.8848 39.6775 15.6934 38.3591L13.0664 42.9099L15.7031 42.49C15.9668 42.4412 16.2598 42.5388 16.4453 42.7634L18.086 44.7752L20 41.4646ZM32.7539 22.2263C28.4766 17.949 21.5332 17.949 17.2559 22.2263C12.9785 26.5037 12.9785 33.447 17.2559 37.7244C21.543 42.0017 28.4766 42.0017 32.7539 37.7244C37.0313 33.447 37.0313 26.5037 32.7539 22.2263Z"
                                fill="url(#paint0_linear_194_2713)"></path>
                            <defs>
                                <linearGradient id="paint0_linear_194_2713" x1="25.003" y1="3.07227" x2="25.003"
                                    y2="46.926" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FE4139"></stop>
                                    <stop offset="1" stop-color="#FFBE36"></stop>
                                </linearGradient>
                            </defs>
                        </svg>


                        <div>
                            <span class="text-4xl text-secondary font-bold">{{ !empty($info->reach_percent) ?
                                $info->reach_percent : '' }}</span>
                            <h2 class="text-base text-[#757575] mt-1">
                                {{ !empty($info->reach) ? $info->reach : '' }}
                            </h2>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-6">
                <p class="sectionSub">ABOUT US</p>

                <h2 class="sectionTitle">
                    {!! !empty($info->title) ? $info->title : '' !!}
                </h2>

                <div class="mt-4 lg:mb-9  prose-ul:columns-2 prose-ul:mt-6 prose-ul:space-y-2 prose-list">
                    {!! !empty($info->short_description) ? $info->short_description : '' !!}
                </div>

                <a class="primary-btn" data-text="Contact Us" href="{{ url('contact') }}" title="Contact Us">Contact
                    Us</a>
            </div>
        </div>
        <div class="prose prose-headings:max-md:mt-[1em] ">
            {!! !empty($info->description) ? $info->description : '' !!}
        </div>
    </div>
</section>

<section class="relative bg-[#F6F6F6] mt-5 md:mt-10 lg:mt-auto z-[1] sectionGap">
    <div class="container">
        <div class="sectionDiv">
            <p class="sectionSub mb-2">Our Advantage</p>
            <h2 class="sectionTitle">We provide best service of <span>consumers choices.</span></h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-[30px]">
            @php($advantage = json_decode($info->advantage))
            @if (!empty($advantage))
            @foreach ($advantage as $key => $items)
            {{-- Advantage Card --}}
            <div class="p-4 md:p-[30px] group rounded-xl border border-[#E7E7E7] bg-white">
                <div class="max-h-20 max-w-20 text-primary">{!! !empty($items->icon) ? $items->icon : '' !!}</div>

                <div class=" md:space-y-3 mt-2 md:mt-5 leading-[30px]">
                    <h2 class="font-semibold group-hover:text-secondary duration-200 text-2xl text-darkblue">{{
                        !empty($items->title)
                        ?
                        $items->title : '' }}
                    </h2>
                    <p class="text-lg">{{ !empty($items->description) ? $items->description : '' }}</p>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <img class="absolute animate-updown z-[-1] top-4 left-6 opacity-5"
        src="{{ asset('public') }}/images/about/advantage-up.png" alt="advantage us top image">
    <img class="absolute animate-updown z-[-1] top-[141px] left-6 opacity-5"
        src="{{ asset('public') }}/images/about/advantage-down.png" alt="advantage us top image">
</section>

{{-- Team section start --}}
<section class="sectionGap relative">
    <div class="container">
        <div class="sectionDiv">
            <p class="sectionSub">Our Team</p>
            <h2 class="sectionTitle">
                Our brilliant team of <span>{{$siteInfo->site_name}}</span>
            </h2>
        </div>
        <div class="swiper team-slider">
            <div class="swiper-wrapper">
                @if (!empty($teamlist) && $teamlist->isNotEmpty())
                @foreach ($teamlist as $key => $team)
                <div class="swiper-slide">
                    @if (!empty($team->image))
                    <div class="aspect-[270/299]">
                        <img class="rounded-lg size-full object-cover" src="{{ asset($team->image) }}"
                            alt="{{ $team->name }}" width="270" height="299" loading="lazy">
                    </div>
                    @endif
                    <div class="md:pr-2 mt-4 text-center">
                        <h4 class="text-base md:text-xl text-darkblue font-medium">
                            {{ !empty($team->name) ? $team->name : '' }}
                        </h4>
                        <p class="text-sm text-primary">
                            {{ !empty($team->designation) ? $team->designation : '' }}</p>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
{{-- Team section end --}}

@include('layouts.frontend-partial.cta-area')

@endsection

@push('footerPartial')
<style>
    .cta-area {
        padding: 0 !important;
    }

    #uploaded-btn {
        overflow: hidden;
        padding: 10px 16px;
        font-weight: 600;
        background-color: #BCEC00;
        color: #1D1C1C;
        display: inline-block;
        border-radius: 50px;
        font-size: 16px;
        margin-bottom: none;
        line-height: 1;
    }

    #uploaded-btn:hover {
        background-color: #00005c;
        color: white;
        transition: .5s;
    }

    @media screen and (min-width: 600px) {
        #uploaded-btn {
            margin-bottom: 30px;
            padding: 15px 40px;
        }
    }
</style>
<script>
    var teamSlider = new Swiper(".team-slider", {
            loop: true,
            autoplay: true,
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
                1300: {
                    slidesPerView: 5,
                },
            },
        });
</script>
@endpush