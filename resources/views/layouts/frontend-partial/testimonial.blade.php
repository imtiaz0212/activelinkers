@if (!empty($testimonial) && $testimonial->isNotEmpty())
<section id="testimonialPage" class="sectionGap bg-[#F6F6F6]"
    style="background: url({{asset('public')}}/images/testimonial-bg.png), linear-gradient(#e9e5ff,#e9e5ff)">
    <div class="container">
        <div class="space-y-3">
            <p class="sectionSub">Testimonial</p>
            <h2 class="sectionTitle">
                Our client say about us
            </h2>
        </div>
        <div class="relative mt-8 md:mt-[60px]">
            <div class="swiper reviewSwiper ">
                <div class="swiper-wrapper">
                    @foreach ($testimonial as $row)
                    <div class="swiper-slide">
                        <div class="px-[34px] pt-[34px] pb-7 bg-white rounded-[10px] swiper-slide">
                            <div class="flex items-center justify-between border-b pb-4">
                                <div class="flex items-center gap-5">
                                    @if (!empty($row->avatar))
                                    <img src="{{ asset($row->avatar) }}" width="65" height="65" class="rounded-full"
                                        alt="team memeber picture">
                                    @else
                                    <div
                                        class="size-16 bg-gray-100 rounded-full flex items-center justify-center text-2xl">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                            viewBox="0 0 24 24" height="1em" width="1em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g id="Image_On">
                                                <g>
                                                    <path
                                                        d="M18.435,3.06H5.565a2.5,2.5,0,0,0-2.5,2.5V18.44a2.507,2.507,0,0,0,2.5,2.5h12.87a2.507,2.507,0,0,0,2.5-2.5V5.56A2.5,2.5,0,0,0,18.435,3.06ZM4.065,5.56a1.5,1.5,0,0,1,1.5-1.5h12.87a1.5,1.5,0,0,1,1.5,1.5v8.66l-3.88-3.88a1.509,1.509,0,0,0-2.12,0l-4.56,4.57a.513.513,0,0,1-.71,0l-.56-.56a1.522,1.522,0,0,0-2.12,0l-1.92,1.92Zm15.87,12.88a1.5,1.5,0,0,1-1.5,1.5H5.565a1.5,1.5,0,0,1-1.5-1.5v-.75L6.7,15.06a.5.5,0,0,1,.35-.14.524.524,0,0,1,.36.14l.55.56a1.509,1.509,0,0,0,2.12,0l4.57-4.57a.5.5,0,0,1,.71,0l4.58,4.58Z">
                                                    </path>
                                                    <path
                                                        d="M8.062,10.565a2.5,2.5,0,1,1,2.5-2.5A2.5,2.5,0,0,1,8.062,10.565Zm0-4a1.5,1.5,0,1,0,1.5,1.5A1.5,1.5,0,0,0,8.062,6.565Z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    @endif

                                    <div class="flex flex-col gap-1">
                                        <span class=" text-2xl font-syne text-darkblue font-semibold">
                                            {{ !empty($row->name) ? $row->name : '' }}
                                        </span>
                                        <span class="text-base text-secondary">
                                            {{ !empty($row->designation) ? $row->designation : '' }}
                                        </span>
                                    </div>
                                </div>
                                <svg class="quote" width="63" height="57" viewBox="0 0 63 57" fill="#f3f4f6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M42.1438 56.1732C43.0297 55.9641 47.0287 53.8846 48.7268 52.7525C50.9293 51.2883 52.1721 50.2916 54.0301 48.4336C60.0471 42.4535 62.3235 36.1658 62.8772 24.0088C62.9633 22.2615 63.0002 17.3766 62.9756 12.0117C62.9387 3.60762 62.9264 2.93086 62.7172 2.5248C62.4219 1.94648 61.8436 1.35586 61.2283 1.02363L60.7239 0.75293L50.0803 0.752931C41.3809 0.752932 39.3506 0.789846 38.9569 0.925197C38.3539 1.13438 37.591 1.82344 37.2465 2.46328L36.9758 2.96778L36.9389 13.476C36.902 25.0301 36.8897 24.7717 37.6526 25.6945C37.8494 25.9406 38.3047 26.2852 38.6616 26.4574L39.3014 26.7773L44.3832 26.7773L49.4651 26.7773L49.4651 27.6756C49.4651 29.6443 48.9852 32.4129 48.2961 34.4801C46.7334 39.1559 44.0141 42.109 38.883 44.6807C37.8864 45.1852 36.9143 45.7512 36.6928 45.985C36.1268 46.5633 35.893 47.277 35.9545 48.2121C36.0037 48.9012 36.176 49.3441 37.468 52.0389C38.9815 55.2012 39.2645 55.6318 40.1627 56.001C40.7164 56.2348 41.5778 56.3086 42.1438 56.1732Z">
                                    </path>
                                    <path
                                        d="M7.13672 55.7795C15.4178 52.1619 21.7301 46.0096 24.5232 38.8359C25.3231 36.7934 26.0367 33.6803 26.4428 30.4688C26.9596 26.4451 27.0088 24.9316 27.0088 13.7344C27.0088 3.41074 26.9965 2.94316 26.775 2.5002C26.4797 1.89727 25.9506 1.36816 25.2984 1.02363L24.7939 0.75293L14.0889 0.752931C3.46992 0.752932 3.38379 0.752932 2.83008 1.01133C2.16563 1.31895 1.67344 1.79883 1.3043 2.47559C1.0459 2.96778 1.0459 2.99239 1.00899 13.476C0.972073 25.0301 0.959768 24.7717 1.72266 25.6945C1.91953 25.9406 2.37481 26.2852 2.73164 26.4574L3.37149 26.7773L8.51485 26.7773C13.5229 26.7773 13.6582 26.7773 13.6582 27.0111C13.6582 27.934 13.3383 30.6533 13.0922 31.8838C12.7107 33.7787 12.3047 34.9969 11.5049 36.6826C9.80684 40.251 7.22286 42.6504 2.83008 44.7668C0.566021 45.8496 0.0738336 46.4279 0.0615295 48.0029C0.0615295 48.852 0.0861382 48.9012 1.47657 51.7928C2.25176 53.3924 3.05157 54.9182 3.24844 55.1643C4.12208 56.2225 5.58633 56.4563 7.13672 55.7795Z">
                                    </path>
                                </svg>
                            </div>

                            <p class=" text-base md:text-lg mt-4 min-h-20">
                                {!! !empty($row->description) ? strLimit($row->description, 16) : '' !!}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="flex items-center justify-between mt-10">
                <div
                    class="reviewSwiperPrev shrink-0 size-10 border border-secondary text-secondary hover:text-white hover:bg-secondary  rounded-full flexCenter">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 15 15"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M1.54022 8.33623C4.06809 8.33623 6.37199 10.6692 6.37199 13.2333L6.37199 14.2842L8.44571 14.2842L8.44571 13.2333C8.44571 11.3691 7.63904 9.6204 6.37303 8.33623L14.501 8.33623L14.501 6.23448L6.37303 6.23448C7.63904 4.95031 8.44571 3.20165 8.44571 1.3374L8.44571 0.286522L6.37199 0.286523L6.37199 1.3374C6.37199 3.90048 4.06809 6.23448 1.54022 6.23448L0.503357 6.23448L0.503357 8.33623L1.54022 8.33623Z">
                        </path>
                    </svg>
                </div>
                <div class="swiper-pagination paginationBullet"></div>
                <div
                    class="reviewSwiperNext shrink-0 size-10 border border-secondary text-secondary hover:text-white hover:bg-secondary  rounded-full flexCenter rotate-180">
                    <svg width="15" height="15" fill="currentColor" class="rotate-180" viewBox="0 0 15 15"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.4629 6.23411C10.9346 6.23411 8.63034 3.90077 8.63034 1.33621V0.285156L6.55627 0.285156V1.33621C6.55627 3.20077 7.36309 4.94972 8.62931 6.23411L0.5 6.23411L0.5 8.33621H8.62931C7.36309 9.62059 6.55627 11.3695 6.55627 13.2341V14.2852H8.63034V13.2341C8.63034 10.6706 10.9346 8.33621 13.4629 8.33621H14.5V6.23411H13.4629Z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
@endif