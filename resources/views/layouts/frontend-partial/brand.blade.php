@if (!empty($brandInfo) && $brandInfo->isNotEmpty())
<div class="sectionGap">
    <div class="container">
        <p class="leading-[150%] text-[#5A5858] font-semibold text-center">
            1400+ BUSINESS TRUST US WITH THEIR CONTENT
        </p>
        <div class="swiper brandSlider">
            <div class="swiper-wrapper flex items-center mt-5 md:mt-8">
                @foreach ($brandInfo as $brand)
                <div class="swiper-slide group">
                    <a href="{{ !empty($brand->url) ? $brand->url : '#' }}">
                        @if (!empty($brand->images))
                        <img src="{{ asset($brand->images) }}"
                            class="h-12 w-auto object-contain grayscale group-hover:grayscale-0"
                            alt="{{ !empty($brand->title) ? $brand->title : '' }}">
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif