@extends('layouts.frontend')
@section('content')

{{-- ==================================================== Hero Sections Begins ==================================== --}}
@include('layouts.frontend-partial.slider')
{{-- ==================================================== Hero Sections ends ==================================== --}}

{{-- ==================================================== About Sections Begins ====================================
--}}
@if (!empty($aboutUs))

<section class="sectionGap">
    <div class="container">
        <div class="relative lg:grid grid-cols-12  gap-10 xl:gap-[100px] items-center">
            <img class="absolute animate-updown -left-8 -z-10 -top-7 hidden xl:block"
                src="{{ asset('public') }}/images/about/footer-top-bg.svg" alt="about us top image" loading="lazy">

            <div class=" lg:col-span-6 ">
                <div class="overflow-hidden relative">
                    @if (!empty($aboutUs->images))
                    <img class="aspect-[494/541] w-full !max-w-[494px] mx-auto rounded-[20px]" rel="preload"
                        fetchpriority="high" src="{{ asset($aboutUs->images) }}" alt="about us top image" width="500"
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
                            <span class="text-4xl text-secondary font-bold">{{ !empty($aboutUs->reach_percent) ?
                                $aboutUs->reach_percent : '' }}</span>
                            <h2 class="text-base text-[#757575] mt-1">
                                {{ !empty($aboutUs->reach) ? $aboutUs->reach : '' }}
                            </h2>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-6">
                <span class="sectionSub">ABOUT US</span>

                <h2 class="sectionTitle">
                    {!! !empty($aboutUs->title) ? $aboutUs->title : '' !!}
                </h2>

                <div class="mt-4 lg:mb-9  prose-ul:columns-2 prose-ul:mt-6 prose-ul:space-y-2 prose-list">
                    {!! !empty($aboutUs->short_description) ? $aboutUs->short_description : '' !!}
                </div>

                <a class="primary-btn" data-text="About Us" href="{{ url('about-us') }}" title="About Us">About Us</a>
            </div>
        </div>
    </div>
</section>
@endif
{{-- ==================================================== About Sections ends ==================================== --}}

{{-- ==================================================== Statistics section Begins ====================================
--}}
@include('layouts.frontend-partial.statistics')
{{-- ==================================================== Statistics section ends ====================================
--}}

{{-- ==================================================== Service Sections Begins ====================================
--}}
@if (!empty($headerServiceList) && $headerServiceList->isNotEmpty())
<section class="sectionGap relative" id="allService">
    <img class="absolute left-0 top-0" src="{{ asset('public') }}/images/service-bg.png" alt="" loading="lazy">

    <div class="container">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-[30px]">
            <div>
                <p class="sectionSub">
                    Service we provide
                </p>
                <h2 class="sectionTitle mb-6 mt-2">Our SEO Agency To Achieve Goals</h2>
                <a href="{{ url('services') }}" data-text="View All Services" class="primary-btn ">
                    View All Services
                </a>
            </div>

            @if (!empty($headerServiceList) && $headerServiceList->isNotEmpty())
            @foreach ($headerServiceList as $service)
            <div
                class="group hover:-translate-y-4 border duration-500 shadow-[rgba(0,0,0,0.1)_-4px_0px_25px_-6px] rounded-lg p-6 md:p-[30px]">
                <div class="text-primary size-20 text-6xl bg-contain  bg-no-repeat"
                    style="background-image: url({{ asset('public') }}/images/service-icon-shape.webp)">
                    {!! !empty($service->icon) ? $service->icon : '' !!}
                </div>

                <h3
                    class="text-darkblue text-2xl font-semibold leading-[32px] my-2 md:mt-5 md:mb-3 duration-300 group-hover:text-secondary">
                    {{ !empty($service->serviceCategory->name) ? $service->serviceCategory->name : '' }}
                </h3>

                <p class="text-[#718a96] text-base font-inter font-normal line-clamp-4">
                    {{ !empty($service->short_description) ? $service->short_description : '' }}
                </p>

                <a class="duration-300 text-[#718A96] font-medium underline text-lg group-hover:visible flex items-center gap-2 hover:text-secondary mt-4"
                    href="{{ url('service', $service->page_url) }}">
                    Learn more
                </a>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
@endif
{{-- ==================================================== Service Sections ends ====================================
--}}

{{-- ==================================================== Why Choose Us Sections Begins
==================================== --}}
@include('layouts.frontend-partial.why-us')
{{-- =================================================== Why Choose Us Sections ends
==================================== --}}

{{-- ==================================================== Services Details Sections Begins
==================================== --}}
@if (!empty($headerServiceList) && $headerServiceList->isNotEmpty())
<section class="sectionGap">
    <div class="container">
        <div class="flex flex-col gap-10 md:gap-20 lg:gap-32">
            @foreach ($headerServiceList as $service)
            <div
                class="group relative space-y-8 lg:space-y-0 lg:grid grid-cols-12 items-start lg:items-center gap-10 xl:gap-[100px]">
                @if (!empty($service->images))
                <img class="absolute animate-updown group-even:-right-8 group-odd:-left-8 -z-10 -top-7 hidden xl:block"
                    src="{{ asset('public') }}/images/about/footer-top-bg.svg" alt="about us top image">
                @endif

                <div class="mt-10 lg:mt-0 lg:col-span-6 group-odd:order-1 ">
                    <p class="sectionSub mb-2">
                        {{ !empty($service->serviceCategory->name) ? $service->serviceCategory->name : '' }}
                    </p>

                    <h2 class="sectionTitle">
                        {{ !empty($service->title) ? $service->title : '' }}
                    </h2>

                    <div class="text-lg leading-[30px] mt-4 mb-4 lg:mb-9">
                        {{-- <p>{{ !empty($service->subtitle) ? $service->subtitle : '' }}</p> --}}
                        <p>{{ !empty($service->short_description) ? $service->short_description : '' }}</p>
                    </div>

                    <a class="primary-btn" href="{{ url('contact') }}" data-text="Order Now"
                        title="contact button">Order Now</a>
                </div>

                <div class="lg:col-span-6 rounded-[20px] ">
                    <div class="relative">
                        @if (!empty($service->images))
                        <div
                            class="max-w-[468px] mx-auto bg-[#F2F6FF] rounded-[20px] overflow-hidden flex items-center justify-center">

                            <img class="aspect-[468/387] w-full object-contain" src="{{ asset($service->images) }}"
                                width="500" height="470" alt="{{ $service->title }}">
                        </div>

                        <div
                            class="absolute right-0 lg:right-auto xl:left-1/2  xl:translate-x-1/2 -bottom-7 bg-white rounded-[10px] border-[0.3] border-[#C8E5FB] shadow-[10px_20px_50px_0px_rgba(25,118,210,0.08)] inline-block  text-center">
                            <div class="py-4 md:py-6">
                                <img class="w-6 h-6 ring-[10px] ring-[#3C51E0] ring-opacity-10 rounded-full inline-block"
                                    src="{{ asset('public') }}/images/about/global.svg" alt="">

                                <h2 class="px-8 md:px-12 text-3xl md:text-[38px] -tracking-[2px] font-semibold mt-3">
                                    {{ !empty($service->reach) ? $service->reach : '' }}
                                </h2>

                                <span class="block text-[15px] tracking-[-0.15px]">Reach</span>

                                <h3 class="inline-flex items-center gap-1 mt-2 md:mt-[14px] text-[14px] font-bold">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                        fill="none">
                                        <path d="M1 11L11 1M11 1L4 1M11 1L11 8" stroke="#00005C" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>{{ !empty($service->reach_percent) ? $service->reach_percent : '' }}</span>
                                </h3>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
{{-- ==================================================== Services Details Sections ends
==================================== --}}

{{-- ==================================================== Testimonial Sections Begins
=================================== --}}
@include('layouts.frontend-partial.testimonial')
{{-- =================================================== Testimonial Sections endss ====================================
--}}

{{-- ==================================================== pricing section begins ====================================
--}}
@include('layouts.frontend-partial.cta-area')
{{-- ================================================= pricing section ends ==================================== --}}

{{-- ================================================= blog section begins ==================================== --}}
<section class="sectionGap pt-0">
    <div class="container">
        <div class="text-center pb-8 lg:pb-[57px]">
            <h2 class="sectionTitle">Read Our Stories</h2>
        </div>

        @include('layouts.frontend-partial.recent-blog')
    </div>
</section>
{{-- ================================================= blog section ends ==================================== --}}

{{-- ================================================= FAQ Accordion section begins ====================================
--}}
@include('layouts.frontend-partial.faq')
{{-- ================================================= FAQ Accordion section beginss
==================================== --}}
@endsection
@push('headerPartial')
<link rel="stylesheet" href="{{ asset('public') }}/vendor/css/swiper-bundle.min.css">
<style>
    #actualRating {
        --percent: calc(var(--rating) / 5 * 100%);
        width: var(--percent);
    }

    .header {
        background-color: transparent;
    }

    .swiper-pagination {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .swiper-pagination-bullets {
        bottom: auto !important;
        top: auto !important;
    }

    .swiper-pagination-bullet {
        position: relative;
        border-radius: 100%;
        width: 10px;
        height: 10px;
        text-align: center;
        opacity: 1;
        background: transparent;
        border: 1px solid #3f444b99;

    }

    .swiper-pagination-bullet::after {
        position: absolute;
        content: '';
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        height: 6px;
        width: 6px;
        background: #3f444b99;
        border-radius: 100%
    }

    .swiper-pagination-bullet.swiper-pagination-bullet-active {
        border-color: #F78721;
        height: 14px;
        width: 14px;
    }

    .swiper-pagination-bullet.swiper-pagination-bullet-active::after {
        background: #F78721;
        height: 10px;
        width: 10px;
    }
</style>
@endpush
@push('footerPartial')
<script src="{{ asset('public') }}/vendor/js/swiper-bundle.min.js"></script>
<script>
    $(document).ready(function() {
            var swiper = new Swiper('.reviewSwiper', {
                loop: true,
                autoplay: true,
                slidesPerView: 3,
                spaceBetween: 30,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.reviewSwiperNext',
                    prevEl: '.reviewSwiperPrev',
                },
                breakpoints: {
                    300: {
                        slidesPerView: 1,
                        spaceBetweenSlides: 30
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetweenSlides: 40
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetweenSlides: 30
                    }
                }
            });
        });
</script>
@endpush