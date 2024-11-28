@php
$heroInfo = $sectionData->where('section', 'hero')->first();
$heroInfo = (!empty($heroInfo->content) ? json_decode($heroInfo->content) : '');
@endphp

<section class="sectionGap py-20 md:py-24 lg:pt-[150px] bg-[#f3eded] relative z-[1] overflow-hidden">
    <div class="container">
        <div class="grid lg:grid-cols-12 items-center gap-4">
            <div class="lg:col-span-7">
                <h1 class="text-black font-bold text-3xl md:text-4xl lg:text-5xl xl:text-7xl !leading-[1.2]">
                    {{!empty($heroInfo->title) ? $heroInfo->title : ''}}
                </h1>
                <p
                    class="text-base md:text-lg text-black/7 mt-5 font-inter lg:mt-[30px] mb-8 lg:mb-11 [&>br]:hidden [&>br]:lg:block">
                    {!! !empty($heroInfo->subtitle) ? $heroInfo->subtitle : '' !!}
                </p>
                <div class="inline-block relative">
                    @if (!empty($heroInfo->button_link))
                    <a href="{{$heroInfo->button_link}}"
                        data-text="{{!empty($heroInfo->button_text) ? $heroInfo->button_text : 'Show more'}}"
                        class="secondary-btn ">
                        {{!empty($heroInfo->button_text) ? $heroInfo->button_text : 'Show more'}}
                    </a>
                    @endif

                    <svg class="pointer-events-none absolute -right-24 bottom-0 animate-updown"
                        xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80" fill="none">
                        <path
                            d="M63.063 15.3282C66.5791 24.3022 65.7209 36.2845 56.0755 41.066C51.5948 43.2961 45.7165 42.7767 41.9874 39.2942C39.0939 36.5906 38.9498 31.9243 43.1264 30.5951H43.1269C46.1031 29.7699 49.2923 30.4444 51.6857 32.4053C60.7308 39.714 52.7797 51.7128 44.919 55.7524C35.8055 60.4495 24.8162 60.0137 15.8165 55.3704C14.5101 54.6981 13.3557 56.6761 14.6622 57.3485C24.4215 62.3812 36.2229 62.8244 46.0743 57.7304C54.1017 53.591 60.7401 44.2964 56.6006 35.0776C55.7175 33.1134 54.3273 31.4224 52.5754 30.1801C50.8235 28.9378 48.7728 28.1898 46.6363 28.0129C43.1732 27.7225 38.7529 29.0821 37.5228 32.7329C36.0871 36.9026 39.7558 41.0041 43.1277 42.8751C46.9292 44.9406 51.4259 45.2794 55.4918 43.8069C67.3165 39.4843 69.3751 25.2032 65.2585 14.7168C64.7266 13.3653 62.5244 13.9529 63.0637 15.3279L63.063 15.3282Z"
                            fill="#DFDFDF" />
                        <path
                            d="M22.7882 64.2155C19.7983 61.5641 16.9656 58.7385 14.3046 55.7535L14.0694 57.5483C18.2471 55.381 22.2266 52.8484 25.9625 49.9797C27.1094 49.0937 25.9625 47.1003 24.8081 48.0016C21.0759 50.872 17.0985 53.4046 12.9223 55.5702C12.6209 55.7524 12.418 56.063 12.3719 56.4141C12.3264 56.7651 12.4424 57.1178 12.6871 57.3725C15.3386 60.3563 18.1606 63.182 21.14 65.8345C22.2334 66.8046 23.8588 65.1851 22.7499 64.2155L22.7882 64.2155Z"
                            fill="#DFDFDF" />
                    </svg>
                </div>
            </div>
            <div class="lg:col-span-5">
                @if (!empty($heroInfo->image))
                <img src="{{ asset($heroInfo->image) }}" width="593" height="615"
                    class="aspect-[593/615] mx-auto w-full !max-w-[593px]" />
                @endif
            </div>
        </div>
    </div>

    <div
        class="absolute z-[-2] inset-0 bg-[linear-gradient(to_right,#DFDFDF,transparent_1px),linear-gradient(to_bottom,#DFDFDF,transparent_1px)] bg-[size:50px_50px] bg-[position:-1px_-1px]">
    </div>
    <div
        class="absolute z-[-1] left-0 bottom-0 translate-y-1/2 -translate-x-1/2 size-80 bg-secondary  [filter:blur(180px)]">
    </div>
    <div
        class="absolute z-[-1] top-0 right-0 -translate-y-1/2 translate-x-1/2 size-80 bg-primary  [filter:blur(180px)]">
    </div>
</section>